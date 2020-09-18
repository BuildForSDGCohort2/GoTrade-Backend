@extends('layouts.app') @section('content_style')
<style></style>
@endsection @section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
	<li class="breadcrumb-item active">Products</li>
</ol>
@endsection @section('content_body')


<div class="card card-outline card-primary">
	<div class="card-header">
		<div class="card-tools">
			<form class="form-inline"
				action="{{ route('products.index') }}" method="GET">
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
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th width="15%">Created On</th>
						<th width="20%">Category</th>
						<th width="20%">Name</th>						
						<th width="10%">SKU</th>
						<th width="15%" class="text-right">Amount</th>
						<th width="10%" class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($entities as $key => $entity) { ?>
			<tr>
						<td>{{ $entity->created_at }}</td>
						<td>{{ $entity->category->name }}</td>
						<td>{{ $entity->name }}</td>
						<td>{{ $entity->sku }}</td>
						<td class="text-right">{{ number_format($entity->amount,2) }}</td>
						<td class="text-center">{{ \App\Services\ProductService::getStatusMessage($entity->status) }}</td>
						<td class="text-center">
							<a
							href="{{ route('products.show',['product'=>$entity->id]) }}" class="btn btn-default btn-sm">Show</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
			</table>
			{!! $entities->render() !!}
		</div>
	</div>
</div>

@endsection @section('content_script')
<script></script>
@endsection
