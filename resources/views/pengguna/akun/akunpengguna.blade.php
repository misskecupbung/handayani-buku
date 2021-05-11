@extends('pengguna.master')

@section('title', 'Profile '.$data_pengguna->nama_lengkap)

@section('content')
<div class="site-section" id="akun">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }}<br>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
            </div>
        </div>
        <div class="row" data-aos="fade" data-aos-delay="100">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Detail Akun</h2>
            </div>
            <div class="col-md-3">
                <div class="image p-3 border mb-3">
                    {{  Html::image(asset('storage/avatars/pengguna/'.$data_pengguna->foto_pengguna), $data_pengguna->nama_lengkap,
                        [
                            'class' => 'img-fluid'
                        ])
                    }}
                </div>
            </div>
            <div class="col-md-9">
                <div class="row border">
                    <div class="col-md-3">
                        <div class="p-3 mb-3">
                            <span class="d-block text-black h6 text-uppercase">Nama Pengguna</span>
                            <p>{{ $data_pengguna->nama_lengkap }}</p>
                            <span class="d-block text-black h6 text-uppercase">Jenis Kelamin</span>
                            <p>{{ $data_pengguna->jenis_kelamin }}</p>
                            <span class="d-block text-black h6 text-uppercase">Email</span>
                            <p>{{ $data_pengguna->email }}</p>
                            <span class="d-block text-black h6 text-uppercase">Nama Penerima</span>
                            <p>{{ $data_pengguna->nama_lengkap }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 mb-3">
                            <span class="d-block text-black h6 text-uppercase">Alamat Rumah</span>
                            <p>
                                @if($data_pengguna->alamat_rumah != NULL)
                                    {{ $data_pengguna->alamat_rumah }}
                                @else
                                    <span class="badge badge-warning">Alamat Belum Tersedia</span>
                                @endif
                            </p>
                            <span class="d-block text-black h6 text-uppercase">No. Telepon</span>
                            <p>
                                @if($data_pengguna->no_telepon != NULL)
                                    {{ $data_pengguna->no_telepon }}
                                @else
                                    <span class="badge badge-warning">No.Telepon Belum Tersedia</span>
                                @endif
                            </p>
                            <span class="d-block text-black h6 text-uppercase">Tanggal Bergabung</span>
                            <p>{{ date('H:i:s | d-m-Y', strtotime($data_pengguna->tanggal_bergabung)) }}</p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="p-3 mb-3">
                            <a href="{{ route('edit_info_akun') }}#edit" class="btn btn-primary btn-block">Edit Data</a><hr>
                            <a href="{{ route('ganti_password') }}#ganti_password" class="btn btn-primary btn-block">Ganti Password</a><hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
