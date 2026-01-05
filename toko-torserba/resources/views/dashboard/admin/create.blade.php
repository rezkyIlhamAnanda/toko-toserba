@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg rounded-3">
                {{-- Ubah warna header sesuai sidebar --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                    <h4 class="mb-0 text-center">Tambah Admin Baru</h4>
                </div>

                <div class="card-body p-4">

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf

                        {{-- Nama Lengkap --}}
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Email Admin</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                   placeholder="Masukkan email" value="{{ old('email') }}" required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Kata Sandi</label>
                            <input type="password" name="password" class="form-control rounded-3"
                                   placeholder="Minimal 6 karakter" required>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-dark">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control rounded-3" placeholder="Minimal 6 karakter" required>
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-3">
                            <label for="no_hp" class="form-label text-dark">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control rounded-3"
                                   placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}">
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary rounded-3">Kembali</a>
                            <button type="submit" class="btn text-white rounded-3"
                                    style="background-color: #dc2626;">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
