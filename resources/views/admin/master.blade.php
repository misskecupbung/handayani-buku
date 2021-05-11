<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Dzakyypedia Admin | @yield('title')</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	{{-- CSS --}}
	@include('admin.elemen.static_css')
	@yield('extra_css')
	<style>
		.skin-black-light .main-header {
			/* border-top: 6px solid #605CA8 !important; */
			border-bottom: 0;
		}
		.skin-black-light .main-header .navbar>.sidebar-toggle {
			color: #333;
			border-right: 0px !important;
		}
		.skin-black-light .main-header .logo {
			border-right: 0px !important;
		}
		.skin-black-light .main-header .navbar .navbar-custom-menu .navbar-nav>li>a, .skin-black-light .main-header .navbar .navbar-right>li>a {
			border-left: 0px !important;
			border-right-width: 0;
		}
		.main-header .navbar {
			border-bottom: 1px solid #d2d6de;
		}
		.skin-black-light .sidebar-menu > li.active > a {
			border-left-color: #1e282c;
		}
		.img-circle {
			border-radius: 10% !important;
		}
	</style>
</head>
<body class="hold-transition skin-black-light sidebar-mini">
<!-- Site wrapper -->
	<div class="wrapper">

		<header class="main-header">
			<!-- Logo -->
			<a href="#" class="logo">
				<!-- mini logo for sidebar mini 50x50 pixels -->
				<span class="logo-mini"><b>D</b>z</span>
				<!-- logo for regular state and mobile devices -->
				<span class="logo-lg"><b>Dz</b> Admin</span>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li>
							<a href="{{ route('logout_admin') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>

		<!-- =============================================== -->

		<!-- Left side column. contains the sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- Sidebar user panel -->
				<div class="user-panel">
					<div class="pull-left image">
                        {{ Html::image(asset('storage/avatars/admin/'.session('foto_admin')), session('nama_admin'), [
                            'class' => 'img-circle'
                        ]) }}
					</div>
					<div class="pull-left info">
                        <p><a href="{{ route('profile_admin', [ 'id_admin' => session('id_admin')]) }}">{{ session('nama_admin') }}</a></p>
						{{-- Status --}}
                        @if (session('superadmin') == true)
                            <span class="label bg-blue"><i class="fa fa-user fa-fw"></i> Admin</span>
                        @else
                            <span class="label bg-blue"><i class="fa fa-user fa-fw"></i> Kasir</span>
                        @endif
					</div>
				</div>
				<!-- sidebar menu -->
                @include('admin.elemen.sidebar')
				<!-- /.sidebar-menu -->
			</section>
		<!-- /.sidebar -->
		</aside>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
                @yield('content-header')
			</section>

			<!-- Main content -->
			<section class="@if(empty($invoice)) content container-fluid @else invoice @endif">
                @yield('content')
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

        @yield('modal')

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> v1.0
			</div>
			<strong>Copyright &copy; 2019 <a href="{{ route('beranda') }}">Dzakyypedia</a>.</strong> All rights reserved.
		</footer>
	</div>
	<!-- ./wrapper -->

    {{-- JS --}}
    @include('admin.elemen.static_js')
    @yield('extra_js')
</body>
</html>
