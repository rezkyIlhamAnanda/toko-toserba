@extends('pelanggan.layouts.main')

@section('content')
<section class="py-4">
    <div class="container-lg">
        <div class="row">
            {{-- Banner Utama --}}
            <div class="banner-wrapper text-center mb-4">
                <img src="{{ asset('images/banners/Banner.png') }}"
                     alt="Banner Utama"
                     class="img-fluid w-100"> {{-- dibikin full tanpa rounded & shadow --}}
            </div>
        </div>

        {{-- Section Kategori --}}
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Kategori</h4>
                <div>
                    <button class="btn btn-sm category-prev" style="background:#0B773D; color:white;">❮</button>
                    <button class="btn btn-sm category-next" style="background:#0B773D; color:white;">❯</button>
                </div>
            </div>
            <div class="swiper category-swiper">
                <div class="swiper-wrapper">
                    @foreach($kategoris as $kategori)
                    <div class="swiper-slide text-center">
                        <a href="#">
                            <img src="{{ asset('images/categories/' . $kategori->image) }}"
                                 class="img-category mb-2"
                                 alt="{{ $kategori->nama_kategori }}">
                            <h6>{{ $kategori->nama_kategori }}</h6>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        {{-- Produk Terbaru --}}
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Produk Terbaru</h4>
                <div>
                    <button class="btn btn-sm product-prev" style="background:#0B773D; color:white;">❮</button>
                    <button class="btn btn-sm product-next" style="background:#0B773D; color:white;">❯</button>
                </div>
            </div>
            <div class="swiper product-swiper">
                <div class="swiper-wrapper">
                    @forelse($products as $product)
                    <div class="swiper-slide text-center">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                             class="img-fluid mb-2"
                             style="height:200px; object-fit:cover; border-radius:10px;">
                        <p class="fw-semibold">{{ $product->nama_produk }}</p>
                        <p class="text-success fw-bold">Rp {{ number_format($product->Harga,0,',','.') }}</p>
                        <a href="{{ route('produk.show', $product->id) }}" class="btn btn-success">Beli</a>
                    </div>
                    @empty
                        <p>Belum ada produk</p>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

<style>
/* Banner */
.banner-wrapper img { max-height: 400px; object-fit: cover; }

/* Category */
.img-category { width:100px; height:100px; object-fit:cover; border-radius:50%; transition:0.3s; }
.img-category:hover { transform: scale(1.1); }

/* Produk */
.swiper-slide img { transition:0.3s; }
.swiper-slide img:hover { transform: scale(1.05); }

/* Swiper pagination */
.swiper-pagination-bullet { background:#0B773D; opacity:0.8; }
.swiper-pagination-bullet-active { opacity:1; }

@media(max-width:768px) {
    .img-category { width:60px; height:60px; }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySwiper = new Swiper('.category-swiper', {
        slidesPerView: 6,
        spaceBetween:15,
        loop:true,
        navigation: {
            nextEl: '.category-next',
            prevEl: '.category-prev',
        },
        pagination:{ el: '.swiper-pagination', clickable:true },
        breakpoints:{
            1400:{ slidesPerView:6 },
            1200:{ slidesPerView:5 },
            992:{ slidesPerView:4 },
            768:{ slidesPerView:3 },
            480:{ slidesPerView:1 },
        }
    });

    const productSwiper = new Swiper('.product-swiper', {
        slidesPerView:4,
        spaceBetween:20,
        loop:true,
        navigation:{
            nextEl:'.product-next',
            prevEl:'.product-prev',
        },
        pagination:{ el:'.swiper-pagination', clickable:true },
        breakpoints:{
            1400:{ slidesPerView:4 },
            1200:{ slidesPerView:3 },
            992:{ slidesPerView:3 },
            768:{ slidesPerView:2 },
            480:{ slidesPerView:1 },
        }
    });
});
</script>
@endsection
