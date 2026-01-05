@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Admin</h3>
        <a href="{{ route('admin.create') }}" class="btn btn-primary rounded-3">+ Tambah Admin</a>
    </div>

    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg rounded-3">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $index => $admin)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->no_hp ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-warning rounded-3">Edit</a>

                                    <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus admin ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data admin</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
