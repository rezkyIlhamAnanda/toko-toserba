<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Log::info('Midtrans callback masuk', $request->all());

        $order = Order::where('midtrans_order_id', $request->order_id)->first();

        if (!$order) {
            Log::error('Order not found: ' . $request->order_id);
            return response()->json(['order not found'], 404);
        }

        $serverKey = config('midtrans.server_key');

        $hashed = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            number_format($order->total, 2, '.', '') .
            $serverKey
        );

        if ($hashed !== $request->signature_key) {
            Log::error('Invalid signature', [
                'expected' => $hashed,
                'received' => $request->signature_key,
            ]);
            return response()->json(['invalid signature'], 403);
        }

        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status ?? null;

        if (in_array($transactionStatus, ['settlement', 'capture'])) {
            $order->update([
                'status_pembayaran' => 'paid',
                'midtrans_transaction_status' => $transactionStatus,
                'midtrans_transaction_id' => $request->transaction_id,
            ]);
        } elseif ($transactionStatus === 'pending') {
            $order->update([
                'status_pembayaran' => 'pending',
                'midtrans_transaction_status' => 'pending',
            ]);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            $order->update([
                'status_pembayaran' => 'failed',
                'midtrans_transaction_status' => $transactionStatus,
            ]);
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
