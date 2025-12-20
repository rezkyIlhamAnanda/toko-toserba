@extends('layouts.main')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-success text-white text-center fw-bold">
            📑 Detail Transaksi
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Kode Transaksi</dt>
                <dd class="col-sm-9">{{ $transaction->transaction_code }}</dd>

                <dt class="col-sm-3">Pelanggan</dt>
                <dd class="col-sm-9">{{ $transaction->user->name }}</dd>

                <dt class="col-sm-3">Total</dt>
                <dd class="col-sm-9">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</dd>

                <dt class="col-sm-3">Status Pembayaran</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-{{ $transaction->payment_status == 'paid' ? 'success' : ($transaction->payment_status == 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($transaction->payment_status) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Metode Pembayaran</dt>
                <dd class="col-sm-9">{{ $transaction->payment_method ?? '-' }}</dd>

                <dt class="col-sm-3">Tanggal</dt>
                <dd class="col-sm-9">{{ $transaction->created_at->format('d M Y H:i') }}</dd>
            </dl>

            <div class="mt-4 text-center">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">⬅ Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
