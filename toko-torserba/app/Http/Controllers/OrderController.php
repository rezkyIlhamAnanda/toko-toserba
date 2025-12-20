<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // =========================
    // Untuk Admin
    // =========================
    public function adminIndex()
    {
        // Ambil semua order, termasuk relasi pelanggan
        $orders = Order::with('pelanggan')->orderBy('created_at', 'desc')->get();

        return view('dashboard.order.index', compact('orders'));
    }

    public function adminShow($id)
    {
        // Detail order untuk admin
        $order = Order::with('keranjangs.product', 'pelanggan')->findOrFail($id);

        return view('dashboard.order.show', compact('order'));
    }

    // =========================
    // Untuk Pelanggan
    // =========================
    public function userOrders()
    {
        $user = Auth::guard('pelanggan')->user();

        if (!$user) {
            return redirect()->route('pelanggan.login')->with('error', 'Silakan login dulu.');
        }

        $orders = Order::where('pelanggan_id', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('pelanggan.riwayat-belanja', compact('orders'));
    }

    public function userShow($id)
    {
        $user = Auth::guard('pelanggan')->user();

        $order = Order::where('id', $id)
                      ->where('pelanggan_id', $user->id)
                      ->with('keranjangs.product')
                      ->firstOrFail();

        return view('pelanggan.struk', compact('order'));
    }

    // =========================
    // Update status pesanan (admin)
    // =========================
    public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $validated = $request->validate([
        'shipping_status' => 'required|in:dikemas,dikirim,diterima',
    ]);

    $order->update($validated);

    return redirect()->route('pesanan.index')->with('success', 'Status pengiriman berhasil diperbarui');
}


    // Opsional: Hapus order (admin)
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus');
    }
}
