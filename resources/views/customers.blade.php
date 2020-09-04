@extends('layouts.app') @section('content_style')
<style></style>
@endsection @section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
	<li class="breadcrumb-item active">Customers</li>
</ol>
@endsection @section('content_body')


<div class="card card-outline card-primary">
	<div class="card-header">
		<div class="card-tools">
			<form class="form-inline"
				action="{{ route('customers.index') }}" method="GET">
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
						<th>Name</th>
						<th width="20%">Email</th>
						<th width="15%">Mobile No.</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($entities as $key => $entity) { ?>
			<tr>
						<td>{{ $entity->created_at }}</td>
						<td>{{ $entity->last_name }} {{ $entity->first_name }}</td>
						<td>{{ $entity->email }}</td>
						<td>{{ $entity->mobile_number }}</td>
						<td class="text-center"><a
							href="{{ route('customers.show',['customer'=>$entity->id]) }}">Show</a>
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
