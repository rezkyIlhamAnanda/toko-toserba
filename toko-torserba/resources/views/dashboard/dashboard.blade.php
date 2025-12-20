@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Header --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-700">Dashboard</h1>
        <p class="text-gray-400">Torserba Unik Padang</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex items-center space-x-4">
            <div class="p-3 bg-[#48D1CC] rounded-full text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-gray-300 font-medium">Total Produk</h2>
                <p class="text-2xl font-bold text-gray-800 mt-1">120</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex items-center space-x-4">
            <div class="p-3 bg-yellow-400 rounded-full text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6h4v4H5v-4h4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-gray-300 font-medium">Pesanan Pending</h2>
                <p class="text-2xl font-bold text-gray-800 mt-1">15</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 flex items-center space-x-4">
            <div class="p-3 bg-green-400 rounded-full text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <h2 class="text-gray-300 font-medium">Pesanan Selesai</h2>
                <p class="text-2xl font-bold text-gray-800 mt-1">98</p>
            </div>
        </div>
    </div>

    {{-- Tabel Pesanan Terbaru --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h2 class="text-xl font-semibold text-gray-500 mb-4">Pesanan Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#48D1CC] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID Pesanan</th>
                        <th class="px-4 py-2 text-left">Pelanggan</th>
                        <th class="px-4 py-2 text-left">Total</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">ORD-001</td>
                        <td class="px-4 py-2">Budi</td>
                        <td class="px-4 py-2">Rp 250.000</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white bg-green-500 text-sm">Selesai</span>
                        </td>
                        <td class="px-4 py-2">14 Agustus 2025</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">ORD-002</td>
                        <td class="px-4 py-2">Ani</td>
                        <td class="px-4 py-2">Rp 150.000</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white bg-yellow-500 text-sm">Pending</span>
                        </td>
                        <td class="px-4 py-2">14 Agustus 2025</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">ORD-003</td>
                        <td class="px-4 py-2">Rudi</td>
                        <td class="px-4 py-2">Rp 500.000</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white bg-blue-500 text-sm">Dikirim</span>
                        </td>
                        <td class="px-4 py-2">13 Agustus 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
