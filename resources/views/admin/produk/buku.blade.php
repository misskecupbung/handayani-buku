@extends('admin.master')

@section('title', 'Buku')

@section('extra_css')

    {{ Html::style('admin_assets/components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}
    {{ Html::style('admin_assets/components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}

    <style>
        .modal-dialog-full {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .modal-content-full {
            height: auto;
            min-height: 100%;
            border-radius: 0;
        }
    </style>

@endsection

@section('content-header')
<h1>
    Kelola Buku
    <small>Manajemen Buku</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-book fa-fw"></i> Buku</li>
</ol>
@endsection

@section('content')
{{-- Tambah buku --}}
<div class="row">
    <div class="col-md-12 col-sm-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </div>
        @elseif (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Success!</h4>
                {{ session('success') }}
            </div>
        @endif
        <div class="box box-default collapsed-box">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-plus fa-fw"></i> Form Tambah Buku
                </h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
                </div>
            </div>
            <div class="box-body row">
                {!! Form::open(['route' => 'tambah_buku', 'files' => true]) !!}
                <div class="col-sm-6">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_judul_buku', 'Judul Buku') !!}
                        {!! Form::text('judul_buku',  null, ['id' => 'inp_judul_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan judul buku</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_penulis_buku', 'Penulis Buku') !!}
                        {!! Form::text('penulis_buku',  null, ['id' => 'inp_penulis_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan nama penulis buku</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_id_kategori', 'Pilih Kategori Buku') !!}
                        <select name="id_kategori" id="inp_id_kategori" class="form-control" required>
                            <option>Pilih Kategori Buku...</option>
                            @foreach ($data_kategori as $item)
                                <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih kategori buku yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_id_penerbit', 'Pilih Penerbit Buku') !!}
                        <select name="id_penerbit" id="inp_id_penerbit" class="form-control" required>
                            <option>Pilih Penerbit Buku...</option>
                            @foreach ($data_penerbit as $item)
                                <option value="{{ $item->id_penerbit }}">{{ $item->nama_penerbit }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih penerbit buku yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_bahasa_buku', 'Bahasa Buku') !!}
                        {!! Form::text('bahasa_buku',  null, ['id' => 'inp_bahasa_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan bahasa buku</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_format_buku', 'Format Buku') !!}
                        {!! Form::text('format_buku',  null, ['id' => 'inp_format_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan format cover buku</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_dimensi_buku', 'Dimensi Buku') !!}
                        {!! Form::text('dimensi_buku',  null, ['id' => 'inp_dimensi_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan dimensi buku (format: panjang x lebar)</small></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_ISBN', 'Nomor ISBN') !!}
                        {!! Form::number('ISBN',  null, ['id' => 'inp_ISBN', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan nomor ISBN buku tanpa karakter khusus dan alphabet</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_tanggal_terbit', 'Tanggal Terbit') !!}
                        {!! Form::text('tanggal_terbit',  null, ['id' => 'inp_tanggal_terbit', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan tanggal terbit buku</small></span>
                    </div>
                    <div class="form-group has-feedback">
                            {!! Form::label('inp_jumlah_halaman', 'Jumlah Halaman') !!}
                            {!! Form::number('jumlah_halaman',  null, ['id' => 'inp_jumlah_halaman', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                            <span class="help-block"><small>Silahkan masukan jumlah halaman buku tanpa karakter khusus dan alphabet</small></span>
                        </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_berat_buku', 'Berat Buku @gram') !!}
                        {!! Form::number('berat_buku',  null, ['id' => 'inp_berat_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan berat buku dengan satuan gram</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_harga_satuan', 'Harga Satuan') !!}
                        {!! Form::number('harga_satuan',  null, ['id' => 'inp_harga_satuan', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan harga satuan buku tanpa karakter khusus dan alphabet</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_stok_buku', 'Stok Buku') !!}
                        {!! Form::number('stok_buku',  null, ['id' => 'inp_stok_buku', 'class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan stok buku tanpa karakter khusus dan alphabet</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_foto_buku', 'Foto Buku') !!}
                        {!! Form::file('foto_buku', ['id' => 'inp_foto_buku', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png', 'required']) !!}
                        <span class="help-block"><small>Silahkan pilih foto buku</small></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr style="border:0.5px solid #d2d6de;">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_deskripsi_buku', 'Deskripsi Buku') !!}
                        {!! Form::textarea('deskripsi_buku', null, ['id' => 'inp_deskripsi_buku', 'class' => 'form-control', 'required']) !!}
                        <span class="help-block"><small>Silahkan masukan deskripsi buku</small></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <button type="submit" id="simpan" name="simpan" value="true" class="btn btn-sm btn-primary pull-right">Simpan Buku</button>
                        <button type="reset" class="btn btn-sm btn-danger">Batal</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
{{-- List buku --}}
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-list fa-fw"></i> Daftar Buku
                </h3>
            </div>
            <div class="box-body">
                {{ Form::open(['method' => 'GET']) }}
                <div class="form-group">
                    <label>Filter Data Buku</label>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="kategori" class="form-control">
                                <option value>Pilih Kategori...</option>
                                @foreach ($data_kategori as $item)
                                <option value="{{ $item->nama_kategori }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="penerbit" class="form-control">
                                <option value>Pilih Penerbit...</option>
                                @foreach ($data_penerbit as $item)
                                <option value="{{ $item->nama_penerbit }}">{{ $item->nama_penerbit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">Filter</button>
                            <a class="btn btn-primary" href="{{ route('list_buku') }}">Reset</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                <table class="table table-bordered table-hover" id="table_buku">
                    <thead>
                        <tr>
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penerbit</th>
                            <th>Status</th>
                            {{-- <th>Tanggal Masuk</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_buku as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_buku }}</td>
                                <td id="judul_{{ $counter }}">{{ $item->judul_buku  }}</td>
                                <td id="kategori_{{ $counter }}">{{ $item->nama_kategori  }}</td>
                                <td id="penerbit_{{ $counter }}">{{ $item->nama_penerbit  }}</td>
                                <td>
                                    @if($item->stok_buku > 0)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Tersedia</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tidak Tersedia</span>
                                    @endif
                                </td>
                                {{-- <td id="tanggal_{{ $counter }}">{{ $item->tanggal_masuk  }}</td> --}}
                                <td>
                                    {{-- detail --}}
                                    <a href="#" class="btn btn-info btn-xs detail_buku" data-toggle="modal" data-target="#detail_buku" id="{{ $counter }}">
                                        <i class="fa fa-info fa-fw"></i> Detail
                                    </a>
                                    {{-- Edit --}}
                                    <a href="#" class="btn btn-warning btn-xs edit_buku" data-toggle="modal" data-target="#edit_buku" id="{{ $counter }}">
                                        <i class="fa fa-edit fa-fw"></i> Edit
                                    </a>
                                    {{-- Hapus --}}
                                    <a href="#" class="btn btn-danger btn-xs hapus_buku" data-toggle="modal" data-target="#hapus_buku" id="{{ $counter }}">
                                        <i class="fa fa-trash fa-fw"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php $counter++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')

{{-- Edit buku --}}
<div class="modal modal-default fade" id="edit_buku">
    <div class="modal-dialog modal-dialog-full modal-lg">
        <div class="modal-content modal-content-full">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Buku</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_buku', 'method' => 'PUT', 'files' => true]) !!}
                <div class="modal-body row">
                    @csrf
                    <div class="col-md-4 text-center">
                        {!! Form::label('inp_edit_foto_buku', 'Foto Buku') !!}
                        {{ Html::image(null, null, ['id' => 'foto_buku', 'class' => 'img-responsive', 'style' => 'margin: 0 auto;']) }}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_judul_buku', 'Judul Buku') !!}
                            {!! Form::text('judul_buku',  null, ['id' => 'inp_edit_judul_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan judul buku</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_penulis_buku', 'Penulis Buku') !!}
                            {!! Form::text('penulis_buku',  null, ['id' => 'inp_edit_penulis_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan nama penulis buku</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_id_kategori', 'Pilih Kategori Buku') !!}
                            <select name="id_kategori" id="inp_edit_id_kategori" class="form-control">
                                <option>Pilih Kategori Buku...</option>
                                <?php $counter_kategori = 1; ?>
                                @foreach ($data_kategori as $item)
                                    <option value="{{ $item->id_kategori }}" id="kategori_{{ $counter_kategori }}" class="edit_kategori">{{ $item->nama_kategori }}</option>
                                <?php $counter_kategori++; ?>
                                @endforeach
                            </select>
                            <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_id_penerbit', 'Pilih Penerbit Buku') !!}
                            <select name="id_penerbit" id="inp_edit_id_penerbit" class="form-control">
                                <option>Pilih Penerbit Buku...</option>
                                <?php $counter_penerbit = 1; ?>
                                @foreach ($data_penerbit as $item)
                                <option value="{{ $item->id_penerbit }}" id="penerbit_{{ $counter_penerbit }}" class="edit_kategori">{{ $item->nama_penerbit }}</option>
                                <?php $counter_penerbit++; ?>
                                @endforeach
                            </select>
                            <span class="help-block"><small>Silahkan pilih merk produk yang sesuai</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_bahasa_buku', 'Bahasa Buku') !!}
                            {!! Form::text('bahasa_buku',  null, ['id' => 'inp_edit_bahasa_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan bahasa buku</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_format_buku', 'Format Buku') !!}
                            {!! Form::text('format_buku',  null, ['id' => 'inp_edit_format_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan format cover buku</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_dimensi_buku', 'Dimensi Buku') !!}
                            {!! Form::text('dimensi_buku',  null, ['id' => 'inp_edit_dimensi_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan dimensi buku (format: panjang x lebar)</small></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_ISBN', 'Nomor ISBN') !!}
                            {!! Form::number('ISBN',  null, ['id' => 'inp_edit_ISBN', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan nomor ISBN buku tanpa karakter khusus dan alphabet</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_jumlah_halaman', 'Jumlah Halaman') !!}
                            {!! Form::number('jumlah_halaman',  null, ['id' => 'inp_edit_jumlah_halaman', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan jumlah halaman buku tanpa karakter khusus dan alphabet</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_tanggal_terbit', 'Tanggal Terbit') !!}
                            {!! Form::text('tanggal_terbit',  null, ['id' => 'inp_edit_tanggal_terbit', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan tanggal terbit buku</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_berat_buku', 'Berat Barang @gram') !!}
                            {!! Form::number('berat_buku',  null, ['id' => 'inp_edit_berat_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan berat barang dengan satuan gram</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_harga_satuan', 'Harga Satuan') !!}
                            {!! Form::number('harga_satuan',  null, ['id' => 'inp_edit_harga_satuan', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan harga satuan produk tanpa karakter khusus dan alphabet</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_stok_buku', 'Stok Barang') !!}
                            {!! Form::number('stok_buku',  null, ['id' => 'inp_edit_stok_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan stok produk tanpa karakter khusus dan alphabet</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_foto_buku', 'Foto Buku') !!}
                            {!! Form::file('foto_buku', ['id' => 'inp_edit_foto_buku', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            <span class="help-block"><small>Silahkan pilih foto product</small></span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr style="border:0.5px solid #d2d6de;">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_deskripsi_buku', 'Deskripsi Barang') !!}
                            {!! Form::textarea('deskripsi_buku', null, ['id' => 'inp_edit_deskripsi_buku', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan Masukan Deskripsi Buku</small></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Tutup</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-success"><i class="fa fa-check fa-fw"></i> Simpan Perubahan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Hapus Buku --}}
<div class="modal modal-default fade" id="hapus_buku">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Anda yakin ingin melanjutkan ?</h5>
            </div>
            {!! Form::open(['id' => 'form_hapus_buku', 'method' => 'DELETE']) !!}
                <div class="modal-footer">
                    @csrf
                    <button type="button" class="btn pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Buku</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Detail Buku --}}
<div class="modal modal-dafault fade" id="detail_buku">
    <div class="modal-dialog modal-dialog-full">
        <div class="modal-content modal-content-full">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail Buku</h3>
            </div>
            <div class="modal-body row">
                <div class="col-md-4 text-center">
                    <img src="" id="foto_buku" class="img-responsive" style="margin: 0 auto;">
                </div>
                <div class="col-md-8 text-center">
                    <table class="table">
                        <tr style="text-align: left">
                            <td style="width: 20%"><h4>Judul</h4></td>
                            <td style="width: 80%"><h4 class="text-muted" id="judul_buku"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Deskripsi</h4></td>
                            <td><h4 class="text-muted" id="deskripsi_buku"></h4></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr style="text-align: left">
                            <td style="width: 20%"><h4>Penulis</h4></td>
                            <td style="width: 30%"><h4 class="text-muted" id="penulis_buku"></h4></td>
                            <td style="width: 20%"><h4>Nomor ISBN</h4></td>
                            <td style="width: 30%"><h4 class="text-muted" id="ISBN"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Nama Kategori</h4></td>
                            <td><h4 class="text-muted" id="nama_kategori"></h4></td>
                            <td><h4>Jumlah Halaman</h4></td>
                            <td><h4 class="text-muted" id="jumlah_halaman"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Nama Penerbit</h4></td>
                            <td><h4 class="text-muted" id="nama_penerbit"></h4></td>
                            <td><h4>Tanggal Terbit</h4></td>
                            <td><h4 class="text-muted" id="tanggal_terbit"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Bahasa</h4></td>
                            <td><h4 class="text-muted" id="bahasa_buku"></h4></td>
                            <td><h4>Berat</h4></td>
                            <td><h4 class="text-muted" id="berat_buku"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Format Cover</h4></td>
                            <td><h4 class="text-muted" id="format_buku"></h4></td>
                            <td><h4>Harga</h4></td>
                            <td><h4 class="text-muted" id="harga_satuan"></h4></td>
                        </tr>
                        <tr style="text-align: left">
                            <td><h4>Dimensi</h4></td>
                            <td><h4 class="text-muted" id="dimensi_buku"></h4></td>
                            <td><h4>Stok</h4></td>
                            <td><h4 class="text-muted" id="stok_buku"></h4></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_js')

    {{ Html::script('admin_assets/components/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
    {{ Html::script('admin_assets/components/ckeditor/ckeditor.js') }}
    {{ Html::script('admin_assets/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_buku').DataTable({
                'lengthChange': true,
                'autoWidth': false
            })

            //Date picker
            $('#inp_tanggal_terbit').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
        })
        CKEDITOR.replace('inp_deskripsi_buku')
        CKEDITOR.replace('inp_edit_deskripsi_buku')



    </script>

@endsection