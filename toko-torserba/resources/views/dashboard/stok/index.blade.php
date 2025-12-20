@extends('layouts.main')

@section('title','Stok Barang')

@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Stok</h3>
    <a href="{{ route('stok.create') }}" class="btn btn-primary rounded-3">+ Tambah </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success rounded-3">{{ session('success') }}</div>
  @endif

  <div class="card shadow-lg rounded-3">
    <div class="card-body p-4">
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-primary">
            <tr>
              <th class="text-center">#</th>
              <th>Produk</th>
              <th>Jenis</th>
              <th>Qty</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($stocks as $stock)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $stock->product?->name ?? '-' }}</td>
                <td>
                  <span class="badge bg-{{ $stock->type === 'in' ? 'success' : 'danger' }}">
                    {{ $stock->type === 'in' ? 'Masuk' : 'Keluar' }}
                  </span>
                </td>
                <td>{{ $stock->qty }}</td>
                <td>{{ $stock->note ?? '-' }}</td>
                <td>{{ $stock->created_at?->format('d M Y') }}</td>
                <td class="text-center">
                  <a href="{{ route('stok.edit', $stock->id) }}" class="btn btn-sm btn-warning rounded-3">Edit</a>
                  <form action="{{ route('stok.destroy', $stock->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger rounded-3">Hapus</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data stok</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-center mt-3">
        {{ $stocks->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
