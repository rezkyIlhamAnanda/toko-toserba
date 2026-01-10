<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // Ambil Server Key dari config
        $serverKey = config('midtrans.server_key');

        // Verifikasi signature
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            Log::error('Invalid Midtrans signature for order: ' . $request->order_id);
            return response()->json(['status' => 'invalid signature'], 403);
        }

        // Cari order berdasarkan midtrans_order_id
        $order = Order::where('midtrans_order_id', $request->order_id)->first();

        if (!$order) {
            Log::error('Order not found: ' . $request->order_id);
            return response()->json(['status' => 'order not found'], 404);
        }

        // Update status berdasarkan transaction_status dari Midtrans
        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? null;

        Log::info('Midtrans callback received', [
            'order_id' => $request->order_id,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                // Transaksi berhasil (credit card)
                $order->update([
                    'status_pembayaran' => 'paid',
                    'midtrans_transaction_id' => $request->transaction_id,
                    'midtrans_transaction_status' => 'capture',
                ]);
                Log::info('Payment captured successfully for order: ' . $order->id);
            }
        } elseif ($transactionStatus == 'settlement') {
            // Transaksi settlement (berhasil)
            $order->update([
                'status_pembayaran' => 'paid',
                'midtrans_transaction_id' => $request->transaction_id,
                'midtrans_transaction_status' => 'settlement',
            ]);
            Log::info('Payment settlement for order: ' . $order->id);

        } elseif ($transactionStatus == 'pending') {
            // Transaksi pending
            $order->update([
                'status_pembayaran' => 'pending',
                'midtrans_transaction_status' => 'pending',
            ]);
            Log::info('Payment pending for order: ' . $order->id);

        } elseif ($transactionStatus == 'deny') {
            // Transaksi ditolak
            $order->update([
                'status_pembayaran' => 'failed',
                'midtrans_transaction_status' => 'deny',
            ]);
            Log::info('Payment denied for order: ' . $order->id);

        } elseif ($transactionStatus == 'expire') {
            // Transaksi kadaluarsa
            $order->update([
                'status_pembayaran' => 'failed',
                'midtrans_transaction_status' => 'expire',
            ]);
            Log::info('Payment expired for order: ' . $order->id);

        } elseif ($transactionStatus == 'cancel') {
            // Transaksi dibatalkan
            $order->update([
                'status_pembayaran' => 'failed',
                'midtrans_transaction_status' => 'cancel',
            ]);
            Log::info('Payment cancelled for order: ' . $order->id);
        }

        return response()->json(['status' => 'success']);
    }

    // Method untuk cek status pembayaran manual
    public function checkStatus($orderId)
{
    $order = Order::where('midtrans_order_id', $orderId)->firstOrFail();

    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production', false);

    try {
        $response = \Midtrans\Transaction::status($orderId);

        // Akses sebagai array
        $data = (array) $response;

        $txStatus = $data['transaction_status'] ?? null;
        $txId = $data['transaction_id'] ?? null;

        if ($txStatus == 'settlement' || $txStatus == 'capture') {
            $order->update([
                'status_pembayaran' => 'paid',
                'midtrans_transaction_status' => $txStatus,
                'midtrans_transaction_id' => $txId,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'data' => $data
            ]);
        }

        return response()->json([
            'status' => 'pending',
            'data' => $data
        ]);

    } catch (\Exception $e) {
        Log::error('Error checking Midtrans status: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}}
