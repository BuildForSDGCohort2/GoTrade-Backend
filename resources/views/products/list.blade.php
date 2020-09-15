@extends('layouts.app')
@section('content_style')
<style></style>
@endsection
@section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
	<li class="breadcrumb-item active">Products</li>
</ol>
@endsection
@section('content_body')

<div class="card card-outline card-primary">
	<div class="card-header">
		<div class="card-tools">
			<form class="form-inline"
				action="" method="GET">
				<div class="input-group input-group-sm">
					<input type="text" id="searchTxt" name="qry"
						placeholder="Search for..." class="form-control" size="40"> <span
						class="input-group-append">
						<button type="submit" class="btn btn-info btn-flat">
							<i class="fa fa-search"></i>
						</button>
					</span>
				</div>
				<!-- /input-group -->
			</form>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
      <button class="btn btn-primary mb-3">+ New Product</button>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th width="20%">SKU</th>
						<th width="15%">Amount</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
          @foreach($products as $product)
			     <tr>
						<td>{{ $product->name }}</td>
						<td>{{ $product->amount }}</td>
						<td>{{ $product->quantity }}</td>
            <td><button class="btn btn-primary">Edit</button></td>
					</tr>
          @endforeach
			</tbody>
			</table>
		</div>
	</div>
</div>

@endsection
@section('content_script')
<script></script>
@endsection
