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
                    @foreach($order->keranjangs as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->jumlah * $item->product->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>

            <div class="d-flex justify-content-between">
                <span>Subtotal:</span>
                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span>Ongkir:</span>
                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                <span>Total:</span>
                <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>

            <hr>
            <div>
                <strong>Alamat Pengiriman:</strong>
                <p>{{ $order->shipping_address }}</p>
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
                // Payment sukses → redirect ke halaman struk
                window.location.href = '/checkout/struk/{{ $order->id }}';
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
@endsection
