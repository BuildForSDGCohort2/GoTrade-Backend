<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ config('app.name') }} - {{ $title }}</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57"
	href="{{ asset('img/favicon/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60"
	href="{{ asset('img/favicon/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72"
	href="{{ asset('img/favicon/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76"
	href="{{ asset('img/favicon/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114"
	href="{{ asset('img/favicon/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120"
	href="{{ asset('img/favicon/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144"
	href="{{ asset('img/favicon/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152"
	href="{{ asset('img/favicon/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180"
	href="{{ asset('img/favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192"
	href="{{ asset('img/favicon/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32"
	href="{{ asset('img/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96"
	href="{{ asset('img/favicon/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16"
	href="{{ asset('img/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage"
	content="{{ asset('img/favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">

<!-- Font Awesome -->
<link rel="stylesheet"
	href="{{ asset('theme/plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet"
	href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	@yield('content_style')
<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('theme/css/adminlte.min.css') }}">
<!-- Google Font: Source Sans Pro -->
<link
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700"
	rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav
			class="main-header navbar navbar-expand navbar-primary navbar-dark">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" data-widget="pushmenu"
					href="#"><i class="fas fa-bars"></i></a></li>
			</ul>
			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown user-menu"><a href="#"
					class="nav-link dropdown-toggle" data-toggle="dropdown"> <img
						src="{{ route('get_profile_photo',['filename'=>md5(Auth::user()->id)]) }}"
						class="user-image img-circle elevation-2" alt="User Image"> <span
						class="d-none d-md-inline">{{ Auth::user()->name }}</span>
				</a>
					<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<!-- User image -->
						<li class="user-header bg-primary"><img
							src="{{ route('get_profile_photo',['filename'=>md5(Auth::user()->id)]) }}"
							class="img-circle elevation-2" alt="User Image">

							<p>
								{{ Auth::user()->name }} <small>Member since {{
									date_format(date_create(Auth::user()->created_at),"F dS, Y") }}</small>
							</p></li>
						<!-- Menu Footer-->
						<li class="user-footer"><a href="#"
							class="btn btn-default btn-flat">Profile</a> <a href="#"
							class="btn btn-default btn-flat float-right"
							onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
								Sign out</a>
							<form id="logout-form" action="{{ route('logout') }}"
								method="POST" style="display: none;">@csrf</form></li>
					</ul></li>
			</ul>
		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="{{ route('dashboard') }}" class="brand-link bg-primary"> <img
				src="{{ asset('theme/img/logo.png') }}" alt="Round GoTrade Logo"
				class="brand-image img-circle elevation-3" style="opacity: .8"> <span
				class="brand-text font-weight-light">GoTrade</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column"
						data-widget="treeview" role="menu" data-accordion="false">
						<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
						<li class="nav-item"><a href="{{ route('dashboard') }}"
							class="nav-link"> <i class="nav-icon fas fa-tachometer-alt"></i>
								<p>Dashboard</p>
						</a></li>
						<li class="nav-item"><a href="{{ route('customers.index') }}"
							class="nav-link"> <i class="nav-icon fas fa-users"></i>
								<p>
									Customers
								</p>
						</a></li>
						<li class="nav-item"><a href="{{ route('traders.index') }}"
							class="nav-link"> <i class="nav-icon fas fa-users"></i>
								<p>
									Traders
								</p>
						</a></li>
						<li class="nav-item"><a href="{{ route('products.index') }}"
							class="nav-link"> <i class="nav-icon fas fa-cubes"></i>
								<p>Products</p>
						</a></li>

						<li class="nav-item"><a href="{{ route('profile') }}"
							class="nav-link"> <i class="nav-icon fas fa-user"></i>
								<p>Profile</p>
						</a></li>
						<li class="nav-item"><a href="{{ route('logout') }}"
							class="nav-link"
							onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
								<i class="nav-icon fas fa-power-off"></i>
								<p>Logout</p>
						</a></li>
					</ul>
				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>{{ $title }}</h1>
						</div>
						<div class="col-sm-6">@yield('content_breadcrumb')</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">@include('common.messages')
					@yield('content_body')
					<br/>
					<br/>
					</div>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<footer class="main-footer">
			<div class="float-right d-none d-sm-block">
				<b>Version</b> 0.1.0
			</div>
			<strong>Copyright &copy; 2020 <a href="https://gotrade.com.ng"
				target="_blank">GoTrade</a>.
			</strong> All rights reserved.
		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>
	<!-- Bootstrap 4 -->
	<script
		src="{{ asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		@yield('content_script')
	<!-- AdminLTE App -->
	<script src="{{ asset('theme/js/adminlte.min.js') }}"></script>
	

</body>
</html>