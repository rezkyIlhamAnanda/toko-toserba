<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar admin
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('dashboard.admin.index', compact('admins'));
    }

    /**
     * Menampilkan form tambah admin
     */
    public function create()
    {
        return view('dashboard.admin.create');
    }

    /**
     * Simpan data admin baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit admin
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('dashboard.admin.edit', compact('admin'));
    }

    /**
     * Update data admin
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
            'no_hp'    => 'nullable|string|max:20',
        ]);

        // kalau password kosong, jangan diupdate
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Hapus admin
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
