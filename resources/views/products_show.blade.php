@extends('layouts.app') @section('content_style')
<link rel="stylesheet"
	href="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet"
	href="{{ asset('theme/plugins/select2/css/select2.min.css') }}">
@endsection @section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item active">Product</li>
</ol>
@endsection @section('content_body')

<div class="row">
	<div class="col-md-8">
		<form method="post"
			action="#">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Basic Information : {{
						$product->sku }}</h3>
					<div class="card-tools">
					</div>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="inputFirstName">Name</label> <input type="text"
								class="form-control" id="inputFirstName" name="inputFirstName"
								value="{{ $product->name }}">
						</div>
						<div class="form-group col-md-4">
							<label for="inputLastName">SKU</label> <input type="text"
								class="form-control" value="{{ $product->sku }}"
								id="inputLastName" name="inputLastName">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-4">
		<form method="post"
			action="#"
			enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Product Photo</h3>
				</div>
				<div class="card-body">
					<img
						src="{{ route('get_profile_photo',['filename'=>md5($product->id)]) }}"
						alt="{{$product->sku}}" class="img-thumbnail img-fluid"
						width="100%">
				</div>
			</div>
		</form>
		<form method="post"
			action="{{ route('products.update_status',['product'=>$product]) }}">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Product Status: {{
						\App\Services\ProductService::getStatusMessage($product->status)
						}}</h3>
				</div>
				<div class="card-footer">
					<button type="submit" name="activateBtn" class="btn btn-success">
						<i class="fa fa-check"></i> Activate
					</button>
					<button type="submit" name="suspendBtn" class="btn btn-danger">
						<i class="fa fa-times"></i> Suspend
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection @section('content_script')
<script src="{{ asset('theme/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script type="text/javascript">

$('.custom-file input').change(function (e) {
    var files = [];
    for (var i = 0; i < $(this)[0].files.length; i++) {
        files.push($(this)[0].files[i].name);
    }
    $(this).next('.custom-file-label').html(files.join(', '));
});

    $(document).ready(function () {
        $('.select2').select2();
    });
    
    $('#inputCountry').change(function(){
    var countryID = $(this).val();    
    if(countryID){
        $.ajax({
           type:"GET",
           url:"{{url('states_json')}}?country_id="+countryID,
           success:function(res){               
            if(res){
                $("#inputState").empty();
                $("#inputState").append('<option>Choose State</option>');
                $.each(res,function(key,value){
                    $("#inputState").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#inputState").empty();
        $("#inputCity").empty();
    }      
    
   });
    $('#inputState').on('change',function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
           type:"GET",
           url:"{{url('cities_json')}}?state_id="+stateID,
           success:function(res){
            if(res){
                $("#inputCity").empty();
                $.each(res,function(key,value){
                    $("#inputCity").append('<option value="'+value['id']+'">'+value['name']+'</option>');
                });
           
            }else{
               $("#inputCity").empty();
            }
           }
        });
    }else{
        $("#inputCity").empty();
    }
    
   });
</script>

<script type="text/javascript">
                               $(".now-future-date").datepicker({
                                   changeMonth: true,
                                   changeYear: true,
                                   showOtherMonths: true,
                                   selectOtherMonths: true,
                                   dateFormat: 'yy-mm-dd',
                                   yearRange: '+nn:2074',
                                   minDate: new Date()
                               });
                               $(".past-now-date").datepicker({
                                   changeMonth: true,
                                   changeYear: true,
                                   showOtherMonths: true,
                                   selectOtherMonths: true,
                                   dateFormat: 'yy-mm-dd',
                                   yearRange: '1925:+nn',
                                   maxDate: new Date()
                               });
                               $(".past-future-date").datepicker({
                                   changeMonth: true,
                                   changeYear: true,
                                   showOtherMonths: true,
                                   selectOtherMonths: true,
                                   dateFormat: 'yy-mm-dd',
                                   yearRange: '1925:2074'
                               });
</script>

@endsection
