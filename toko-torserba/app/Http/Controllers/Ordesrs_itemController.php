<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
            'pelanggan_id'     => 'required|exists:pelanggans,id',
            'total'            => 'required|numeric|min:0',
            'ongkir'           => 'required|numeric|min:0',
            'lat'              => 'nullable|numeric',
            'long'             => 'nullable|numeric',
            'alamat'           => 'required|string',
            'status'           => 'in:dikemas,dikirim,selesai',
            'status_pembayaran'=> 'in:pending,paid,failed',
            'payment_method'   => 'nullable|string|max:100',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order->load('pelanggan')
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
