@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-3">
                <div class="card-header text-white text-center"
                     style="background: linear-gradient(135deg, #dc2626, #b91c1c);">
                    <h4 class="mb-0">Edit Produk</h4>
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

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary fw-semibold">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                   class="form-control rounded-3 @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->nama_produk) }}" placeholder="Masukkan nama produk" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi Produk --}}
                        <div class="mb-3">
                            <label for="description" class="form-label text-secondary fw-semibold">Deskripsi Produk</label>
                            <textarea name="description" id="description"
                                      class="form-control rounded-3 @error('description') is-invalid @enderror"
                                      rows="4" placeholder="Tuliskan deskripsi produk" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Harga --}}
                        <div class="mb-3">
                            <label for="Harga" class="form-label text-secondary fw-semibold">Harga</label>
                            <input type="number" name="Harga" id="Harga"
                                   class="form-control rounded-3 @error('Harga') is-invalid @enderror"
                                   value="{{ old('Harga', $product->Harga) }}" placeholder="Contoh: 50000" required>
                            @error('Harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div class="mb-3">
                            <label for="stok" class="form-label text-secondary fw-semibold">Stok</label>
                            <input type="number" name="stok" id="stok"
                                   class="form-control rounded-3 @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $product->stok) }}" placeholder="Jumlah stok" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gambar Produk --}}
                        <div class="mb-3">
                            <label for="image" class="form-label text-secondary fw-semibold">Gambar Produk</label>
                            @if ($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk"
                                         class="img-thumbnail shadow-sm" width="150">
                                </div>
                            @endif
                            <input type="file" name="image" id="image"
                                   class="form-control rounded-3 @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-3 px-4">Kembali</a>
                            <button type="submit" class="btn text-white rounded-3 px-4"
                                    style="background-color: #dc2626; border-color: #b91c1c;">
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
