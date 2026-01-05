<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    // 🔹 Menambahkan produk ke keranjang
    public function store(Request $request, $product_id)
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.login')
                ->with('error', 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($product_id);

        // Cek apakah produk sudah ada di keranjang user
        $keranjang = Keranjang::where('user_id', Auth::guard('pelanggan')->id())
            ->where('produk_id', $product_id)
            ->first();

        if ($keranjang) {
            // Jika sudah ada, tambahkan jumlah sesuai input
            $keranjang->jumlah += $request->jumlah;
            $keranjang->save();
        } else {
            // Jika belum ada, buat data baru
            Keranjang::create([
                'user_id'    => Auth::guard('pelanggan')->id(),
                'produk_id'  => $product_id,
                'jumlah'     => $request->jumlah,
                'Harga'      => $product->Harga,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // 🔹 Menampilkan isi keranjang
    public function index()
    {
        $keranjang = Keranjang::with('product')
            ->where('user_id', Auth::guard('pelanggan')->id())
            ->get();

        return view('pelanggan.keranjang', compact('keranjang'));
    }

    // 🔹 Mengupdate jumlah produk di keranjang
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjang = Keranjang::with('product')->findOrFail($id);

        // Pastikan jumlah tidak melebihi stok produk
        if ($request->jumlah > $keranjang->product->stok) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $keranjang->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('keranjang.index')->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    // 🔹 Menghapus item dari keranjang
    public function destroy($id)
    {
        $item = Keranjang::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
