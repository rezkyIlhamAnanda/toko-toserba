<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // LIST
    public function index()
    {
        $stocks = Stock::with('product')->latest()->paginate(10);
        return view('dashboard.stok.index', compact('stocks')); // <— kirim $stocks
    }

    // FORM CREATE
    public function create()
    {
        $products = Product::orderBy('name')->get(['id','name']);
        return view('dashboard.stok.create', compact('products')); // <— create TIDAK butuh $stocks
    }

    // SIMPAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'type'       => 'required|in:in,out',
            'note'       => 'nullable|string|max:255',
        ]);

        // sesuaikan field dengan migration kamu
        Stock::create($validated);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    // EDIT
    public function edit(string $id)
    {
        $stock    = Stock::with('product')->findOrFail($id);
        $products = Product::orderBy('name')->get(['id','name']);
        return view('dashboard.stok.edit', compact('stock','products'));
    }

    // UPDATE
    public function update(Request $request, string $id)
    {
        $stock = Stock::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|integer|min:1',
            'type'       => 'required|in:in,out',
            'note'       => 'nullable|string|max:255',
        ]);

        $stock->update($validated);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    // HAPUS
    public function destroy(string $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus.');
    }
}
