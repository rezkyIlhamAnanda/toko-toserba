<!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<aside class="w-64 min-h-screen bg-gradient-to-b from-red-600 to-red-700 text-white flex flex-col shadow-xl">
    <!-- Header -->
    <div class="p-6 text-center font-extrabold text-2xl uppercase tracking-widest border-b border-white/20">
        <i class="bi bi-shop fs-3"></i>
        <span class="block text-lg font-semibold tracking-wide text-white mt-1">Toko Torserba</span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 mt-6 space-y-1 px-2">
        <a href="/admin/dashboard" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-speedometer2 text-xl"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="/admin/products" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-bag-check text-xl"></i>
            <span class="font-medium">Produk</span>
        </a>

        <a href="/admin/pesanan" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-box-seam text-xl"></i>
            <span class="font-medium">Pesanan</span>
        </a>

        {{-- <a href="/admin/transaksi" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-credit-card text-xl"></i>
            <span class="font-medium">Transaksi</span>
        </a> --}}

        <a href="/admin/kategori" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-tags text-xl"></i>
            <span class="font-medium">Categories</span>
        </a>

        <a href="/admin/admin" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-red-500 transition">
            <i class="bi bi-person-gear text-xl"></i>
            <span class="font-medium">Admin</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-white/20">
        <form method="POST" action="/admin/logout">
            @csrf
            <button type="submit"
                class="w-full py-2 px-4 bg-white text-red-600 font-bold hover:bg-gray-100 rounded-lg flex items-center justify-center gap-2 transition">
                <i class="bi bi-box-arrow-right"></i> <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
