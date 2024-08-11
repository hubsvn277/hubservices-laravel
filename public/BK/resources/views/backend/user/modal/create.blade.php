<form method="post" class="ajax-submit" autocomplete="off" action="{{route('users.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="row p-2">
		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Business Name') }}</label>						
			<input type="text" class="form-control" name="business_name" value="{{ old('business_name') }}" required>
		  </div>
		</div>
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>						
			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Email') }}</label>						
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
		  </div>
		</div>

		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Password') }}</label>						
			<input type="password" class="form-control" name="password">
		  </div>
		</div>
		
		<div class="col-md-6">
		 <div class="form-group">
			<label class="control-label">{{ _lang('Confirm Password') }}</label>						
			<input type="password" class="form-control" name="password_confirmation" required>
		 </div>
		</div>
		
		@php $free = DB::table('packages')->where('type', 'free')->first(); @endphp
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Package') }}</label>						
			<select id="package" class="form-control" name="package_id" required>
				<option value="">{{ _lang('Select Package') }}</option>
				@if(isset($free) && $free != '')
					<option type="{{$free->type}}" value="{{$free->id}}">{{$free->package_name}}</option>
				@endif
				{{ create_option('packages','id','package_name',old('package_id')) }}
			</select>
		  </div>
		</div>
		  
		<div class="col-md-6">
		  <div id="packageType" class="form-group">
			<label class="control-label">{{ _lang('Package Type') }}</label>						
			<select class="form-control" id="package_type" name="package_type" required>
				<option value="">{{ _lang('Select Package') }}</option>
				<option value="monthly">{{ _lang('Monthly') }}</option>
				<option value="yearly">{{ _lang('Yearly') }}</option>
			</select>
		  </div>
		</div>

		
		<div class="col-md-6">
		  <div id="membershipType" class="form-group">
			<label class="control-label">{{ _lang('Membership Type') }}</label>						
			<select class="form-control select2" name="membership_type" id="membership_type" required>
			  <option value="trial">{{ _lang('Trial') }}</option>
			  <option value="member">{{ _lang('Member') }}</option>
			</select>
		  </div>
		</div>
		
		<div class="col-md-6">
		  <div class="form-group">
			<label class="control-label">{{ _lang('Status') }}</label>						
			<select class="form-control select2" id="status" name="status" required>
			  <option value="1">{{ _lang('Active') }}</option>
			  <option value="0">{{ _lang('Inactive') }}</option>
			</select>
		  </div>
		</div>
		
		
		<div class="col-md-12">
		 <div class="form-group">
			<label class="control-label">{{ _lang('Profile Picture') }} ( 300 X 300 {{ _lang('for better view') }} )</label>						
			<input type="file" class="dropify" name="profile_picture" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="">
		 </div>
		</div>
					
		<div class="col-md-12">
		  <div class="form-group">
			<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		  </div>
		</div>
	</div>
</form>

<script>

	const select = document.getElementById('package');

select.addEventListener('change', function handleChange(event) {
    if( select.options[select.selectedIndex].getAttribute('type') == 'free') {
        $('#packageType').removeClass('d-block');
        $('#packageType').addClass('d-none');
        $('#package_type').removeAttr('required');
        $('#package_type').attr('disabled', 'disabled');

		$('#membershipType').removeClass('d-block');
        $('#membershipType').addClass('d-none');
        $('#membership_type').removeAttr('required');
        $('#membership_type').attr('disabled', 'disabled');
    
    } else {
        $('#packageType').removeClass('d-none');
        $('#packageType').addClass('d-block');
        $('#package_type').attr('required', 'required');
        $('#package_type').removeAttr('disabled');

		$('#membershipType').removeClass('d-none');
        $('#membershipType').addClass('d-block');
        $('#membership_type').attr('required', 'required');
        $('#membership_type').removeAttr('disabled');
    }
    });
</script>