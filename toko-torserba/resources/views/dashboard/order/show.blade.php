@extends('layouts.main')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-info text-white fw-bold">
            Detail Pesanan #{{ $order->id }}
        </div>
        <div class="card-body">
            <p><strong>Pelanggan:</strong> {{ optional($order->pelanggan)->name ?? '-' }}</p>
            <p><strong>Email:</strong> {{ optional($order->pelanggan)->email ?? '-' }}</p>
            <p><strong>Status:</strong>
                <span class="badge bg-{{
                    $order->shipping_status == 'diterima' ? 'success' :
                    ($order->shipping_status == 'dikirim' ? 'info' : 'warning')
                }}">
                    {{ ucfirst($order->shipping_status) }}
                </span>
            </p>
            <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

            <h5 class="mt-4">Produk Dipesan:</h5>
            <ul class="list-group mb-3">
                @foreach ($order->keranjangs as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item->product->name ?? '-' }} (x{{ $item->jumlah ?? 1 }})
                        <span>Rp {{ number_format(($item->product->price ?? 0) * ($item->jumlah ?? 1), 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>

            <h5 class="text-end fw-bold">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5>

            @if(Auth::guard('admin')->check())
                @include('pesanan._status')
            @endif

            <div class="mt-3">
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">⬅ Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
