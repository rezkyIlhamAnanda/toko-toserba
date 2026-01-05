@extends('pelanggan.layouts.main')

@section('title', 'Register Pelanggan - Toko Torserba')

@section('content')
<div class="container mt-5 mb-5" style="max-width: 500px;">
    <!-- Logo dan Judul -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/unik.png') }}" alt="Torserba" style="height: 60px;">
        <hr style="width: 60%; border: 2px solid #2e2f2e; margin: 10px auto;">
        <h3 class="fw-bold text-success">DAFTAR PELANGGAN</h3>
    </div>

    <!-- Card Form -->
    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('pelanggan.register.submit') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>

                <div class="mb-3">
                    <input type="text" name="no_hp" class="form-control" placeholder="No. HP">
                </div>

                <div class="mb-3">
                    <textarea name="alamat" class="form-control" placeholder="Alamat" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                </div>

                <div class="mb-4">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
                </div>

                <button type="submit" class="btn w-100 py-2" style="background-color: #0c8a43; color: white; font-weight: bold;">
                    Daftar
                </button>
            </form>

            <p class="mt-3 text-center">
                Sudah punya akun?
                <a href="{{ route('pelanggan.login') }}" class="text-success fw-bold text-decoration-none">Login di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
