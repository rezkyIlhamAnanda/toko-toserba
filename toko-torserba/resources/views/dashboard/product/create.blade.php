@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-3">
                {{-- Header warna merah --}}
                <div class="card-header text-white" style="background: linear-gradient(135deg, #dc3545, #b71c1c);">
                    <h4 class="mb-0 text-center">Tambah Produk Baru</h4>
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

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   placeholder="Masukkan nama produk" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control rounded-3"
                                   placeholder="Masukkan harga" value="{{ old('price') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control rounded-3"
                                   placeholder="Masukkan jumlah stok" value="{{ old('stock') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" rows="3" class="form-control rounded-3"
                                      placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-3">Kembali</a>
                            <button type="submit" class="btn btn-danger rounded-3">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
