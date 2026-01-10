@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Pembayaran</h2>

    {{-- Ringkasan Pesanan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Ringkasan Pesanan</strong>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->nama_produk }}</td>
                        <td>{{ $item->kuantitas }}</td>
                        <td>Rp{{ number_format($item->product->Harga, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>


            </table>

            <hr>

            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>
                    Rp{{ number_format($order->orderItems->sum('subtotal'), 0, ',', '.') }}
                </span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Ongkir:</span>
                <span>Rp{{ number_format($order->ongkir, 0, ',', '.') }}</span>
            </div>

            <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                <span>Total:</span>
                <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

            <hr>
            <div>
                <strong>Alamat Pengiriman:</strong>
                <p>{{ $order->alamat }}</p>
            </div>
        </div>
    </div>

    {{-- Tombol Bayar --}}
    <button id="pay-button" class="btn btn-success btn-lg w-100">Bayar Sekarang</button>
</div>

{{-- Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                // redirect ke detail belanja
                window.location.href = "{{ route('detail-belanja', $order->id) }}";
            },
            onPending: function(result){
                alert('Pembayaran masih pending');
            },
            onError: function(result){
                alert('Pembayaran gagal');
            },
            onClose: function(){
                alert('Anda menutup popup pembayaran tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
<script>
    console.log("Snap Token:", "{{ $snapToken }}");
</script>


@endsection
