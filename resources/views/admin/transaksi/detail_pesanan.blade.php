@extends('admin.master')

@section('title', 'Detail Pesanan')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Detail Pesanan
    <small>Halaman detail pesanan</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home fa-fw"></i> Beranda</a></li>
    <li><a href="{{ route('pesanan_admin') }}"><i class="fa fa-shopping-cart fa-fw"></i> pesanan</a></li>
    <li class="active"><i class="fa fa-info fa-fw"></i> detail pesanan</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-shopping-cart fa-fw"></i> <b>Dzakyypedia.</b>
            <small class="pull-right">Tanggal : {{ (new DateTime)->format('d-m-Y') }} </small>
        </h2>
    </div>
  <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
        Dari
        <address>
            <strong>Dzakyypedia.</strong><br>
            Nglipar, Gunungkidul<br>
            Yogyakarta, Indonesia<br>
            No. Telepon: (+62) 878-2107-3768<br>
            Email: dzakyypedia@gmail.com
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
        Kepada,
        <address>
            <strong>{{ $data_pesanan->nama_penerima }}</strong><br>
            {{ explode('|', $data_pesanan->alamat_tujuan)[0] }}<br>
            No. Telepon : {{ $data_pesanan->no_telepon }}<br>
            Destinasi : <strong>{{ explode('|', $data_pesanan->alamat_tujuan)[1] }}</strong>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
        <b>ID Pesanan : </b>{{ $data_pesanan->id_pesanan }}<br>
        <b>Status Pesanan : </b>{{ $status[$data_pesanan->status_pesanan] }}<br>
        @if($data_pesanan->status_pesanan >= 3)
            <b>No. Resi : </b>{{ $data_pesanan->no_resi }}<br>
            <b>Waktu Dikirim : </b> <i>{{ date('H:i:s | d-m-Y', strtotime($data_pesanan->tanggal_dikirim)) }}<br>
            @if($data_pesanan->status_pesanan > 4)
                <b>Tanggal DiTerima : </b> <i>{{ date('H:i:s | d-m-Y', strtotime($data_pesanan->tanggal_diterima)) }}<br>
            @endif
        @endif
        <b>Keterangan Pesanan : </b>{{ $data_pesanan->keterangan }}
    </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Harga Satuan</th>
                    <th>Berat Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Total Berat</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal = 0; ?>
                @foreach ($data_detail as $item)
                <tr>
                    <td>{{ $item->judul_buku }}</td>
                    <td>{{ Rupiah::create($item->harga_satuan) }}</td>
                    <td>{{ $item->berat_buku }}gram</td>
                    <td>{{ $item->jumlah_beli }}</td>
                    <td>{{ $item->subtotal_berat }}gram</td>
                    <td>{{ Rupiah::create($item->subtotal_biaya) }}</td>
                </tr>
                <?php $subtotal += $item->subtotal_biaya ?>
                @endforeach
            </tbody>
        </table>
    </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
  <!-- accepted payments column -->
  <div class="col-xs-6">
    <p class="lead">Waktu Pesanan : {{ date('H:i:s | d-m-Y', strtotime($data_pesanan->tanggal_pesanan)) }}</p>
    <p class="lead">Metode Pembayaran : </p>
    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
      Transfer Bank <br>
      No. Rekening : {{ $pembayaran->bank.' '.$pembayaran->no_rekening.' a/n '.$pembayaran->atas_nama }} <br>
    </p>
  </div>
  <!-- /.col -->
  <div class="col-xs-6">

    <div class="table-responsive">
        <table class="table">
            <tr>
                <th style="width:76%">Subtotal:</th>
                <td>{{ Rupiah::create($subtotal) }}</td>
            </tr>
            <tr>
                <th>Shipping:</th>
                <td>{{ Rupiah::create($data_pesanan->ongkos_kirim) }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <?php $total = $subtotal + $data_pesanan->ongkos_kirim; ?>
                <td>{{ Rupiah::create($total) }}</td>
            </tr>
        </table>
    </div>
 </div>
  <!-- /.col -->
</div>
<!-- /.row -->
@endsection

@section('extra_js')

    {{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

    <script>
        $(document).ready(function() {
            $('#table_pesanan_di_proses').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
    </script>

@endsection
