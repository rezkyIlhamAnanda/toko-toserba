<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('dashboard.admin.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        // Simpan session
        session([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'admin_email' => $admin->email,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Dashboard admin.
     */
    public function dashboard()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')->withErrors('Silakan login terlebih dahulu.');
        }

        return view('admin.dashboard');
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name', 'admin_email']);
        $request->session()->flush();

        return redirect()->route('admin.login')->with('success', 'Anda berhasil logout.');
    }
}
