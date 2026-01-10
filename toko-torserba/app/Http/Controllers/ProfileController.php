<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // =========================
    // HALAMAN PROFIL
    // =========================
    public function index()
    {
        $user = Auth::guard('pelanggan')->user();

        if (!$user) {
            return redirect()->route('pelanggan.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('pelanggan.profil', compact('user'));
    }

    // =========================
    // UPDATE PROFIL PELANGGAN
    // =========================
    public function update(Request $request)
{
    /** @var \App\Models\Pelanggan $user */
    $user = Auth::guard('pelanggan')->user();

    $validated = $request->validate([
        'nama'   => 'required|string|max:255',
        'email'  => 'required|email|unique:pelanggans,email,' . $user->id,
        'no_hp'  => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
    ]);

    $user->update($validated);

    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}

}
