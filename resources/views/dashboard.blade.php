@extends('layouts.app') @section('content_style') @endsection

@section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item active">Dashboard</li>
</ol>
@endsection @section('content_body')
<!-- Info boxes -->
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<a href="#">
			<div class="info-box">
				<span class="info-box-icon bg-info elevation-1"><i
					class="fas fa-users"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Customers</span> <span
						class="info-box-number"> {{ $customers }} </span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</a>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-12 col-sm-6 col-md-3">
		<a href="#">
			<div class="info-box mb-3">
				<span class="info-box-icon bg-danger elevation-1"><i
					class="fas fa-chart-line"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Traders</span> <span
						class="info-box-number">{{ $traders }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</a>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->

	<!-- fix for small devices only -->
	<div class="clearfix hidden-md-up"></div>

	<div class="col-12 col-sm-6 col-md-3">
		<a href="#">
			<div class="info-box mb-3">
				<span class="info-box-icon bg-success elevation-1"><i
					class="fas fa-percentage"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Products</span> <span
						class="info-box-number">{{ $products }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</a>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
	<div class="col-12 col-sm-6 col-md-3">
		<a href="#">
			<div class="info-box mb-3">
				<span class="info-box-icon bg-warning elevation-1"><i
					class="fas fa-boxes"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Orders</span> <span
						class="info-box-number">{{ $orders }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
		</a>
		<!-- /.info-box -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
	<div class="col-8"></div>
</div>
@endsection @section('content_script') @endsection
