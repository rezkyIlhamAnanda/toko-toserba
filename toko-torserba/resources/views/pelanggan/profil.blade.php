@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Profil Saya</h2>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ asset('storage/' . ($user->photo ?? 'default.png')) }}"
                         class="img-fluid rounded-circle mb-3"
                         width="150" height="150">
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->address }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Total Pesanan</th>
                            <td>{{ $user->orders->count() }}</td>
                        </tr>
                        <tr>
                            <th>Status Akun</th>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>
                    </table>

                    <a href="{{ route('pelanggan.editProfile') }}" class="btn btn-primary">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
