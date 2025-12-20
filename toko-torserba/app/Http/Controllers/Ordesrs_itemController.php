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
            Order::with('user')->get()
        );
    }

    // Menyimpan pesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subtotal' => 'required|numeric|min:0',
            'shipping_cost' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
            'shipping_status' => 'in:dikemas,dikirim,diterima',
            'payment_status' => 'in:pending,paid,failed',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $order->load('user')
        ], 201);
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return response()->json($order);
    }

    // Mengupdate pesanan
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'subtotal' => 'sometimes|numeric|min:0',
            'shipping_cost' => 'sometimes|numeric|min:0',
            'total_amount' => 'sometimes|numeric|min:0',
            'shipping_address' => 'sometimes|string',
            'shipping_status' => 'sometimes|in:dikemas,dikirim,diterima',
            'payment_status' => 'sometimes|in:pending,paid,failed',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Pesanan berhasil diperbarui',
            'data' => $order->load('user')
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
