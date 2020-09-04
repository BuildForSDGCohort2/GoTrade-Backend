@extends('layouts.app') @section('content_style')
<link rel="stylesheet"
	href="{{ asset('theme/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet"
	href="{{ asset('theme/plugins/select2/css/select2.min.css') }}">
@endsection @section('content_breadcrumb')
<ol class="breadcrumb float-sm-right">
	<li class="breadcrumb-item active">Profile</li>
</ol>
@endsection @section('content_body')

<div class="row">
	<div class="col-md-8">
		<form method="post"
			action="{{ route('customer_profile.save',['customer'=>$customer]) }}">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Basic Information : {{
						$customer->customer_id }}</h3>
					<div class="card-tools">
					</div>
				</div>
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputFirstName">First Name</label> <input type="text"
								class="form-control" id="inputFirstName" name="inputFirstName"
								value="{{ $customer->first_name }}">
						</div>
						<div class="form-group col-md-6">
							<label for="inputLastName">Last Name</label> <input type="text"
								class="form-control" value="{{ $customer->last_name }}"
								id="inputLastName" name="inputLastName">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputGender">Gender</label> <select
								class="form-control @error('inputGender') is-invalid @enderror"
								id="inputGender" name="inputGender">
								<?php if($customer->gender==null) {?>
								<option value="">Select Gender</option>
								<?php } else { ?>
								<option value="{{ $customer->gender  }}"><?= $customer->gender=='male'?'MALE':'FEMALE' ?></option>
								<?php } ?>
								<option value="male">MALE</option>
								<option value="female">FEMALE</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="inputDateOfBirth">Date Of Birth</label>

							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
								<input type="text" class="form-control past-now-date"
									id="inputDateOfBirth" name="inputDateOfBirth"
									value="{{ $customer->date_of_birth }}" readonly="true">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail">Email Address</label> <input type="email"
								class="form-control" id="inputEmail" name="inputEmail"
								value="{{ $customer->email }}" readonly="true">
						</div>
						<div class="form-group col-md-6">
							<label for="inputMobileNumber">Mobile Number</label> <input
								type="text" class="form-control" id="inputMobileNumber"
								name="inputMobileNumber" value="{{ $customer->mobile_number }}"
								readonly="true"> @error('inputMobileNumber')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress">Address</label> <input type="text"
							class="form-control" id="inputAddress" name="inputAddress"
							value="{{ $customer->address }}">
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputCountry">Country</label> <select
								id="inputCountry" name="inputCountry"
								class="form-control select2 @error('inputCountry') is-invalid @enderror"
								data-placeholder="Choose Country">
								<?php if($customer->country_id==null) {?>
								<option value=""></option>
								<?php } else { ?>
								<option value="{{ $customer->country->id  }}"><?= $customer->country->name ?></option>
								<?php } ?>						
								<?php foreach ($countries as $country) { ?>
								<option value="{{ $country->id }}">{{ $country->name }}</option>
								<?php } ?>
							</select> @error('inputCountry')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label for="inputState">State</label> <select id="inputState"
								name="inputState"
								class="form-control select2 @error('inputState') is-invalid @enderror"
								data-placeholder="Choose State">
								<?php if($customer->state_id==null) {?>
								<option value=""></option>
								<?php } else { ?>
								<option value="{{ $customer->state->id  }}"><?= $customer->state->name ?></option>
								<?php } ?>						
							</select> @error('inputState')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label for="inputCity">City</label> <select id="inputCity"
								name="inputCity"
								class="form-control select2 @error('inputCity') is-invalid @enderror"
								data-placeholder="Choose City">
								<?php if($customer->city_id==null) {?>
								<option value=""></option>
								<?php } else { ?>
								<option value="{{ $customer->city->id  }}"><?= $customer->city->name ?></option>
								<?php } ?>
							</select> @error('inputCity')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save"></i> Update
					</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-4">
		<form method="post"
			action="{{ route('customer_profile.change_photo',['customer'=>$customer]) }}"
			enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Change Photo</h3>
				</div>
				<div class="card-body">
					<img
						src="{{ route('get_profile_photo',['filename'=>md5($customer->id)]) }}"
						alt="{{$customer->email}}" class="img-thumbnail img-fluid"
						width="100%">
					<hr>
					<div class="input-group mb-3">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="photo_file"
								name="photo_file"> <label class="custom-file-label"
								for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose
								file</label>
						</div>
						<div class="input-group-append">
							<button class="input-group-text" id="inputGroupFileAddon02"
								type="submit">Upload</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<form method="post"
			action="{{ route('customer_profile.change_password',['customer'=>$customer]) }}">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Change Password</h3>
				</div>
				<div class="card-body">
					<div class="form-group">
						<input type="password"
							class="form-control @error('newPassword') is-invalid @enderror"
							id="newPassword" name="newPassword" placeholder="New Password">
						@error('newPassword')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="confirmPassword"
							name="newPassword_confirmation" placeholder="Confirm Password">
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save"></i> Change
					</button>
				</div>
			</div>
		</form>
		<form method="post"
			action="{{ route('customer_profile.update_status',['customer'=>$customer]) }}">
			@csrf
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Account Status: {{
						\App\Services\CustomerService::getStatusMessage($customer->status)
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
