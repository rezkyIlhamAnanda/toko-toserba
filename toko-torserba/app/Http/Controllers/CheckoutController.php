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

        $subtotal = $keranjang->sum(fn($item) => $item->product->Harga * $item->jumlah);
        $shipping_cost = 0; // bisa diubah sesuai ongkir
        $total = $subtotal + $shipping_cost;



        return view('pelanggan.checkout', compact('keranjang', 'subtotal', 'total', 'user'));
    }

    /**
     * Proses checkout dan generate Snap token Midtrans
     */
    public function process(Request $request)
{
    $request->validate([
        'alamat' => 'required',
        'lat'    => 'required|numeric',
        'long'   => 'required|numeric',
        'ongkir' => 'required|numeric|min:0',
    ]);

    $user = Auth::guard('pelanggan')->user();

    $keranjang = Keranjang::with('product')
        ->where('user_id', $user->id)
        ->get();

    if ($keranjang->isEmpty()) {
        return redirect()->route('pelanggan.home')
            ->with('error', 'Keranjang kosong.');
    }

    // ✅ subtotal TETAP
    $subtotal = $keranjang->sum(fn ($item) =>
        $item->product->Harga * $item->jumlah
    );

    // ✅ TOTAL FINAL (DITAMBAH ONGKIR)
    $totalBayar = $subtotal + $request->ongkir;

    DB::beginTransaction();

    try {
        // 1️⃣ SIMPAN ORDER
        $order = Order::create([
            'pelanggan_id'      => $user->id,
            'total'             => $totalBayar, // ⬅️ PAKAI TOTAL FINAL
            'alamat'            => $request->alamat,
            'lat'               => $request->lat,
            'long'              => $request->long,
            'ongkir'            => $request->ongkir,
            'status'            => 'dikemas',
            'status_pembayaran' => 'pending',
            'payment_method'    => 'midtrans',
        ]);

        // 2️⃣ SIMPAN ORDER ITEMS (TIDAK DIUBAH)
        foreach ($keranjang as $item) {
            $order->orderItems()->create([
                'produk_id' => $item->produk_id,
                'kuantitas' => $item->jumlah,
                'subtotal'  => $item->jumlah * $item->product->Harga,
            ]);
        }

        // 3️⃣ KURANGI STOK (TIDAK DIUBAH)
        foreach ($keranjang as $item) {
            $product = $item->product;

            if ($product->stok < $item->jumlah) {
                throw new \Exception("Stok produk {$product->nama_produk} tidak mencukupi");
            }

            $product->decrement('stok', $item->jumlah);
        }

        DB::commit();

        // 4️⃣ KOSONGKAN KERANJANG
        Keranjang::where('user_id', $user->id)->delete();

    } catch (\Exception $e) {
        DB::rollBack();

        return redirect()->back()->with(
            'error',
            'Gagal memproses pesanan: ' . $e->getMessage()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MIDTRANS (TIDAK DIUBAH, HANYA TOTAL)
    |--------------------------------------------------------------------------
    */
    Config::$serverKey    = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized  = true;
    Config::$is3ds        = true;

    $midtransOrderId = 'ORDER-' . $order->id;

    $order->update([
        'midtrans_order_id' => $midtransOrderId
    ]);

    $params = [
        'transaction_details' => [
            'order_id'     => $midtransOrderId,
            'gross_amount'=> (int) $order->total, // ⬅️ TOTAL + ONGKIR
        ],
        'customer_details' => [
            'first_name' => $user->nama,
            'email'      => $user->email,
        ],
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
    } catch (\Exception $e) {
        dd('MIDTRANS ERROR: ' . $e->getMessage());
    }

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
            $order = Order::where('midtrans_order_id', $request->order_id)->first();


            if (!$order) {
                return response()->json(['error' => 'Order tidak ditemukan'], 404);
            }

            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $order->update([
                    'status_pembayaran' => 'paid',
                    'payment_method' => $request->payment_type,
                ]);
            } elseif (in_array($request->transaction_status, ['deny', 'cancel', 'expire'])) {
                $order->update(['status_pembayaran' => 'failed']);
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
