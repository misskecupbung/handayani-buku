@extends('admin.master')

@section('title', 'Kategori')

@section('extra_css')

    {{ Html::style('admin_assets/components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Kelola Kategori
    <small>Manajemen kategori buku</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-tag fa-fw"></i> Kategori</li>
</ol>
@endsection

@section('content')
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
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6 col sd-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-plus fa-fw"></i> Form Tambah Kategori Buku
                </h3>
            </div>
            {!! Form::open(['route' => 'tambah_kategori']) !!}
                @csrf
                <div class="box-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori', 'Nama Kategori') !!}
                        {!! Form::text('nama_kategori', null, ['id' => 'inp_nama_kategori', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <span class="help-block">Silahkan masukan kategori buku</span>
                    </div>
                    <div class="form-group has-feedback">
                        <button type="button" id="check_kategori" class="btn btn-primary btn-block" class="form-control"><i class="fa fa-search fa-fw"></i> Periksa nama kategori</button>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group has-feedback">
                        <button type="button" id="simpan" name="simpan" value="true" class="btn btn-success btn-block form-control disabled"><i class="fa fa-check fa-fw"></i> Simpan kategori</button>

                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-list fa-fw"></i> Daftar Kategori
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_kategori">
                    <thead>
                        <tr>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_kategori as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_kategori }}</td>
                                <td id="nama_{{ $counter }}">{{ $item->nama_kategori  }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-xs edit_kategori" data-toggle="modal" data-target="#edit_kategori" id="{{ $counter }}">
                                        <i class="fa fa-edit fa-fw"></i> Edit
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs hapus_kategori" data-toggle="modal" data-target="#hapus_kategori" id="{{ $counter }}">
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
<div class="modal modal-default fade" id="edit_kategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Kategori Buku</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_kategori', 'method' => 'PUT']) !!}
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('text_id_kategori', 'ID Kategori') !!}
                        {!! Form::text('id_kategori', null, ['class' => 'form-control id_kategori', 'disabled' => '']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Nama Kategori Buku') !!}
                        {!! Form::text('nama_kategori', null, ['class' => 'form-control nama_kategori', 'autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Tutup</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-sm btn-success"><i class="fa fa-check fa-fw"></i> Simpan Perubahan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_kategori">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
                </div>
                {!! Form::open(['id' => 'form_hapus_kategori', 'method' => 'DELETE']) !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                        <button type="submit" name="simpan" value="true" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Kategori</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@section('extra_js')

    {{ Html::script('admin_assets/components/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

    <script>
        $(document).ready(function() {
            $('#table_kategori').DataTable({
                'autoWidth': true
            })
        })
    </script>

@endsection