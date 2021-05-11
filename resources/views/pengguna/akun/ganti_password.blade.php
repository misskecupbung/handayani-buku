@extends('pengguna.master')

@section('title', 'Rubah Data Pribadi')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('info_akun') }}">Profil</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Ganti Password</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section" id="ganti_password">
    <div class="container">
        <div class="row" data-aos="fade" data-aos-delay="100">
            <div class="col-md-8 mx-auto">
                <h2 class="h3 mb-3 text-black">Ganti Password</h2>
            </div>
            <div class="col-md-8 mx-auto">
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

                @endif
                {{ Form::open(['route' => 'simpan_password', 'method' => 'PUT']) }}
                    <div class="row border">
                        <div class="col-md-7">
                            <div class="p-4 mb-3">
                                <div class="form-group">
                                    {{ Form::label('inp_password_lama', 'Password Lama', ['class' => 'd-block text-black h6']) }}
                                    {{ Form::password('password_lama', ['class' => 'form-control', 'id' => 'inp_password_lama']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_password_baru', 'Password Baru', ['class' => 'd-block text-black h6']) }}
                                    {{ Form::password('password_baru', ['class' => 'form-control', 'id' => 'inp_password_baru']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_password_confirmation', 'Password Konfirmasi', ['class' => 'd-block text-black h6']) }}
                                    {{ Form::password('password_baru_confirmation', ['class' => 'form-control', 'id' => 'inp_password_confirmation']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="p-4 mb-3">
                                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-block">Simpan</button>
                                <hr>
                                <a href="{{ route('info_akun') }}" class="btn btn-primary btn-block">Kembali</a>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
