<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('pelanggan.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:pelanggans,email',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Pelanggan::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('pelanggan')->login($user);
        session(['username' => $user->nama]);

        return redirect()->route('pelanggan.home')
            ->with('success', 'Registrasi berhasil, selamat datang!');
    }

    public function showLogin()
    {
        return view('pelanggan.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('pelanggan')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('pelanggan')->user();
            session(['username' => $user->nama]);

            return redirect()->route('pelanggan.home')
                ->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget('username');

        return redirect()->route('pelanggan.login')
            ->with('success', 'Anda telah logout');
    }
}
