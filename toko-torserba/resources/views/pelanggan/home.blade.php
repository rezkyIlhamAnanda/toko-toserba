@extends('pelanggan.layouts.main')

@section('content')
<section class="py-4">
    {{-- Banner Utama - Pindahkan keluar dari container --}}
    <div class="banner-wrapper text-center mb-4">
                <img src="{{ asset('images/banners/BannerToserba.png') }}"
                     alt="Banner Utama"
                     class="img-fluid w-100"> {{-- dibikin full tanpa rounded & shadow --}}
            </div>

    <div class="container-lg">
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
                        <div class="swiper-slide">
                            <a href="#" class="text-decoration-none">
                                <div class="category-card text-center">
                                    @if($kategori->gambar)
                                        <img src="{{ asset('storage/' . $kategori->gambar) }}"
                                            class="img-category mb-2"
                                            alt="{{ $kategori->name }}">
                                    @else
                                        <img src="{{ asset('assets/img/no-image.png') }}"
                                            class="img-category mb-2"
                                            alt="No Image">
                                    @endif
                                    <h6 class="category-name">{{ $kategori->name }}</h6>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
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
                    @forelse($products->take(5) as $product)
                    <div class="swiper-slide">
                        <div class="product-card text-center">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/no-image.png') }}"
                                class="product-image mb-2"
                                alt="{{ $product->nama_produk }}">

                            <p class="fw-semibold product-name">{{ $product->nama_produk }}</p>
                            <p class="text-success fw-bold">
                                Rp {{ number_format($product->Harga,0,',','.') }}
                            </p>

                            <a href="{{ route('produk.show', $product->id) }}" class="btn btn-success btn-sm">
                                Beli
                            </a>
                        </div>
                    </div>
                    @empty
                        <p>Belum ada produk</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Banner - Full Width Tanpa Putih di Samping */
.banner-wrapper {
    width: 100%;
    max-width: 100%;
    overflow: hidden;
    padding: 0;
    margin: 0;
}

.banner-image {
    width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: cover;
    display: block;
    margin: 0;
}

/* Category Styling */
.category-swiper {
    padding: 10px 0;
    overflow: hidden;
}

.category-card {
    padding: 10px;
    transition: all 0.3s ease;
}

.img-category {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    transition: 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin: 0 auto;
    display: block;
}

.category-card:hover .img-category {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(11, 119, 61, 0.3);
}

.category-name {
    font-size: 13px;
    color: #333;
    margin-top: 8px;
    font-weight: 500;
}

/* Product Styling */
.product-swiper {
    padding: 15px 0;
    overflow: hidden;
}

.product-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
}

.product-card:hover {
    box-shadow: 0 4px 16px rgba(11, 119, 61, 0.2);
    transform: translateY(-5px);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10px;
}

.product-name {
    font-size: 15px;
    color: #333;
    margin-top: 10px;
    margin-bottom: 5px;
    min-height: 40px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Swiper Navigation Buttons */
.category-prev, .category-next,
.product-prev, .product-next {
    border-radius: 50%;
    width: 35px;
    height: 35px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: 0.3s;
    cursor: pointer;
    border: none;
}

.category-prev:hover, .category-next:hover,
.product-prev:hover, .product-next:hover {
    background: #095a2f !important;
    transform: scale(1.1);
}

/* Disabled state untuk button */
.category-prev.swiper-button-disabled,
.category-next.swiper-button-disabled,
.product-prev.swiper-button-disabled,
.product-next.swiper-button-disabled {
    opacity: 0.35;
    cursor: not-allowed;
    pointer-events: none;
}

/* Responsive */
@media(max-width: 768px) {
    .banner-image {
        max-height: 180px;
    }

    .img-category {
        width: 60px;
        height: 60px;
    }

    .category-name {
        font-size: 11px;
    }

    .product-image {
        height: 150px;
    }

    .product-name {
        font-size: 13px;
        min-height: 35px;
    }
}

@media(min-width: 769px) and (max-width: 1024px) {
    .banner-image {
        max-height: 220px;
    }

    .img-category {
        width: 70px;
        height: 70px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Swiper
    const categorySwiper = new Swiper('.category-swiper', {
    slidesPerView: 3,
    spaceBetween: 10,
    loop: false,
    navigation: {
        nextEl: '.category-next',
        prevEl: '.category-prev',
        disabledClass: 'swiper-button-disabled',
    },
    watchOverflow: true,
    breakpoints: {
        480: {
            slidesPerView: 4,
            spaceBetween: 15
        },
        768: {
            slidesPerView: 5,
            spaceBetween: 20
        },
        992: {
            slidesPerView: 6,
            spaceBetween: 20
        },
        1200: {
            slidesPerView: 8,   // ✅ DIUBAH JADI 8
            spaceBetween: 25
        }
    }
});


    // Product Swiper
    const productSwiper = new Swiper('.product-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: false,  // ✅ Tidak loop agar berhenti di ujung
        navigation: {
            nextEl: '.product-next',
            prevEl: '.product-prev',
            disabledClass: 'swiper-button-disabled',  // ✅ Tambahkan class disabled
        },
        watchOverflow: true,  // ✅ Auto disable navigation jika tidak perlu
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 25
            }
        }
    });
});
</script>
@endsection
