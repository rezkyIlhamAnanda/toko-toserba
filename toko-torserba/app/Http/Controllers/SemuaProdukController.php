<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SemuaProdukController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get(); // tampilkan semua produk
        return view('pelanggan.semua-produk', compact('products'));
    }
}
