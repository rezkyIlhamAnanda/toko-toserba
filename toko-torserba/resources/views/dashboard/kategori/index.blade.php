@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Categories</h1>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah Kategori --}}
    <div class="card mb-4">
        <div class="card-header">Tambah Kategori</div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Kategori</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>

                <button class="btn btn-primary" type="submit">Tambah</button>
            </form>
        </div>
    </div>

    {{-- Tabel Kategori --}}
    <div class="card">
        <div class="card-header">Daftar Kategori</div>
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Gambar</th>
                        <th>Nama Kategori</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $key => $category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset('images/categories/' . $category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="img-thumbnail" width="100">
                                @else
                                    <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-warning">
                                   Edit
                                </a>

                                {{-- Form Delete --}}
                                <form action="{{ route('categories.destroy', $category->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus kategori ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
