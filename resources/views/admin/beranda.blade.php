@extends('admin.master')

@section('title', 'Beranda')

@section('content-header')
    <h1>
        Beranda
        <small>Admin Panel Dzakyypedia</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Beranda</a></li>
    </ol>
    @endsection

    @section('content')
    @if (session('superadmin') == true)
        <div class="row">
            <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-bullhorn fa-fw"></i> Selamat Datang di</h4>
                        <h2>
                            <b>Admin Panel Website Dzakyypedia</b>
                        </h2>
                        <hr style="border:0.5px solid #d2d6de;">
                        <p>
                            Anda login sebagai Administrator
                        </p>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>
                            {{ Rupiah::create($pendapatan_sekarang) }}
                            @if($pendapatan_kemarin != 0)
                                @if($pendapatan_sekarang < $pendapatan_kemarin)
                                    <small><i class="fa fa-arrow-down text-red"></i> <span class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 - 100 }}%</span></small>
                                @elseif($pendapatan_sekarang > $pendapatan_kemarin)
                                    <small><i class="fa fa-arrow-up text-green"></i> <span class="text-white">{{ $pendapatan_sekarang / $pendapatan_kemarin * 100 }}%</span></small>
                                @else
                                    -
                                @endif
                            @endif
                        </h3>

                        <p>Pendapatan Sekarang</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ Rupiah::create($pendapatan_kemarin) }}</h3>

                        <p>Pendapatan kemarin</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $buku }}</h3>

                        <p>Buku Tersedia</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="{{ route('list_buku') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $pengguna }}</h3>

                        <p>Pengguna Terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ route('superadmin_pengguna') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $admin }}</h3>

                        <p>Admin Terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-secret"></i>
                    </div>
                    <a href="{{ route('superadmin_admin') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $kasir }}</h3>

                        <p>Kasir Terdaftar</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{ route('superadmin_admin') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                    <div class="callout callout-success">
                        <h4><i class="fa fa-bullhorn fa-fw"></i> Selamat Datang di</h4>
                        <h2>
                            <b>Admin Panel Website Dzakyypedia</b>
                        </h2>
                        <hr style="border:0.5px solid #d2d6de;">
                        <p>
                            Anda login sebagai Kasir
                        </p>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $kategori }}</h3>

                        <p>Kategori</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tag"></i>
                    </div>
                    <a href="{{ route('kategori_buku') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $penerbit }}</h3>

                        <p>Penerbit</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-address-book"></i>
                    </div>
                    <a href="{{ route('penerbit_buku') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $buku }}</h3>

                        <p>Buku Tersedia</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="{{ route('list_buku') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

@endsection