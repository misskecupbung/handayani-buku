@extends('admin.master')

@section('title', 'Profile Admin')

@section('extra_css')

    <style>
        .profile-user-img {
            width: 120px;
        }
    </style>

@endsection

@section('content-header')
<h1>
    Profile @if($data_admin->superadmin == true) Admin @else Kasir @endif
    <small>Detail Akun</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-user fa-fw"></i> Profile Akun</li>
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
    <div class="col-md-3 col-sm-12">

        <!-- Profile Image -->
        <div class="box box-default">
            <div class="box-body box-profile">
                {{  Html::image(asset('storage/avatars/admin/'.$data_admin->foto), $data_admin->nama_lengkap,
                    [
                        'class' => 'img-circle profile-user-img img-responsive'
                    ])
                }}
                <br>
                <h3 class="profile-username text-center">{{ $data_admin->nama_lengkap }}</h3>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <a href="{{ route('beranda_admin') }}" class="btn btn-primary btn-block btn-sm"><b><i class="fa fa-arrow-left fa-fw"></i> Kembali ke Beranda</b></a>
    </div>
    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-user fa-fw"></i> Detail Informasi</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#ganti_password">
                        <i class="fa fa-lock fa-fw"></i> Ganti Password
                    </button>
                </div>
            </div>
            <div class="box-body row">
                <div class="col-md-6">
                    <h3 class="profile-username">ID Admin</h3>
                    <h4 class="text-muted">{{ $data_admin->id_admin }}</h4>
                    <h3 class="profile-username">Nama lengkap</h3>
                    <h4 class="text-muted">{{ $data_admin->nama_lengkap }}</h4>
                    <h3 class="profile-username">Status Level</h3>
                    @if ($data_admin->superadmin == true)
                        <p><span class="label bg-green"><i class="fa fa-user fa-fw"></i> Admin</span></p>
                    @else
                        <p><span class="label bg-red"><i class="fa fa-user fa-fw"></i> Kasir</span></p>
                    @endif
                </div>
                <div class="col-md-6">
                    <h3 class="profile-username">Email Admin</h3>
                    <h4 class="text-muted">{{ $data_admin->email }}</h4>
                    <h3 class="profile-username">Tanggal Bergabung</h3>
                    <h4 class="text-muted">{{ $data_admin->tanggal_bergabung }}</h4>
                    <H3 class="profile-username">Status Blokir</H3>
                    <h4 class="text-muted"></h4>
                    @if ($data_admin->diblokir == true)
                        <span class="label bg-red"><i class="fa fa-ban fa-fw"></i> Di Blokir</span>
                    @else
                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Tidak Di Blokir</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal modal-default fade" id="ganti_password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ganti Password Akun</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['route' => ['ganti_password_admin', session('id_admin')], 'method' => 'PUT']) !!}
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_lama', 'Password Lama') !!}
                        {!! Form::password('password_lama', ['id' => 'inp_password_lama', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan password lama</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_baru', 'Password Baru') !!}
                        {!! Form::password('password_baru', ['id' => 'inp_password_baru', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan password baru</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_konfirmasi', 'Ulangi Password') !!}
                        {!! Form::password('password_baru_confirmation', ['id' => 'inp_password_konfirmasi', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Masukan ulang password baru</small></span>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-sm"><i class="fa fa-close fa-fw"></i> Reset</button>
                        <button type="submit" name="simpan" value="true" class="btn btn-sm pull-right btn-success"><i class="fa fa-check fa-fw"></i> Simpan</button>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
