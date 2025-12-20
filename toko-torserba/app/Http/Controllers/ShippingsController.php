<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    // Menampilkan semua shipping
    public function index()
    {
        return response()->json(
            Shipping::with('order')->get()
        );
    }

    // Menyimpan data shipping baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id|unique:shippings,order_id',
            'courier' => 'nullable|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'status' => 'in:dikemas,dikirim,diterima',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        $shipping = Shipping::create($validated);

        return response()->json([
            'message' => 'Data pengiriman berhasil dibuat',
            'data' => $shipping->load('order')
        ], 201);
    }

    // Menampilkan detail shipping
    public function show($id)
    {
        $shipping = Shipping::with('order')->findOrFail($id);
        return response()->json($shipping);
    }

    // Mengupdate data shipping
    public function update(Request $request, $id)
    {
        $shipping = Shipping::findOrFail($id);

        $validated = $request->validate([
            'courier' => 'nullable|string|max:50',
            'tracking_number' => 'nullable|string|max:100',
            'status' => 'in:dikemas,dikirim,diterima',
            'shipped_at' => 'nullable|date',
            'delivered_at' => 'nullable|date',
        ]);

        $shipping->update($validated);

        return response()->json([
            'message' => 'Data pengiriman berhasil diperbarui',
            'data' => $shipping->load('order')
        ]);
    }

    // Menghapus data shipping
    public function destroy($id)
    {
        $shipping = Shipping::findOrFail($id);
        $shipping->delete();

        return response()->json([
            'message' => 'Data pengiriman berhasil dihapus'
        ]);
    }
}
