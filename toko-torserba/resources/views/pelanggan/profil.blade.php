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
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>{{ $user->no_hp }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->alamat }}</td>
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

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profil
                    </button>
                    <!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1"
     aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('pelanggan.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text"
                                       name="nama"
                                       class="form-control"
                                       value="{{ $user->nama }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ $user->email }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="text"
                                       name="no_hp"
                                       class="form-control"
                                       value="{{ $user->no_hp }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat"
                                          class="form-control"
                                          rows="3">{{ $user->alamat }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
