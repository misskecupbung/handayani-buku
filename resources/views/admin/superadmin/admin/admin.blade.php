@extends('admin.master')

@section('title', 'Manajemen Admin')

@section('extra_css')

    {{ Html::style('admin_assets/components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

    <style>
    .profile-user-img {
        margin: 0 auto;
        width: 200px;
        padding: 3px;
        border: 3px solid #d2d6de;
    }
    </style>

@endsection

@section('content-header')
<h1>
    Kelola Admin
    <small>Manajemen akun admin</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-user fa-fw"></i> Kelola Admin</li>
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
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title">
                    <i class="fa fa-list fa-fw"></i> Daftar Akun Admin
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah_admin">
                        <i class="fa fa-plus fa-fw"></i> Tambah Akun
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_admin">
                    <thead>
                        <tr>
                            <th style="width: 15%">ID Admin</th>
                            <th style="width: 25%">Nama Admin</th>
                            <th style="width: 15%">Status Level</th>
                            <th style="width: 15%">Status Blokir</th>
                            <th style="width: 30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_admin as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_admin }}</td>
                                <td>{{ $item->nama_lengkap  }}</td>
                                <td>
                                    @if ($item->superadmin == true)
                                        <span class="label bg-green"><i class="fa fa-user fa-fw"></i> Admin</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-user fa-fw"></i> Kasir</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->diblokir == true)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Ya</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- detail --}}
                                    <a href="#" class="btn btn-info btn-xs detail_admin" data-toggle="modal" data-target="#detail_admin" id="{{ $counter }}">
                                        <i class="fa fa-info fa-fw"></i> Detail
                                    </a>
                                    @if(session('id_admin') != $item->id_admin)
                                        {{-- edit --}}
                                        <a href="#" class="btn btn-success btn-xs ubah_status_admin" data-toggle="modal" data-target="#ubah_status_admin" id="{{ $counter }}">
                                            <i class="fa fa-edit fa-fw"></i> Edit
                                        </a>
                                        @if($item->diblokir)
                                            <a class="btn btn-warning btn-xs" href="{{ route('blokir_admin', ['id_admin' => $item->id_admin]) }}">
                                                <i class="fa fa-unlock fa-fw"></i> Unblock
                                            </a>
                                        @else
                                            <a class="btn btn-warning btn-xs" href="{{ route('blokir_admin', ['id_admin' => $item->id_admin]) }}">
                                                <i class="fa fa-lock fa-fw"></i> Block
                                            </a>
                                        @endif
                                        <a href="#" class="btn btn-danger btn-xs hapus_admin" data-toggle="modal" data-target="#hapus_admin" id="{{ $counter }}">
                                            <i class="fa fa-trash fa-fw"></i> Delete
                                        </a>
                                    @endif
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
<div class="modal modal-default fade" id="tambah_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Admin</h4>
            </div>
            {!! Form::open(['route' => 'tambah_admin', 'id' => 'form_tambah_admin', 'files' => true]) !!}
                <div class="modal-body row">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_nama_admin', 'Nama Lengkap Admin') !!}
                            {!! Form::text('nama_lengkap',  null, ['id' => 'inp_nama_admin', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            <span class="help-block"><small>Masukan nama lengkap</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_foto_admin', 'Foto Admin') !!}
                            {!! Form::file('foto', ['id' => 'inp_foto_admin', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            <span class="help-block"><small>Silahkan pilih foto</small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_email_aktif', 'Email Aktif') !!}
                            {!! Form::email('email',  null, ['id' => 'inp_email_aktif', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            <span class="help-block"><small>Silahkan masukan email aktif </small></span>
                        </div>

                        <div class="form-group has-feedback">
                            {!! Form::label('inp_password', 'Password') !!}
                            {!! Form::password('password', ['id' => 'inp_password', 'class' => 'form-control', 'autocomplete' => 'off']) !!}
                            <span class="help-block"><small>Silahkan masukan password</small></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Tutup</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-sm btn-success"><i class="fa fa-check fa-fw"></i> Simpan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-default fade" id="detail_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <p></p>
                    <img src="" id="foto" class="profile-user-img img-responsive img-circle">
                </div>
                <div class="col-md-6">
                    <h4>Nama Lengkap</h4>
                    <p class="text-muted" id="nama_lengkap"></p>
                    <h4>Status Level</h4>
                    <p><span class="label" id="superadmin"></span></p>
                    <h4>Alamat Email</h4>
                    <p class="text-muted" id="email"></p>
                    <h4>Status Blokir</h4>
                    <p><span class="label" id="blokir"></span></p>
                    <h4>Tanggal Bergabung</h4>
                    <p class="text-muted" id="tanggal"></p>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="ubah_status_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Status Admin</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_edit_status_admin']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inp_edit_status_admin">Status Admin</label>
                        <select name="superadmin" class="form-control" id="inp_edit_status_admin">
                            <option value="1">Admin</option>
                            <option value="0">Kasir</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-sm btn-success">
                        <i class="fa fa-refresh fa-fw"></i> Ganti Status admin
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
            </div>
            {!! Form::open(['method' => 'DELETE', 'id' => 'form_hapus_admin']) !!}
                <div class="modal-footer">
                    @csrf
                    <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus akun</button>
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
            $('#table_admin').DataTable({
                'autoWidth': false
            })
        })
    </script>

@endsection