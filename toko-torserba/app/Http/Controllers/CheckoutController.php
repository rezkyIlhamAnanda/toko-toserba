<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index()
    {
        $user = Auth::guard('pelanggan')->user();
        $keranjang = Keranjang::with('product')->where('user_id', $user->id)->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('pelanggan.home')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $keranjang->sum(fn($item) => $item->product->price * $item->jumlah);
        $shipping_cost = 0; // bisa diubah sesuai ongkir
        $total = $subtotal + $shipping_cost;

        return view('pelanggan.checkout', compact('keranjang', 'subtotal', 'total', 'user'));
    }

    /**
     * Proses checkout dan generate Snap token Midtrans
     */
    public function process(Request $request)
{
    $user = Auth::guard('pelanggan')->user();
    $keranjang = Keranjang::with('product')
        ->where('user_id', $user->id)
        ->get();

    if ($keranjang->isEmpty()) {
        return redirect()->route('pelanggan.home')
            ->with('error', 'Keranjang kosong.');
    }

    $subtotal = $keranjang->sum(fn ($item) => $item->product->price * $item->jumlah);
    $shipping_cost = 0;
    $total = $subtotal + $shipping_cost;

    DB::beginTransaction();

    try {
        // 1️⃣ Simpan order
        $order = Order::create([
            'id' => Str::uuid(),
            'pelanggan_id' => $user->id,
            'subtotal' => $subtotal,
            'shipping_cost' => $shipping_cost,
            'total_amount' => $total,
            'shipping_address' => $request->address ?? 'Alamat belum diisi',
            'payment_status' => 'pending',
        ]);

        // 2️⃣ Kurangi stok produk
        foreach ($keranjang as $item) {
            $product = $item->product;

            // Cek stok cukup
            if ($product->stock < $item->jumlah) {
                throw new \Exception("Stok produk {$product->name} tidak mencukupi");
            }

            $product->decrement('stock', $item->jumlah);
        }

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with(
            'error',
            'Gagal memproses pesanan: ' . $e->getMessage()
        );
    }

    // 3️⃣ Konfigurasi Midtrans (TIDAK DIUBAH)
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $order->id,
            'gross_amount' => $order->total_amount,
        ],
        'customer_details' => [
            'first_name' => $user->name,
            'email' => $user->email,
        ],
    ];

    $snapToken = Snap::getSnapToken($params);

    return view('pelanggan.pembayaran', compact('snapToken', 'order'));
}

     /**
     * Callback Midtrans
     */
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed === $request->signature_key) {
            $order = Order::where('id', $request->order_id)->first();

            if (!$order) {
                return response()->json(['error' => 'Order tidak ditemukan'], 404);
            }

            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => $request->payment_type,
                ]);
            } elseif (in_array($request->transaction_status, ['deny', 'cancel', 'expire'])) {
                $order->update(['payment_status' => 'failed']);
            }
        }

        return response()->json(['success' => true]);
    }


    public function struk($orderId)
{
    $user = Auth::guard('pelanggan')->user();
    $order = Order::where('id', $orderId)
                  ->where('pelanggan_id', $user->id)
                  ->firstOrFail();

    return view('pelanggan.struk', compact('order'));
}

}
