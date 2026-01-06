<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Belanja</title>
    <style>
    @page {
        margin: 0;
    }

    body {
        font-family: DejaVu Sans, monospace;
        font-size: 11px;
        width: 165px;
        margin: 0 auto;
        padding: 5px;
    }

    .center {
        text-align: center;
    }

    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 6px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 2px 0;
        vertical-align: top;
        font-size: 11px;
    }

    .total {
        font-weight: bold;
        font-size: 12px;
    }
</style>

</head>
<body>

<div class="center">
    <strong>TOKO TORSERBA UNIK PADANG</strong><br>
    <span class="small">Jl. Sutomo</span><br>
    <span class="small">Telp: 081234567</span>
</div>

<div class="line"></div>

<div class="small">
    Order ID : {{ $order->id }}<br>
    Tanggal  : {{ $order->created_at->format('d/m/Y H:i') }}<br>
    Bayar    : {{ strtoupper($order->status_pembayaran) }}<br>
    Metode   : {{ $order->payment_method ?? '-' }}
</div>

<div class="line"></div>

{{-- LIST PRODUK --}}
@foreach($order->orderItems as $item)
    <div>
        {{ $item->product->nama_produk }}
    </div>
    <div class="row small">
        <span>{{ $item->kuantitas }} x Rp{{ number_format($item->product->Harga, 0, ',', '.') }}</span>
        <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
    </div>
@endforeach

<div class="line"></div>

<div class="row">
    <span>Ongkir</span>
    <span>Rp{{ number_format($order->ongkir, 0, ',', '.') }}</span>
</div>

<div class="row total">
    <span>Total</span>
    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
</div>

<div class="line"></div>

<div class="small">
    <strong>Alamat Kirim:</strong><br>
    {{ $order->alamat }}
</div>

<div class="line"></div>

<div class="center small">
    *** TERIMA KASIH ***<br>
    Barang yang sudah dibeli<br>
    tidak dapat dikembalikan
</div>

</body>
</html>
