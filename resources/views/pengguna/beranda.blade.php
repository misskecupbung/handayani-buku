@extends('pengguna.master')
@section('title', 'Beranda')
@section('content')
    <div class="site-blocks-cover" style="background-image: url({{ asset('pengguna_assets/images/banner.jpg') }});" data-aos="fade">
        <div class="container">
            <div class="row align-items-start align-items-md-center justify-content-end">
                <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                    <h1 class="mb-2 text-white">Temukan Buku Bacaan Favoritmu.</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4 text-white">Toko buku online favorit. Menjual aneka buku murah dan bermutu. Spesialis novel, cerpen, sepakbola, agama, sejarah, puisi, dan lain-lain.</p>
                        <p>
                            <a href="{{ route('buku') }}#katalog" class="btn btn-sm btn-primary">Belanja Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section site-section-sm site-blocks-1">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
                    <h2>Kenapa Harus Di Dzakyypedia?</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-truck"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Pengiriman Cepat</h2>
                        <p>Menggunakan layanan JNE dan RajaOngkir dijamin pengiriman cepat dan harga pas.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-shield"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Aman & Terpercaya</h2>
                        <p>Buku orisinal dan packing rapi, memberikan rasa aman dan terpercaya kepada pelanggan.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-help"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Layanan Pelanggan</h2>
                        <p>Melayani dengan hati, ramah dan sopan adalah motto kami. Silahkan hubungi admin di bawah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section site-blocks-2">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
                    <h2>Lihat Kategori Favorit</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item item1" href="{{ route('buku') }}?kategori=motivasi#katalog">
                        <figure class="image">
                            <img src="{{ asset('pengguna_assets/images/kategori_teknologi.jpg') }}" alt="" class="img-fluid">
                        </figure>
                        <div class="text">
                            <span class="text-uppercase">Lihat Kategori</span>
                            <h3>Motivasi</h3>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item item2" href="{{ route('buku') }}?kategori=agama#katalog">
                        <figure class="image">
                            <img src="{{ asset('pengguna_assets/images/kategori_agama.jpg') }}" alt="" class="img-fluid">
                        </figure>
                        <div class="text">
                            <span class="text-uppercase">Lihat Kategori</span>
                            <h3>Agama</h3>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item item3" href="{{ route('buku') }}?kategori=fiksi#katalog">
                        <figure class="image">
                            <img src="{{ asset('pengguna_assets/images/kategori_fantasi.jpg') }}" alt="" class="img-fluid">
                        </figure>
                        <div class="text">
                            <span class="text-uppercase">Lihat Kategori</span>
                            <h3>Fiksi</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection