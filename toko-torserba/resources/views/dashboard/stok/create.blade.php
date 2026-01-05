@extends('layouts.main')

@section('title', 'Tambah Stok Barang')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-success text-white text-center fw-bold">
        Tambah Stok Barang
        </div>
        <div class="card-body">
            <form action="{{ route('stok.store') }}" method="POST">
                @csrf

                <!-- Pilih Produk -->
                <div class="mb-3">
                    <label for="product_id" class="form-label fw-bold">Pilih Produk</label>
                    <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-bold">Jumlah Stok</label>
                    <input type="number" name="quantity" id="quantity"
                           class="form-control @error('quantity') is-invalid @enderror"
                           min="1" required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('stok.index') }}" class="btn btn-secondary">⬅ Kembali</a>
                    <button type="submit" class="btn btn-success">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
