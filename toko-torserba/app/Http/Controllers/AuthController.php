<?php

namespace App\Http\Controllers;

use App\Models\UserPelanggan;
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
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users_pelanggan,email',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = UserPelanggan::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('pelanggan')->login($user);
        session(['username' => $user->name]); // simpan nama ke session

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

            // Simpan nama pelanggan ke session
            $user = Auth::guard('pelanggan')->user();
            session(['username' => $user->name]);

            return redirect()->route('pelanggan.home')->with('success', 'Berhasil login!');
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

        // Hapus session username
        session()->forget('username');

        return redirect()->route('pelanggan.login')
            ->with('success', 'Anda telah logout');
    }
}
