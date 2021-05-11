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
                <strong class="text-black">Edit Data Pribadi</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section" id="edit">
    <div class="container">
        <div class="row" data-aos="fade" data-aos-delay="100">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Edit Data Pribadi</h2>
            </div>
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

                @endif
                {{ Form::open(['route' => 'simpan_info_akun', 'method' => 'PUT', 'files' => true]) }}
                    <div class="row border">
                        <div class="col-md-4">
                            <div class="p-3 mb-3">
                                {{  Html::image(asset('storage/avatars/pengguna/'.$data_informasi->foto_pengguna), $data_informasi->nama_lengkap,
                                    [
                                        'class' => 'img-fluid'
                                    ])
                                }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 mb-3">
                                <div class="form-group">
                                    {{ Form::label('inp_nama', 'Nama Lengkap', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::text('nama_lengkap',$data_informasi->nama_lengkap, ['class' => 'form-control', 'id' => 'inp_nama']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_jenis_kelamin', 'Jenis Kelamin', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::select('jenis_kelamin', ['Pria' => 'Pria', 'Wanita' => 'Wanita'],$data_informasi->jenis_kelamin, [
                                        'placeholder' => 'Pilih Jenis Kelamin..', 'class' => 'form-control', 'id' => 'inp_jenis_kelamin']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_email', 'Email', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::email('email',$data_informasi->email, ['class' => 'form-control', 'id' => 'inp_email']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_no_telepon', 'No. Telepon', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::text('no_telepon',$data_informasi->no_telepon, ['class' => 'form-control', 'id' => 'inp_no_telepon']) }}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 mb-3">
                                <div class="form-group">
                                    {{ Form::label('inp_alamat', 'Alamat Rumah', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::textarea('alamat_rumah',$data_informasi->alamat_rumah, [
                                            'class' => 'form-control', 'id' => 'inp_alamat', 'rows' => '5'
                                        ]) }}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('inp_foto_pengguna', 'Foto Pengguna', ['class' => 'd-block text-black h6 text-uppercase']) !!}
                                    {!! Form::file('foto_pengguna', ['id' => 'inp_foto_pengguna', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('inp_password', 'Konfirmasi Password', ['class' => 'd-block text-black h6 text-uppercase']) }}
                                    {{ Form::password('password', ['class' => 'form-control', 'id' => 'inp_password']) }}
                                </div>
                                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-block">Simpan</button>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
