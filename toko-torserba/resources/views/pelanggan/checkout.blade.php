@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>

    {{-- Ringkasan Pesanan --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Ringkasan Pesanan</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $item)
                        <tr>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>
                                Rp{{ number_format($item->product->Harga, 0, ',', '.') }}
                            </td>
                            <td>
                                Rp{{ number_format($item->jumlah * $item->product->Harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Total --}}
            <div class="text-end">
                <h5>
                    Total Pembayaran :
                    <strong>
                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                    </strong>
                </h5>
            </div>
        </div>
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {{-- Form Alamat Pengiriman --}}
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-body">
                <h5>Alamat Pengiriman</h5>
                <textarea
                    name="alamat"
                    class="form-control"
                    rows="3"
                    placeholder="Masukkan alamat lengkap..."
                    required
                >{{ old('alamat') }}</textarea>
            </div>
        </div>

        {{-- Tombol Pembayaran --}}
        <button type="submit" class="btn btn-primary w-100">
            Lanjutkan Pembayaran
        </button>
    </form>
</div>

@endsection
