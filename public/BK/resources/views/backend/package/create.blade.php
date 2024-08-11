@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
		<div class="d-none panel-title">{{ _lang('Add New Package') }}</div>

			<div class="card-body">
			  	<form method="post" class="validate" autocomplete="off" action="{{ route('packages.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Package Name') }}</label>						
							<input type="text" class="form-control" name="package_name" value="{{ old('package_name') }}" required>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Featured') }}</label>						
							<select class="form-control" name="is_featured">
							   <option value="0">{{ _lang('No') }}</option>
							   <option value="1">{{ _lang('Yes') }}</option>
							</select>
						  </div>
						</div>

						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Type') }}</label>						
							<select id="type" class="form-control" name="type">
							   <option value="free">{{ _lang('Free') }}</option>
							   <option selected value="paid">{{ _lang('Paid') }}</option>
							</select>
						  </div>
						</div>
						
						<div class="col-md-12">
							<div class="websites_limit form-group d-none">
								<label class="control-label">{{ _lang('Websites Linmit') }}</label>						
								<select id="websites_limit" class="form-control select2" name="websites_limit">
									<option value="No">{{ _lang('No') }}</option>
									<option value="Unlimited">{{ _lang('Unlimited') }}</option>
									@for( $i = 1; $i <= 30; $i++ )
										<option value="{{ $i }}">{{ $i }}</option>
									@endfor
								</select>
							</div>
							<table class="table table-bordered">
								<thead class="thead-dark">
								   <th class="w-50">{{ _lang('Monthly Limit') }}</th>
								   <th class="w-50">{{ _lang('Yearly Limit') }}</th>
								</thead>
								<tbody>
									<tr>
										<td>
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Websites Linmit') }}</label>						
												<select class="free form-control select2" name="websites_limit[monthly]" required>
													<option value="No">{{ _lang('No') }}</option>
													<option value="Unlimited">{{ _lang('Unlimited') }}</option>
													@for( $i = 1; $i <= 30; $i++ )
														<option value="{{ $i }}">{{ $i }}</option>
													@endfor
												</select>
											  </div>
											</div>
										</td>
										<td>
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Websites Limit') }}</label>						
												<select class="free form-control select2" name="websites_limit[yearly]" required>
													<option value="No">{{ _lang('No') }}</option>
													<option value="Unlimited">{{ _lang('Unlimited') }}</option>
													@for( $i = 1; $i <= 30; $i++ )
														<option value="{{ $i }}">{{ $i }}</option>
													@endfor
												</select>
											  </div>
											</div>
										</td>
									</tr>
									
									<tr>
										<td>				
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Recurring Transaction') }}</label>					
												<select class="free form-control select2" name="recurring_transaction[monthly]" required>
													<option value="Yes">{{ _lang('Yes') }}</option>
													<option value="No">{{ _lang('No') }}</option>
												</select>
											  </div>
											</div>
										</td>
										<td>				
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Recurring Transaction') }}</label>					
												<select class="free form-control select2" name="recurring_transaction[yearly]" required>
													<option value="Yes">{{ _lang('Yes') }}</option>
													<option value="No">{{ _lang('No') }}</option>
												</select>
											  </div>
											</div>
										</td>
									</tr>
									
									<tr>
										<td>								
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Online Payment') }}</label>						
												<select class="free form-control select2" name="online_payment[monthly]" required>
													<option value="No">{{ _lang('No') }}</option>
													<option value="Yes">{{ _lang('Yes') }}</option>
												</select>
											  </div>
											</div>
										</td>
										<td>								
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Online Payment') }}</label>						
												<select class="free form-control select2" name="online_payment[yearly]" required>
													<option value="No">{{ _lang('No') }}</option>
													<option value="Yes">{{ _lang('Yes') }}</option>
												</select>
											  </div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Cost Per Month').' '.currency() }}</label>						
												<input type="text" class="free form-control float-field" name="cost_per_month" value="{{ old('cost_per_month') }}" required>
											  </div>
											</div>
										</td>
										
										<td>
											<div>
											  <div class="form-group">
												<label class="control-label">{{ _lang('Cost Per Year').' '.currency() }}</label>						
												<input type="text" class="free form-control float-field" name="cost_per_year" value="{{ old('cost_per_year') }}" required>
											  </div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

							
						<div class="col-md-12">
						  <div class="form-group">
							<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
							<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
						  </div>
						</div>
					</div>
			  	</form>
			</div>
	  	</div>
 	</div>
</div>
@endsection


@section('js-script')

<script>

(function($){

"use strict";	

$('#type').on('change', function() {
if( this.value  == 'free') {
	$('.free').removeAttr('required');
	$('.free').attr('disabled', 'disabled');
	$('.websites_limit').removeClass('d-none');
	$('.websites_limit').addClass('d-block');
	$('#websites_limit').attr('required', 'required');
} else {
	$('.free').attr('required', 'required');
	$('.free').removeAttr('disabled');
	$('.websites_limit').removeClass('d-block');
	$('.websites_limit').addClass('d-none');
	$('#websites_limit').removeAttr('required');
}
});

})(jQuery);	

</script>


@endsection


