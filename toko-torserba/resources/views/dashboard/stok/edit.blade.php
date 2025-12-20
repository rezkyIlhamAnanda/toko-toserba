@extends('layouts.main')

@section('title', 'Edit Stok')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-warning text-dark text-center fw-bold">
            ✏ Edit Stok Barang
        </div>
        <div class="card-body">
            <form action="{{ route('stok.update', $stok->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="product_id" class="form-label">Produk</label>
                    <input type="text" class="form-control" value="{{ $stok->product->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Jumlah Stok</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $stok->quantity }}" required min="1">
                </div>

                <button type="submit" class="btn btn-primary">💾 Update</button>
                <a href="{{ route('stok.index') }}" class="btn btn-secondary">↩ Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
