@extends('pelanggan.layouts.main')

@section('content')
<section class="py-5">
    <div class="container-lg">
        <h3 class="fw-bold mb-4 text-success">🛒 Keranjang Belanja</h3>

        @if($keranjang->isEmpty())
            <div class="alert alert-info text-center py-5 rounded-3 shadow-sm" style="background:#E6F7FF;">
                <h5 class="mb-3 text-secondary">Keranjang Anda masih kosong</h5>
                <a href="{{ route('pelanggan.home') }}" class="btn btn-success px-4 py-2">
                    Belanja Sekarang
                </a>
            </div>
        @else
            <div class="table-responsive shadow-sm rounded-3">
                <table class="table align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th class="text-center" style="width:100px;">Gambar</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Total</th>
                            <th class="text-center" style="width:150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang as $item)
                        <tr>
                            {{-- Gambar --}}
                            <td class="text-center">
                                <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('images/no-image.png') }}"
                                     alt="{{ $item->product->name }}"
                                     class="img-thumbnail"
                                     style="width:80px; height:80px; object-fit:cover;">
                            </td>

                            {{-- Produk --}}
                            <td class="fw-semibold text-center">{{ $item->product->name }}</td>

                            {{-- Harga --}}
                            <td class="text-center text-success">
                                Rp {{ number_format($item->product->Harga, 0, ',', '.') }}
                            </td>

                            {{-- Stok --}}
                            <td class="text-center">
                                {{ $item->product->stok ?? '0' }}
                            </td>

                            {{-- Jumlah --}}
                            {{-- <td class="text-center">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group input-group-sm justify-content-center" style="width:120px;">
                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1"
                                               max="{{ $item->product->stok }}"
                                               class="form-control text-center">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </form>
                            </td> --}}

                            {{-- Jumlah (tanpa edit) --}}
                            <td class="text-center">
                                {{ $item->jumlah }}
                            </td>

                            {{-- Total --}}
                            <td class="text-center fw-bold text-success">
                                Rp {{ number_format($item->product->Harga * $item->jumlah, 0, ',', '.') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total Belanja --}}
            <div class="mt-4 d-flex justify-content-end align-items-center flex-wrap gap-3">
                <h5 class="m-0">
                    Total Belanja:
                    <span class="fw-bold text-success">
                        Rp {{ number_format($keranjang->sum(fn($i) => $i->product->Harga * $i->jumlah), 0, ',', '.') }}
                    </span>
                </h5>
                <a href="{{ route('checkout.index') }}" class="btn btn-success px-4 py-2">
                    Lanjut ke Pembayaran
                </a>
            </div>
        @endif
    </div>
</section>

<style>
.table thead th, .table tbody td {
    vertical-align: middle;
    text-align: center;
}
</style>
@endsection
