@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Daftar Produk</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary rounded-3">+ Tambah Produk</a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg rounded-3">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>Rp {{ number_format($product->Harga, 0, ',', '.') }}</td>
                                <td>{{ $product->stok }}</td>
                                <td class="text-center">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar {{ $product->nama_produk }}" width="60" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning rounded-3">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
