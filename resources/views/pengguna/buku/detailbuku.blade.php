@extends('pengguna.master')

@section('title', $detail->judul_buku)

<style>
    .table td, .table th {
        padding: 0.15rem !important;
    }
    .badge {
        margin: 0.3em 0em !important;
    }
</style>

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container" id="detail">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('buku') }}">Buku</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Detail</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="icon-ban"></i> ERROR!!</strong><br>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @elseif(session()->has('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }} <br>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
            </div>
            <div class="col-md-5">
                <figure class="image" style="text-align: center">
                        {{ Html::image(asset('storage/buku/'.$detail->foto_buku), $detail->judul_buku, ['class' => 'img-fluid']) }}
                </figure>
            </div>
            <div class="col-md-7">
                <h2 class="text-black"> {{ $detail->judul_buku }}</h2>
                {!! $detail->deskripsi_buku !!}
                <hr style="border:0.5px solid #fff;">
                <table class="table mb-5">
                    <tr>
                        <td><b>Penulis</b></td>
                        <td>:</td>
                        <td>{{ $detail->penulis_buku }}</td>
                    </tr>
                    <tr>
                        <td><b>Penerbit</b></td>
                        <td>:</td>
                        <td>{{ $detail->nama_penerbit }}</td>
                    </tr>
                    <tr>
                        <td><b>Kategori</b></td>
                        <td>:</td>
                        <td>{{ $detail->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <td><b>Jumlah Halaman</b></td>
                        <td>:</td>
                        <td>{{ $detail->jumlah_halaman }}</td>
                    </tr>
                    <tr>
                        <td><b>Tanggal Terbit</b></td>
                        <td>:</td>
                        <td>{{ date('d-m-Y', strtotime($detail->tanggal_terbit)) }}</td>
                    </tr>
                    <tr>
                        <td><b>ISBN</b></td>
                        <td>:</td>
                        <td>{{ $detail->ISBN }}</td>
                    </tr>
                    <tr>
                        <td><b>Bahasa</b></td>
                        <td>:</td>
                        <td>{{ $detail->bahasa_buku }}</td>
                    </tr>
                    <tr>
                        <td><b>Format</b></td>
                        <td>:</td>
                        <td>{{ $detail->format_buku }}</td>
                    </tr>
                    <tr>
                        <td><b>Berat</b></td>
                        <td>:</td>
                        <td>{{ $detail->berat_buku }} Gram</td>
                    </tr>
                    <tr>
                        <td><b>Dimensi</b></td>
                        <td>:</td>
                        <td>{{ $detail->dimensi_buku }}</td>
                    </tr>
                    <tr>
                        <td><b>Stok</b></td>
                        <td>:</td>
                        <td>{{ $detail->stok_buku }} pcs</td>
                    </tr>
                    <tr>
                        <td><b>Status</b></td>
                        <td>:</td>
                        <td>
                            @if($detail->stok_buku != 0)
                                <span class="badge badge-primary"><span class="icon-check"></span> Tersedia</span>
                            @else
                                <span class="badge badge-danger"><span class="icon-close"></span> Kosong</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Harga</b></td>
                        <td>:</td>
                        <td>
                            <strong class="text-primary"> {{ Rupiah::create($detail->harga_satuan) }} </strong>
                        </td>
                    </tr>
                </table>

            </div>
            <div class="col-md-12">
                    <hr style="border:0.5px solid #d2d6de;">
                    {{ Form::open(['route' => ['tambah_keranjang', $detail->id_buku]]) }}
                    <div class="mb-1">
                        <div class="input-group mb-3" style="max-width: 120px; margin: 0 auto;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" name="jumlah_beli" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>
                    </div>
                    @if($detail->stok_buku != 0)
                        <button type="submit" class="buy-now btn btn-sm btn-block btn-primary" name="simpan" value="true" style="max-width: 240px; margin: 0 auto;">
                            Tambah Ke Keranjang
                        </button>
                    @else
                        <button type="button" class="buy-now btn btn-sm btn-block btn-primary" style="max-width: 240px; margin: 0 auto;" disabled>
                            Stok Kosong
                        </button>
                    @endif
                    {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
