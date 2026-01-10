<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        return response()->json(
            Order::with('pelanggan')->get()
        );
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'pelanggan_id'      => 'required|exists:pelanggans,id',
        'total'             => 'required|numeric|min:0',
        'ongkir'            => 'required|numeric|min:0',
        'lat'               => 'nullable|numeric',
        'long'              => 'nullable|numeric',
        'alamat'            => 'required|string',
        'status'            => 'nullable|in:dikemas,dikirim,selesai',
        'status_pembayaran' => 'nullable|in:pending,paid,failed',
        'payment_method'    => 'nullable|string|max:100',
    ]);

    $user = Auth::user();

    // 🧾 Generate Midtrans Order ID (UNIK)
    $midtransOrderId = 'ORDER-' . time() . '-' . $user->id;

    // 🧾 Simpan Order ke DB
    $order = Order::create([
        'pelanggan_id'       => $user->id,
        'total'              => $validated['total'],
        'lat'                => $validated['lat'] ?? null,
        'long'               => $validated['long'] ?? null,
        'alamat'             => $validated['alamat'],
        'ongkir'             => $validated['ongkir'],
        'status'             => 'pending',
        'status_pembayaran'  => 'pending',
        'payment_method'     => 'midtrans',
        'midtrans_order_id'  => $midtransOrderId, // ✅ penting
    ]);

    // 🔧 Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = false; // true jika production
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // 💳 Parameter Snap
    $params = [
        'transaction_details' => [
            'order_id' => $order->midtrans_order_id,
            'gross_amount' => $order->total,
        ],
        'customer_details' => [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? '',
        ],
    ];

    // 🎟️ Generate Snap Token
    $snapToken = Snap::getSnapToken($params);

    return response()->json([
        'message' => 'Pesanan berhasil dibuat',
        'order_id' => $order->id,
        'midtrans_order_id' => $order->midtrans_order_id,
        'snap_token' => $snapToken,
        'data' => $order->load('pelanggan'),
    ], 201);
}

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with('pelanggan', 'orderItems.product')->findOrFail($id);
        return response()->json($order);
    }

    // Mengupdate pesanan
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'total'            => 'sometimes|numeric|min:0',
            'ongkir'           => 'sometimes|numeric|min:0',
            'lat'              => 'sometimes|numeric',
            'long'             => 'sometimes|numeric',
            'alamat'           => 'sometimes|string',
            'status'           => 'sometimes|in:dikemas,dikirim,selesai',
            'status_pembayaran'=> 'sometimes|in:pending,paid,failed',
            'payment_method'   => 'nullable|string|max:100',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Pesanan berhasil diperbarui',
            'data' => $order->load('pelanggan', 'orderItems.product')
        ]);
    }

    // Menghapus pesanan
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'message' => 'Pesanan berhasil dihapus'
        ]);
    }
}
