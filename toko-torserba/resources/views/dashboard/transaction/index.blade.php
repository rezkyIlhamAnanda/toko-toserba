@extends('layouts.main')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold">
            💳 Daftar Transaksi
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-center text-muted">Belum ada transaksi.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status Pembayaran</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $trx->transaction_code }}</td>
                                    <td>{{ $trx->user->name }}</td>
                                    <td>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $trx->payment_status == 'paid' ? 'success' : ($trx->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($trx->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $trx->payment_method ?? '-' }}</td>
                                    <td>{{ $trx->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>@extends('layouts.main')

@section('title', 'Daftar Transaksi Keuangan')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-success text-white text-center fw-bold">
            📊 Daftar Transaksi Keuangan
        </div>
        <div class="card-body">

            {{-- Filter & Tambah Data --}}
            <div class="d-flex justify-content-between mb-3">
                <form action="{{ route('transaksi.index') }}" method="GET" class="d-flex gap-2">
                    <select name="type" class="form-select">
                        <option value="">Semua</option>
                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                    <button class="btn btn-primary">Filter</button>
                </form>

                <a href="{{ route('transaksi.create') }}" class="btn btn-success">
                    + Tambah Transaksi
                </a>
            </div>

            @if($transactions->isEmpty())
                <p class="text-center text-muted">Belum ada transaksi keuangan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-success text-center">
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($transactions as $trx)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>

                                    <td class="text-center">
                                        <span class="badge bg-{{ $trx->type == 'income' ? 'success' : 'danger' }}">
                                            {{ strtoupper($trx->type) }}
                                        </span>
                                    </td>

                                    <td>{{ $trx->category }}</td>

                                    <td class="{{ $trx->type == 'income' ? 'text-success' : 'text-danger' }}">
                                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>

                                    <td>{{ $trx->description ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>
                                        <a href="{{ route('transaksi.edit', $trx->id) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <form action="{{ route('transaksi.destroy', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $transactions->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

    </div>
</div>
@endsection
