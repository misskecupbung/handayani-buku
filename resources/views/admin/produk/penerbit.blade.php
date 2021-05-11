@extends('admin.master')

@section('title', 'Penerbit')

@section('extra_css')

    {{ Html::style('admin_assets/components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Kelola Penerbit
    <small>Manajemen penerbit buku</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-address-book fa-fw"></i> Penerbit</li>
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
    <div class="col-md-6 col-sm-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-plus fa-fw"></i> Form Tambah Penerbit Buku
                </h3>
            </div>
            {!! Form::open(['route' => 'tambah_penerbit']) !!}
                @csrf
                <div class="box-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('in_nama_penerbit', 'Nama Penerbit') !!}
                        {!! Form::text('nama_penerbit', null, ['id' => 'inp_nama_penerbit', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                        <span class="help-block">Silahkan masukan penerbit buku</span>
                    </div>
                    <div class="form-group has-feedback">
                        <button type="button" id="check_penerbit" class="btn btn-primary btn-block" class="form-control"><i class="fa fa-search fa-fw"></i> Periksa nama penerbit</button>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group has-feedback">
                        <button type="button" id="simpan" name="simpan" value="true" class="btn btn-success btn-block form-control disabled"><i class="fa fa-check fa-fw"></i> Simpan penerbit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-list fa-fw"></i> Daftar Penerbit
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_penerbit">
                    <thead>
                        <tr>
                            <th>ID Penerbit</th>
                            <th>Nama Penerbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_penerbit as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_penerbit }}</td>
                                <td id="nama_{{ $counter }}">{{ $item->nama_penerbit  }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning btn-xs edit_penerbit" data-toggle="modal" data-target="#edit_penerbit" id="{{ $counter }}">
                                        <i class="fa fa-edit fa-fw"></i> Edit
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs hapus_penerbit" data-toggle="modal" data-target="#hapus_penerbit" id="{{ $counter }}">
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
<div class="modal modal-default fade" id="edit_penerbit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Penerbit Buku</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_penerbit', 'method' => 'PUT']) !!}
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('text_id_penerbit', 'ID Penerbit') !!}
                        {!! Form::text('id_penerbit', null, ['class' => 'form-control id_penerbit', 'disabled' => '']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_penerbit_buku', 'Nama Penerbit Buku') !!}
                        {!! Form::text('nama_penerbit', null, ['class' => 'form-control nama_penerbit', 'autocomplete' => 'off']) !!}
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
<div class="modal modal-default fade" id="hapus_penerbit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
                </div>
                {!! Form::open(['id' => 'form_hapus_penerbit', 'method' => 'DELETE']) !!}
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                        <button type="submit" name="simpan" value="true" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Penerbit</button>
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
            $('#table_penerbit').DataTable({
                'autoWidth': true
            })
        })
    </script>

@endsection