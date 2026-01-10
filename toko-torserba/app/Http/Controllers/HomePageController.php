<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Banner;    // Model Banner
use App\Models\Banners;
use App\Models\Category;  // Model Category

class HomepageController extends Controller
{
    
    public function index()
    {
        // Ambil 12 produk terbaru
        $products = Product::latest()->take(12)->get();


        $banners = Banners::all();


        $kategoris = Category::all();


        return view('pelanggan.home', compact('products', 'banners', 'kategoris'));
    }


    public function showProduct($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('home.product-detail', compact('product'));
    }

    /**
     * Tampilkan halaman cara pesan
     */
    public function howToOrder()
    {
        return view('home.how-to-order');
    }

    /**
     * Tampilkan halaman kontak
     */
    public function contact()
    {
        return view('home.contact');
    }

    /**
     * Tampilkan halaman tentang kami
     */
    public function about()
    {
        return view('home.about');
    }
}
