@extends('pelanggan.layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>

    {{-- RINGKASAN --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5>Ringkasan Pesanan</h5>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($keranjang as $item)
                <tr>
                    <td>{{ $item->product->nama_produk }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp{{ number_format($item->product->Harga,0,',','.') }}</td>
                    <td>Rp{{ number_format($item->jumlah * $item->product->Harga,0,',','.') }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        {{-- PILIH ALAMAT --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Alamat Pengiriman</h5>

                {{-- SEARCH --}}
                <input
                    type="text"
                    id="searchAlamat"
                    class="form-control mb-2"
                    placeholder="Cari alamat (contoh: Jl. Sudirman Padang)"
                >

                <div id="map" style="height:350px;"></div>

                <small class="text-muted d-block mt-2">
                    Pilih alamat lewat search atau klik peta
                </small>
            </div>
        </div>

        {{-- TOMBOL HITUNG ONGKIR --}}
        <button type="button" onclick="hitungOngkir()" class="btn btn-outline-primary w-100 mb-3">
            Hitung Ongkir
        </button>

        {{-- INFO ONGKIR --}}
        <div class="card mb-3 d-none" id="ongkir-box">
            <div class="card-body">
                <p>Jarak: <strong><span id="jarak-text">0</span> km</strong></p>
                <p>Ongkir: <strong>Rp <span id="ongkir-text">0</span></strong></p>
                <h5>Total Pembayaran:
                    <strong>Rp <span id="total-text">{{ number_format($subtotal,0,',','.') }}</span></strong>
                </h5>
            </div>
        </div>

        {{-- ALAMAT DETAIL --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5>Detail Alamat</h5>
                <textarea
                    name="alamat"
                    class="form-control"
                    rows="3"
                    required
                    placeholder="Nama jalan, patokan, dll"
                ></textarea>
            </div>
        </div>

        {{-- HIDDEN --}}
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="long" id="long">
        <input type="hidden" name="ongkir" id="ongkir">

        <button type="submit" class="btn btn-primary w-100">
            Lanjutkan Pembayaran
        </button>
    </form>
</div>

{{-- LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const TOKO_LAT = -0.9466114136871914;
const TOKO_LNG = 100.37992420807208;
const SUBTOTAL = {{ $subtotal }};

let tujuanLat = null;
let tujuanLng = null;

// MAP
const map = L.map('map').setView([TOKO_LAT, TOKO_LNG], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// MARKER TOKO
L.marker([TOKO_LAT, TOKO_LNG])
    .addTo(map)
    .bindPopup('Lokasi Toko');

let markerTujuan;

// KLIK MAP
map.on('click', function (e) {
    setLokasi(e.latlng.lat, e.latlng.lng);
});

// SEARCH ALAMAT
document.getElementById('searchAlamat').addEventListener('keypress', async function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const q = this.value;

        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${q}`);
        const data = await res.json();

        if (!data.length) return alert('Alamat tidak ditemukan');

        setLokasi(data[0].lat, data[0].lon);
        map.setView([data[0].lat, data[0].lon], 15);
    }
});

function setLokasi(lat, lng) {
    tujuanLat = lat;
    tujuanLng = lng;

    if (markerTujuan) map.removeLayer(markerTujuan);

    markerTujuan = L.marker([lat, lng]).addTo(map)
        .bindPopup('Alamat Pengiriman')
        .openPopup();

    document.getElementById('lat').value = lat;
    document.getElementById('long').value = lng;
}

// HITUNG ONGKIR (BARU DI SINI)
async function hitungOngkir() {
    if (!tujuanLat || !tujuanLng) {
        alert('Pilih alamat terlebih dahulu');
        return;
    }

    const res = await fetch(
        `https://router.project-osrm.org/route/v1/driving/${TOKO_LNG},${TOKO_LAT};${tujuanLng},${tujuanLat}?overview=false`
    );
    const data = await res.json();
    const jarakKm = data.routes[0].distance / 1000;

    let ongkir = 0;
    if (jarakKm <= 5) {
        ongkir = 0;
    } else if (jarakKm <= 6) {
        ongkir = 10000;
    } else {
        ongkir = 10000 + Math.ceil(jarakKm - 6) * 3000;
    }

    document.getElementById('ongkir').value = ongkir;
    document.getElementById('jarak-text').innerText = jarakKm.toFixed(2);
    document.getElementById('ongkir-text').innerText = ongkir.toLocaleString('id-ID');
    document.getElementById('total-text').innerText =
        (SUBTOTAL + ongkir).toLocaleString('id-ID');

    document.getElementById('ongkir-box').classList.remove('d-none');
}
</script>
@endsection
