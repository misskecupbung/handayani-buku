@extends('admin.master')

@section('title', 'Manajemen Pengguna')

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
    Kelola Pengguna
    <small>Manajemen akun pengguna</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-users fa-fw"></i> Kelola Pengguna</li>
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
                    <i class="fa fa-list fa-fw"></i> Daftar Akun Pengguna
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_pengguna">
                    <thead>
                        <tr>
                            <th style="width: 15%">ID Pengguna</th>
                            <th style="width: 25%">Nama Pengguna</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 20%">Status Blokir</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_pengguna as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_pengguna }}</td>
                                <td>{{ $item->nama_lengkap  }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @if ($item->diblokir == true)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Ya</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-info btn-xs detail_pengguna" data-toggle="modal" data-target="#detail_pengguna" id="{{ $counter }}">
                                        <i class="fa fa-info fa-fw"></i> Detail
                                    </a>
                                    @if($item->diblokir)
                                        <a class="btn btn-warning btn-xs" href="{{ route('blokir_pengguna', ['id_pengguna' => $item->id_pengguna]) }}">
                                            <i class="fa fa-unlock fa-fw"></i> Unblock
                                        </a>
                                    @else
                                        <a class="btn btn-warning btn-xs" href="{{ route('blokir_pengguna', ['id_pengguna' => $item->id_pengguna]) }}">
                                            <i class="fa fa-lock fa-fw"></i> Block
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
<div class="modal modal-default fade" id="detail_pengguna">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Informasi Pengguna</h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-4">
                    <p></p>
                    <img src="" id="foto" class="profile-user-img img-responsive img-circle">
                </div>
                <div class="col-md-4">
                    <h4>ID Pengguna</h4>
                    <p class="text-muted" id="id_pengguna"></p>
                    <h4>Nama Lengkap</h4>
                    <p class="text-muted" id="nama_lengkap"></p>
                    <h4>Jenis Kelamin</h4>
                    <p class="text-muted" id="jenis_kelamin"></p>
                    <h4>Tanggal Bergabung</h4>
                    <p class="text-muted" id="tanggal"></p>
                </div>
                <div class="col-md-4">
                    <h4>Alamat Email</h4>
                    <p class="text-muted" id="email"></p>
                    <h4>No Telepon</h4>
                    <p class="text-muted" id="no_telepon"></p>
                    <h4>Alamat Rumah</h4>
                    <p class="text-muted" id="alamat_rumah"></p>
                    <h4>Status Blokir</h4>
                    <p><span class="label" id="blokir"></span></p>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-default fade" id="hapus_pengguna">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
            </div>
            {!! Form::open(['method' => 'DELETE', 'id' => 'form_hapus_pengguna']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm pull-left" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-sm btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus pengguna</button>
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
            $('#table_pengguna').DataTable({
                'lengthChange': true,
                'autoWidth': false
            })
        })
    </script>

@endsection
