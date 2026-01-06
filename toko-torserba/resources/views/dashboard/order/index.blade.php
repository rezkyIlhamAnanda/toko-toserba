@extends('layouts.main')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white text-center fw-bold">
            📦 Daftar Pesanan
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <p class="text-center text-muted">Belum ada pesanan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ \Illuminate\Support\Str::substr($order->id, 0, 8) }}...</td>
                                    <td>{{ optional($order->pelanggan)->nama ?? '-' }}</td>
                                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        {{-- Form update status inline --}}
                                        <form action="{{ route('pesanan.updateStatus', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="dikemas" {{ $order->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                                <option value="diterima" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pesanan.show', $order->id) }}" class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
