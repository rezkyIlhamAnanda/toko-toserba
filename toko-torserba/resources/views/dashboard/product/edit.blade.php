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
                                   value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk" required>
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
                            <label for="price" class="form-label text-secondary fw-semibold">Harga</label>
                            <input type="number" name="price" id="price"
                                   class="form-control rounded-3 @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price) }}" placeholder="Contoh: 50000" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stok --}}
                        <div class="mb-3">
                            <label for="stock" class="form-label text-secondary fw-semibold">Stok</label>
                            <input type="number" name="stock" id="stock"
                                   class="form-control rounded-3 @error('stock') is-invalid @enderror"
                                   value="{{ old('stock', $product->stock) }}" placeholder="Jumlah stok" required>
                            @error('stock')
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
