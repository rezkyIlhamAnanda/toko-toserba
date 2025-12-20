<header class="bg-red-700 text-white shadow"
        x-data="{ open: false, showAuthModal: false, activeTab: 'login' }">
    <div class="max-w-7xl mx-auto flex items-center justify-between p-4">
        <!-- Logo -->
        <a href="{{ route('pelanggan.home') }}" class="text-3xl font-extrabold tracking-tight text-white">
            Torserba <span class="font-light text-yellow-300">Unik Padang</span>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-8 text-white font-medium">
            <a href="{{ route('pelanggan.home') }}" class="relative group">
                Beranda
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-white transition-all group-hover:w-full"></span>
            </a>
            <a href="{{ route('produk.index') }}" class="relative group">
                Produk
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-white transition-all group-hover:w-full"></span>
            </a>
            <a href="/cara-pesan" class="relative group">
                Cara Pesan
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-white transition-all group-hover:w-full"></span>
            </a>
            <a href="/kontak" class="relative group">
                Kontak
                <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-white transition-all group-hover:w-full"></span>
            </a>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-4">
            <!-- Keranjang -->
            <a href="{{ route('cart.index') }}" class="relative text-white hover:text-yellow-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M7 13H5.4M17 13l1.5 7M6 21h12" />
                </svg>
                <span class="absolute -top-2 -right-2 bg-yellow-300 text-red-700 rounded-full text-xs w-5 h-5 flex items-center justify-center">
                    {{ Cart::count() ?? 0 }}
                </span>
            </a>

            <!-- Profil/Login -->
            @auth('pelanggan')
                <div class="relative" x-data="{ showProfileMenu: false }">
                    <button @click="showProfileMenu = !showProfileMenu"
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-white text-red-700 shadow hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.619 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>

                    <div x-show="showProfileMenu" @click.away="showProfileMenu = false" x-transition
                         class="absolute right-0 mt-3 w-44 bg-white text-gray-800 rounded-xl shadow-xl py-2 border border-gray-200">
                        <a href="{{ route('pelanggan.profile') }}"
                           class="block px-4 py-2 hover:bg-gray-100 rounded-t-lg">Profil</a>
                        <form action="{{ route('pelanggan.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 rounded-b-lg">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('pelanggan.login') }}"
                   class="ml-4 bg-white text-red-700 px-6 py-2 rounded-full shadow-lg hover:bg-gray-200 transition font-semibold">
                    Sign in
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden ml-4" x-data="{ open: false }">
            <button @click="open = !open" class="text-white focus:outline-none">
                <svg x-show="!open" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <ul x-show="open" x-transition
                class="absolute top-16 left-0 w-full
                       bg-gradient-to-b from-red-700 via-red-600 to-red-500
                       bg-opacity-95 backdrop-blur-lg shadow-xl rounded-b-2xl
                       text-white font-medium space-y-4 p-6 z-50">
                <li><a href="{{ route('pelanggan.home') }}" class="block hover:text-yellow-300 transition">Beranda</a></li>
                <li><a href="{{ route('produk.index') }}" class="block hover:text-yellow-300 transition">Produk</a></li>
                <li><a href="/cara-pesan" class="block hover:text-yellow-300 transition">Cara Pesan</a></li>
                <li><a href="/kontak" class="block hover:text-yellow-300 transition">Kontak</a></li>
            </ul>
        </div>
    </div>
</header>
