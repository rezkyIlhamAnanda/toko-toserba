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
    $pendingOrders = Order::where('payment_status', 'pending')->count();
    $completedOrders = Order::where('payment_status', 'paid')->count();
    $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');

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
