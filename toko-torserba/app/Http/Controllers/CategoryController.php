<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.kategori.index', compact('categories'));
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.kategori.edit', compact('category'));
    }

    // Menyimpan kategori baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');

        // nama file asli
        $filename = time() . '_' . $file->getClientOriginalName();

        // simpan ke storage/app/public/categories
        $file->storeAs('categories', $filename, 'public');

        $validated['gambar'] = 'categories/' . $filename;
    }

    Category::create($validated);

    return redirect()->route('categories.index')
        ->with('success', 'Kategori berhasil dibuat!');
}

    // Mengupdate kategori
    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('gambar')) {

        // hapus gambar lama
        if ($category->gambar) {
            Storage::disk('public')->delete($category->gambar);
        }

        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('categories', $filename, 'public');

        $validated['gambar'] = 'categories/' . $filename;
    }

    $category->update($validated);

    return redirect()->route('categories.index')
        ->with('success', 'Kategori berhasil diperbarui!');
}

    // Menghapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Hapus file gambar
        if ($category->gambar) {
            Storage::disk('public')->delete($category->gambar);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
