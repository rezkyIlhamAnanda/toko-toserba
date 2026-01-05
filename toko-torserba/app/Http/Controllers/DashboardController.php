<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Statistik
    $totalProducts = Product::count();
    $pendingOrders = Order::where('status_pembayaran', 'pending')->count();
    $completedOrders = Order::where('status_pembayaran', 'paid')->count();
    $totalRevenue = Order::where('status_pembayaran', 'paid')->sum('total');

    // Pesanan terbaru
    $latestOrders = Order::latest()->take(5)->get();

    return view('dashboard.dashboard', [
        'totalProducts'   => $totalProducts,
        'pendingOrders'   => $pendingOrders,
        'completedOrders' => $completedOrders,
        'totalRevenue'    => $totalRevenue,
        'latestOrders'    => $latestOrders
    ]);
}

}
