@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Detail Belanja</h2>

    {{-- Info Order --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Informasi Pesanan</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <p class="mb-1"><strong>Order ID</strong></p>
                    <span>#{{ $order->id }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-1"><strong>Tanggal</strong></p>
                    <span>{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-1"><strong>Status Pembayaran</strong></p>
                    <span class="badge
                        {{ $order->status_pembayaran == 'paid' ? 'bg-success' :
                           ($order->status_pembayaran == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                        {{ ucfirst($order->status_pembayaran) }}
                    </span>
                </div>
                <div class="col-md-6 mb-2">
                    <p class="mb-1"><strong>Metode Pembayaran</strong></p>
                    <span>{{ strtoupper($order->payment_method ?? '-') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Produk --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Ringkasan Pesanan</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td class="text-center">{{ $item->kuantitas }}</td>
                            <td class="text-end">
                                Rp{{ number_format($item->product->Harga, 0, ',', '.') }}
                            </td>
                            <td class="text-end fw-semibold">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <strong>Alamat Pengiriman</strong>
                    <p class="mb-0 text-muted">{{ $order->alamat }}</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between">
                        <span>Ongkir</span>
                        <span>Rp{{ number_format($order->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                        <span>Total</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="d-grid gap-2">
        <a href="{{ route('checkout.struk.pdf', $order->id) }}"
           class="btn btn-success" target="_blank">
            🧾 Cetak Struk (PDF)
        </a>

        <a href="{{ url('/riwayat-belanja') }}"
           class="btn btn-outline-primary">
            ← Kembali ke Riwayat Belanja
        </a>
    </div>
</div>
@endsection
