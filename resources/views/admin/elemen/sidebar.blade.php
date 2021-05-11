<!-- sidebar menu -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGASI</li>
    <li>
        <a href="{{ route('beranda_admin') }}">
            <i class="fa fa-home"></i>
            <span>Beranda</span>
        </a>
    </li>
    {{-- tampil bila level = admin adalah true --}}
    @if (session('superadmin') == true)
        <li class="header">SUPERADMIN</li>
        <li>
            <a href="{{ route('superadmin_admin') }}">
                <i class="fa fa-user"></i>
                <span>Kelola Admin
                    <span class="label pull-right bg-blue" id="jml_admin"></span>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('superadmin_pengguna') }}">
                <i class="fa fa-users"></i>
                <span>Kelola Pengguna
                    <span class="label pull-right bg-blue" id="jml_pengguna"></span>
                </span>
            </a>
        </li>
    @endif

    <li class="header">MANAJEMEN</li>
    <li>
        <a href="{{ route('kategori_buku') }}">
            <i class="fa fa-tag"></i>
            <span>Kategori Buku
                <span class="label pull-right bg-blue" id="jml_kategori"></span>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('penerbit_buku') }}">
            <i class="fa fa-address-book"></i>
            <span>Penerbit Buku
                <span class="label pull-right bg-blue" id="jml_penerbit"></span>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('list_buku') }}">
            <i class="fa fa-book"></i>
            <span>Produk Buku
                <span class="label pull-right bg-blue" id="jml_buku"></span>
            </span>
        </a>
    </li>

    <li class="header">TRANSAKSI</li>
    <li>
        <a href="{{ route('pembayaran_admin') }}">
            <i class="fa fa fa-money"></i>
            <span>Pembayaran
                <span class="label pull-right bg-blue" id="jml_pembayaran"></span>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('pesanan_admin') }}">
            <i class="fa fa-shopping-cart"></i>
            <span>Pesanan
                <span class="label pull-right bg-blue" id="jml_pesanan"></span>
            </span>
        </a>
    </li>
    <li>
        <a href="{{ route('pengiriman_admin') }}">
            <i class="fa fa-truck"></i>
            <span>Pengiriman
                <span class="label pull-right bg-blue" id="jml_pengiriman"></span>
            </span>
        </a>
    </li>

    @if (session('superadmin') == true)
        <li class="header">LAPORAN</li>
        <li>
            <a href="{{ route('laporan_transaksi') }}">
                <i class="fa fa-file-text"></i>
                <span>Transaksi</span>
            </a>
        </li>
    @endif
</ul>
<!-- /.sidebar-menu -->