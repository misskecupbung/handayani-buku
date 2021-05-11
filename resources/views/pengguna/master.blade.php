<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dzakyypedia &mdash; @yield('title')</title>
    @include('pengguna.elemen.static_css')
    @yield('custom_css')
    <style>
    .site-navbar .site-navigation .site-menu > li > a.btn:hover {
        color: #ffffff;
    }
    </style>
</head>
<body>
    <div class="site-wrap">
        <header class="site-navbar" role="banner">
            <div class="site-navbar-top">
                <div class="container">
                    <div class="row align-items-center">
                        {{--  pencarian --}}
                        <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                            {{ Form::open(['route' => 'buku', 'class' => 'site-block-top-search', 'method' => 'GET']) }}
                                <span class="icon icon-search2"></span>
                                {{ Form::text('search', null, ['class' => 'form-control border-0', 'placeholder' => 'Cari Buku ...', 'autocomplete' => 'off']) }}
                                @if (!empty($_GET['kategori']))
                                    {{ Form::hidden('kategori', $_GET['kategori']) }}
                                @endif
                            {{ Form::close() }}
                        </div>
                        {{-- .pencarian --}}
                        {{-- logo --}}
                        <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                            <div class="site-logo">
                                <a href="{{ route('beranda') }}" class="js-logo-clone">Dzakyypedia</a>
                            </div>
                        </div>
                        {{-- .logo --}}
                        {{-- navigasi akun --}}
                        {{-- @if (session('email_pengguna')) --}}
                            <div class="col-6 col-md-4 order-4 order-md-3 text-right">
                                <div class="site-top-icons">
                                    <ul>
                                        @if (session('email_pengguna'))
                                        <li><a href="{{ route('info_akun') }}#akun"><span class="icon icon-person" title="Detail Akun"></span></a></li>
                                        <li>
                                            <a href="{{ route('keranjang') }}" class="site-cart" title="Keranjang">
                                                <span class="icon icon-shopping_cart"></span>
                                                <span class="count" data="keranjang"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pembayaran') }}#pembayaran" class="site-cart" title="Pembayaran">
                                                <span class="icon icon-money"></span>
                                                <span class="count" data="pembayaran"></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pesanan') }}#pesanan" class="site-cart" title="Pesanan">
                                                <span class="icon icon-shopping-basket"></span>
                                                <span class="count" data="pesanan"></span>
                                            </a>
                                        </li>
                                        @endif
                                        <li class="d-inline d-md-none ml-md-0">
                                            <a href="#" class="site-menu-toggle js-menu-toggle ml-2">
                                                <span class="icon-menu"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        {{-- @endif --}}
                        {{-- .navigasi akun --}}
                    </div>
                </div>
            </div>
            @include('pengguna.elemen.navbar')
        </header>
        @yield('breadcrumb')
        @yield('content')
        @yield('modal')
        <footer class="site-footer border-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 mb-5 mb-lg-0" id="kontak">
                        {{-- {{ Form::open(['route' => 'hubungi_kami']) }} --}}
                        <form action="{{ url('/send-message') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="footer-heading mb-4">Hubungi Kami</h3>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="nama" class="form-control" placeholder="Nama Pengguna">
                                    </div>
                                </div> --}}
                                <div class="col-md-6 col-lg-12">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email Pengguna" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12">
                                    <div class="form-group">
                                        <textarea type="text" name="message" id="message" class="form-control" placeholder="Isi Pesan" row="10" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block btn-primary" value="Kirim Pesan">
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- {{ Form::close() }} --}}
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="block-5 mb-5">
                            <h3 class="footer-heading mb-4">Info Kontak</h3>
                            <ul class="list-kontak">
                                <li class="address">Nglipar, Gunungkidul, Yogyakarta, Indonesia</li>
                                <li class="phone"><a href="https://wa.me/6287821073768?text=Hai%20Dzakyypedia,%20saya%20memiliki%20pertanyaan%20mengenai">+62 878 2107 3768</a></li>
                                <li class="email">dzakyypedia@gmail.com</li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="block-5 mb-5">
                            <h3 class="footer-heading mb-4">Tentang Kami</h3>
                            <p class="text-justify">
                                Toko buku online favorit. Menjual aneka buku murah dan bermutu. Spesialis novel, cerpen, sepakbola, agama, sejarah, puisi, dan lain-lain.
                                <p>
                                “Ilmu itu ibarat buruan (hewan liar) dan tulisan seperti tali pengikatnya. Maka ikatlah buruanmu dengan tali yang kuat.” Imam Syafi’i
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row pt-5 mt-5 text-center">
                    <div class="col-md-12">
                        <p>
                        Copyright &copy;<script data-cfasync="false" src="#"></script><script>document.write(new Date().getFullYear());</script> Dzakyypedia. All rights reserved
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    @include('pengguna.elemen.static_js')
    @yield('custom_js')
    <script>
         $(document).ready(function(){
            $.get('{{ route('get_kategori') }}').done(function(data){
                var elemen = ''
                var index  = 1
                for(var values of data) {
                    var slug = values.replace(' ', '-').toLowerCase()
                    elemen += '<li><a href="{{ route('buku') }}?kategori='+slug+'">'+values+'</a></li>'
                }
                $('ul#kategori').html(elemen)
            })
            $.get('{{ route('data_counter') }}').done(function(data){
                for(var key in data){
                    $('span[data="'+key+'"]').html(data[key])
                }
            })
        })
    </script>
</body>
</html>