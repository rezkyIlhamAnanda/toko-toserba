@extends('pelanggan.layouts.main')

@section('content')
<div class="container-lg py-4">

    {{-- Judul --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Semua Produk</h3>
        {{-- <a href="{{ url('/') }}" class="btn btn-outline-success btn-sm">
            ← Kembali ke Home
        </a> --}}
    </div>

    @if($products->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada produk tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card text-center h-100">
                    <img src="{{ $product->image
                            ? asset('storage/' . $product->image)
                            : asset('images/no-image.png') }}"
                        class="product-image mb-2"
                        alt="{{ $product->nama_produk }}">

                    <p class="fw-semibold product-name">
                        {{ $product->nama_produk }}
                    </p>

                    <p class="text-success fw-bold">
                        Rp {{ number_format($product->Harga,0,',','.') }}
                    </p>

                    <a href="{{ route('produk.show', $product->id) }}"
                       class="btn btn-success btn-sm w-100">
                        Beli
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

<style>
    .product-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.product-card:hover {
    box-shadow: 0 4px 16px rgba(11, 119, 61, 0.2);
    transform: translateY(-5px);
}

.product-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.product-name {
    font-size: 14px;
    min-height: 38px;
    margin: 8px 0 4px;
}

</style>
@endsection

