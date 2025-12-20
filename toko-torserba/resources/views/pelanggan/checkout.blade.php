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
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>
                                Rp{{ number_format($item->product->price, 0, ',', '.') }}
                            </td>
                            <td>
                                Rp{{ number_format($item->jumlah * $item->product->price, 0, ',', '.') }}
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

    {{-- Form Alamat Pengiriman --}}
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-body">
                <h5>Alamat Pengiriman</h5>
                <textarea
                    name="address"
                    class="form-control"
                    rows="3"
                    placeholder="Masukkan alamat lengkap..."
                    required
                >{{ old('address') }}</textarea>
            </div>
        </div>

        {{-- Tombol Pembayaran --}}
        <button type="submit" class="btn btn-primary w-100">
            Lanjutkan Pembayaran
        </button>
    </form>
</div>
@endsection
