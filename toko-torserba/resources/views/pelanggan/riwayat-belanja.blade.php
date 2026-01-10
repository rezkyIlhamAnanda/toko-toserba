@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-center fw-bold">Riwayat Belanja</h4>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center mb-0">
            Anda belum memiliki riwayat belanja.
        </div>
    @else
        @foreach($orders as $order)
        <div class="card mb-3 shadow-sm">
            <div class="card-header py-2 d-flex justify-content-between align-items-center">
                <small class="fw-semibold">Order #{{ $order->id }}</small>
                <span class="badge
                    {{ $order->status_pembayaran == 'paid' ? 'bg-success' :
                       ($order->status_pembayaran == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($order->status_pembayaran) }}
                </span>
            </div>

            <div class="card-body py-3">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <small class="text-muted">Tanggal</small>
                        <div>{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">Total</small>
                        <div class="fw-semibold">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Alamat Pengiriman</small>
                    <div>{{ $order->alamat }}</div>
                </div>

                {{-- Alur Pengiriman --}}
                <div class="mt-2">
                    <small class="fw-semibold">Status Pengiriman</small>

                    <div class="d-flex align-items-center justify-content-between position-relative mt-3"
                         style="max-width: 320px;">

                        @php
                            $steps = ['dikemas', 'dikirim', 'selesai'];
                            $currentIndex = array_search($order->status, $steps);
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="text-center flex-fill position-relative">
                                {{-- Garis --}}
                                @if($index < count($steps) - 1)
                                    <div style="
                                        position: absolute;
                                        top: 10px;
                                        left: 50%;
                                        width: 100%;
                                        height: 3px;
                                        background-color: {{ $index < $currentIndex ? '#28a745' : '#ccc' }};
                                        transform: translateX(50%);
                                        z-index: 1;
                                    "></div>
                                @endif

                                {{-- Bulatan --}}
                                <div style="
                                    width: 18px;
                                    height: 18px;
                                    background-color: {{ $index <= $currentIndex ? '#28a745' : '#ccc' }};
                                    border-radius: 50%;
                                    margin: 0 auto;
                                    position: relative;
                                    z-index: 2;
                                "></div>

                                <small class="d-block mt-1 text-capitalize">{{ $step }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('checkout.struk.pdf', $order->id) }}"
                       class="btn btn-sm btn-primary w-50"
                       target="_blank">
                        Lihat Struk
                    </a>

                    <a href="{{ route('detail-belanja', $order->id) }}"
                       class="btn btn-sm btn-outline-success w-50">
                        Detail Belanja
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection
