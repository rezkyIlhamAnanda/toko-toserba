@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Struk Belanja</h2>

    {{-- Info Order --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Detail Order</strong>
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
            <p><strong>Status Pembayaran:</strong>
                <span class="badge {{ $order->status_pembayaran == 'paid' ? 'bg-success' : ($order->status_pembayaran == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($order->status_pembayaran) }}
                </span>
            </p>
            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method ?? '-' }}</p>
        </div>
    </div>

    {{-- Daftar Produk --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Ringkasan Pesanan</strong>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->keranjangs as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->product->Harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->jumlah * $item->product->Harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Ongkir:</span>
                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                <span>Total:</span>
                <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

            <hr>
            <div>
                <strong>Alamat Pengiriman:</strong>
                <p>{{ $order->alamat }}</p>
            </div>
        </div>
    </div>

    <a href="{{ url('/riwayat-belanja') }}" class="btn btn-primary w-100">Lihat Riwayat Belanja</a>
</div>
@endsection
