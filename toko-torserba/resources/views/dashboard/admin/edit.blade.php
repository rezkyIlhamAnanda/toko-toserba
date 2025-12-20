@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-lg rounded-3">
                {{-- 🔴 Ubah warna header agar sama seperti sidebar --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #dc2626, #7f1d1d);">
                    <h4 class="mb-0 text-center">Edit Admin</h4>
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

                    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   value="{{ old('name', $admin->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Admin</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                   value="{{ old('email', $admin->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi (Kosongkan jika tidak ingin diubah)</label>
                            <input type="password" name="password" class="form-control rounded-3" placeholder="Isi jika ingin ganti password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi jika diisi">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor HP</label>
                            <input type="text" name="phone" class="form-control rounded-3"
                                   value="{{ old('phone', $admin->phone) }}">
                        </div>

                        {{-- 🔴 Tombol disamakan dengan warna sidebar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.index') }}" class="btn btn-secondary rounded-3">Kembali</a>
                            <button type="submit" class="btn text-white rounded-3"
                                style="background: linear-gradient(135deg, #dc2626, #7f1d1d); border: none;">
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
