<footer class="bg-light text-center text-lg-start">
    <div class="container p-4">
        <div class="row d-flex flex-wrap">

            <!-- Kolom Pertama -->
            @guest('web')
            @guest('pelanggan')
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0 d-flex flex-column align-items-lg-start align-items-center text-center text-lg-start">
                <a href="/" class="mb-3">
                    <img src="{{ asset('images/pdg.png') }}" alt="torserba unik padang Logo" class="img-fluid" style="max-width: 200px;">
                </a>
                <p class="text-justify mx-lg-0 mx-auto" style="line-height: 1.5; font-size: 13px; color: #0B773D; font-weight: normal; max-width: 600px;">
                    Toserba Unik Padang hadir sebagai solusi belanja modern yang lengkap dan terpercaya. Kami menyediakan berbagai macam kebutuhan sehari-hari mulai dari perlengkapan rumah tangga, makanan, minuman, produk fashion, hingga barang unik lainnya.
                </p>
                <!-- Icon Media Sosial -->
                <div class="p-3">
                    <a href="https://www.instagram.com/perlengkapanunik_pdg" target="_blank" class="me-3">
                        <i class="fab fa-instagram" style="font-size: 24px; color: #0E733D;"></i>
                    </a>
                    <a href="https://wa.me/6281244323035" target="_blank">
                        <i class="fab fa-whatsapp" style="font-size: 24px; color: #0E733D;"></i>
                    </a>
                </div>
            </div>
            @endguest
            @endguest

            <!-- Kolom Kedua -->
            <div class="col-lg-6 col-md-10 mb-4 mb-md-0 text-center text-lg-start">
                <h6 class="text-uppercase">Alamat</h6>
                <p style="line-height: 1.5; font-size: 13px; color: #0B773D; font-weight: normal;">
                    Toserba Unik Padang<br>
                    Lokasi: Jl. Dokter Sutomo I, Kubu Marapalam, Kec. Padang Tim., Kota Padang, Sumatera Barat 25143
                </p>

                @guest('web')
                @guest('pelanggan')
                <!-- Google Maps Iframe -->
                <div class="ratio" style="height: 200px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.273365132836!2d100.3773814736039!3d-0.9469922353465747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b9703b0754f3%3A0x40143884f1098ab3!2sToserbaunikpadang!5e0!3m2!1sid!2sid!4v1758710261005!5m2!1sid!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                @endguest
                @endguest
            </div>
        </div>
    </div>

    <div class="text-center p-3" style="background-color: #0E733D; color: white;">
        © {{ date('Y') }} Toserba Unik Padang. All rights reserved.
    </div>
</footer>
