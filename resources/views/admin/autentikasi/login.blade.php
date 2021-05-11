<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dzakyypedia Admin | Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> {{-- css --}}
    @include('admin.elemen.static_css')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        @if (session()->has('fail'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
            {{ session('fail') }}
        </div>
        @elseif (session()->has('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{ session('success') }}
        </div>
        @endif

        <div class="login-logo"><a href="{{ route('login_admin') }}">
			<i class="fa fa-dashcube"></i> <b>Dz</b>akyypedia</a>
        </div>
        <div class="login-box-body">
            <!-- /.login-logo -->
            <h3 class="text-center">Login Administrator</h3>
            <hr style="border:0.5px solid #d2d6de;"> {!! Form::open(['route' => 'proses_login_admin']) !!} @csrf

            <div class="form-group has-feedback {{ session()->has('fail') ? 'has-error' : '' }}">
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukan Email', 'autocomplete' => 'off']) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span> @if (session()->has('fail'))
                <span class="help-block">Masukan Email</span> @endif
            </div>

            <div class="form-group has-feedback {{ session()->has('fail') ? 'has-error' : '' }}">
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukan Pasword', 'autocomplete' => 'off'])
                !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span> @if (session()->has('fail'))
                <span class="help-block">Masukan Password</span> @endif
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" name="simpan" value="true" class="btn btn-primary btn-block">Masuk</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
        <!-- /.login-box-body -->
        <p class="text-center" style="margin-top: 50px;">
            Copyright &copy; 2019 <b>Dz</b>akyypedia. All rights reserved.
        </p>
    </div>
    <!-- /.login-box -->

    {{-- js --}}
    @include('admin.elemen.static_js')
</body>

</html>