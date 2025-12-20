@extends('pelanggan.layouts.main')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 text-center">
                <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/no-image.png') }}"
                     alt="{{ $product->name }}"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="col-md-7">
                <h3 class="fw-bold mb-3">{{ $product->name }}</h3>
                <h4 class="text-success mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                <p>{{ $product->description ?? 'Tidak ada deskripsi untuk produk ini.' }}</p>

<form action="{{ route('keranjang.store', $product->id) }}" method="POST" class="mt-4">
    @csrf

                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="d-flex align-items-center mb-3">
                        <label for="jumlah" class="me-2">Jumlah:</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control w-auto" min="1" value="1">
                    </div>
                    <button type="submit" class="btn btn-success px-4 py-2">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
