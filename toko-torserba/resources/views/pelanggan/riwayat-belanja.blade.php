@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Riwayat Belanja</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center">
            Anda belum memiliki riwayat belanja.
        </div>
    @else
        @foreach($orders as $order)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Order ID: {{ $order->id }}</span>
                <span class="badge
                    {{ $order->status_pembayaran == 'paid' ? 'bg-success' : ($order->status_pembayaran == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($order->status_pembayaran) }}
                </span>
            </div>

            <div class="card-body">
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
                <p><strong>Total:</strong> Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->alamat }}</p>

                {{-- Alur Pengiriman --}}
                <div class="mt-3">
                    <strong>Status Pengiriman:</strong>
                    <div class="d-flex align-items-center justify-content-between position-relative mt-4" style="max-width: 400px; margin: 0 auto;">
                        @php
                            $steps = ['dikemas', 'dikirim', 'diterima'];
                            $currentIndex = array_search($order->shipping_status, $steps);
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="text-center flex-fill position-relative">
                                {{-- Garis konektor (hanya ditampilkan sebelum step terakhir) --}}
                                @if($index < count($steps) - 1)
                                    <div style="
                                        position: absolute;
                                        top: 12px;
                                        left: 50%;
                                        width: 100%;
                                        height: 4px;
                                        background-color: {{ $index < $currentIndex ? '#28a745' : '#ccc' }};
                                        z-index: 1;
                                        transform: translateX(50%);
                                    "></div>
                                @endif

                                {{-- Bulatan --}}
                                <div style="
                                    width: 25px;
                                    height: 25px;
                                    background-color: {{ $index <= $currentIndex ? '#28a745' : '#ccc' }};
                                    border-radius: 50%;
                                    margin: 0 auto;
                                    position: relative;
                                    z-index: 2;
                                "></div>

                                <small class="d-block mt-2 text-capitalize">{{ $step }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('checkout.struk.pdf', $order->id) }}"
                        class="btn btn-primary w-50"
                        target="_blank">
                        Lihat Struk
                    </a>

                    <a href="{{ route('detail-belanja', $order->id) }}" class="btn btn-outline-success w-50">
                        Detail Belanja
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
