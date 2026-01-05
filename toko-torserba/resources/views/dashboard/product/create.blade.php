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
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control rounded-3"
                                   placeholder="Masukkan nama produk" value="{{ old('nama_produk') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="Harga" class="form-label">Harga</label>
                            <input type="number" name="Harga" class="form-control rounded-3"
                                   placeholder="Masukkan Harga" value="{{ old('Harga') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control rounded-3"
                                   placeholder="Masukkan jumlah stok" value="{{ old('stok') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <input type="file" name="image" class="form-control rounded-3" accept="image/*">
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
