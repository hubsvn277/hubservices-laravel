@extends('layouts.app')

@section('content')

  <span class="panel-title d-none">{{ _lang('Package List') }}</span>
   
  @php $currency = currency(); @endphp
  <div class="row">
	  <div class="col-md-12 text-center"> 
		 <button class="btn btn-primary btn-xs" id="btn-monthly">{{ _lang('Monthly') }}</button>
		 <button class="btn btn-outline-info btn-xs" id="btn-6months">{{ _lang('6 Months') }}</button>
	     <button class="btn btn-outline-info btn-xs" id="btn-yearly">{{ _lang('Yearly') }}</button>
	  </div>
  </div>
  
  <div class="row mt-2">
  @foreach($packages as $package)
	  <!-- Monthly Package -->
	  <div class="col-lg-4 monthly-package">
			<div class="card">
				<div class="pb-4">
					<div class="pricing-list text-center">
					    <div class="prc-head">
							<h4>{{ $package->package_name }}</h4>
							<h3 class="amount d-inline-block mt-2">{{ decimalPlace($package->cost_per_month, $currency) }}</h3>
							<small class="font-12 text-muted">/{{ _lang('month') }}</small>
                        </div>
					   
						<ul class="text-left p-3">
							@if($package->type == 'free')
							<li {{ $package->websites_limit != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ $package->websites_limit.' '._lang('Websites') }}</li>
							@else
							<li {{ unserialize($package->websites_limit)['monthly'] != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ unserialize($package->websites_limit)['monthly'].' '._lang('Websites') }}</li>
							@endif
							<li {{ unserialize($package->recurring_transaction)['monthly'] == 'Yes' ? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Recurring Transaction') }}</li>
							<li {{ unserialize($package->online_payment)['monthly'] == 'Yes'? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Online Payment') }}</li>
						</ul>
						
						<form action="{{ action('PackageController@destroy', $package['id']) }}" method="post">
							<a href="{{ action('PackageController@edit', $package['id']) }}" class="btn btn-outline-dark btn-round">{{ _lang('Edit') }}</a>
							<a href="{{ action('PackageController@show', $package['id']) }}" data-title="{{ _lang('View Package') }}" class="btn btn-outline-primary btn-round ajax-modal">{{ _lang('View') }}</a>
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="DELETE">
							<button class="btn btn-outline-danger btn-round btn-remove" type="submit">{{ _lang('Delete') }}</button>
						</form>							
					</div><!--end pricingTable-->
				</div><!--end card-body-->
			</div> <!--end card-->                                   
		</div>

		<!-- 6 Months Package -->
		<div class="col-lg-4 6months-package" style="display:none;">
			<div class="card">
				<div class="pb-4">
					<div class="pricing-list text-center">
					    <div class="prc-head">
							<h4>{{ $package->package_name }}</h4>
							<h3 class="amount d-inline-block mt-2">{{ decimalPlace($package->cost_per_6_months, $currency) }}</h3>
							<small class="font-12 text-muted">/{{ _lang('6 months') }}</small>
                        </div>
					   
						<ul class="text-left p-3">
							@if($package->type == 'free')
							<li {{ $package->websites_limit != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ $package->websites_limit.' '._lang('Websites') }}</li>
							@else
							<li {{ unserialize($package->websites_limit)['6_months'] != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ unserialize($package->websites_limit)['6_months'].' '._lang('Websites') }}</li>
							@endif
							<li {{ unserialize($package->recurring_transaction)['6_months'] == 'Yes' ? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Recurring Transaction') }}</li>
							<li {{ unserialize($package->online_payment)['6_months'] == 'Yes'? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Online Payment') }}</li>
						</ul>
						
						<form action="{{ action('PackageController@destroy', $package['id']) }}" method="post">
							<a href="{{ action('PackageController@edit', $package['id']) }}" class="btn btn-outline-dark btn-round">{{ _lang('Edit') }}</a>
							<a href="{{ action('PackageController@show', $package['id']) }}" data-title="{{ _lang('View Package') }}" class="btn btn-outline-primary btn-round ajax-modal">{{ _lang('View') }}</a>
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="DELETE">
							<button class="btn btn-outline-danger btn-round btn-remove" type="submit">{{ _lang('Delete') }}</button>
						</form>							
					</div><!--end pricingTable-->
				</div><!--end card-body-->
			</div> <!--end card-->                                   
		</div>

		<!-- Yearly Package -->
		<div class="col-lg-4 yearly-package" style="display:none;">
			<div class="card">
				<div class="pb-4">
					<div class="pricing-list text-center">
					    <div class="prc-head">
							<h4>{{ $package->package_name }}</h4>
							<h3 class="amount d-inline-block mt-2">{{ decimalPlace($package->cost_per_year, $currency) }}</h3>
							<small class="font-12 text-muted">/{{ _lang('year') }}</small>
						</div>
					   
						<ul class="text-left p-3">
							@if($package->type == 'free')
							<li {{ $package->websites_limit != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ $package->websites_limit.' '._lang('Websites') }}</li>
							@else
							<li {{ unserialize($package->websites_limit)['yearly'] != 'No' ? 'class=yes-feature' : 'class=no-feature' }}>{{ unserialize($package->websites_limit)['yearly'].' '._lang('Websites') }}</li>
							@endif
							<li {{ unserialize($package->recurring_transaction)['yearly'] == 'Yes' ? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Recurring Transaction') }}</li>
							<li {{ unserialize($package->online_payment)['yearly'] == 'Yes' ? 'class=yes-feature' : 'class=no-feature' }}>{{ _lang('Online Payment') }}</li>
						</ul>
						
						<form action="{{ action('PackageController@destroy', $package['id']) }}" method="post">
							<a href="{{ action('PackageController@edit', $package['id']) }}" class="btn btn-outline-dark btn-round">{{ _lang('Edit') }}</a>
							<a href="{{ action('PackageController@show', $package['id']) }}" data-title="{{ _lang('View Package') }}" class="btn btn-outline-primary btn-round ajax-modal">{{ _lang('View') }}</a>
							{{ csrf_field() }}
							<input name="_method" type="hidden" value="DELETE">
							<button class="btn btn-outline-danger btn-round btn-remove" type="submit">{{ _lang('Delete') }}</button>
						</form>							
					</div><!--end pricingTable-->
				</div><!--end card-body-->
			</div> <!--end card-->                                   
		</div>			
	@endforeach	
</div>

@endsection

@section('js-script')

<script>
$(document).on('click','#btn-monthly',function(){
	$(".monthly-package").fadeIn(800);
	$(".6months-package").hide();
	$(".yearly-package").hide();
	$(this).removeClass('btn-outline-info').addClass('btn-primary');
	$('#btn-6months').removeClass('btn-primary').addClass('btn-outline-info');
	$('#btn-yearly').removeClass('btn-primary').addClass('btn-outline-info');
});

$(document).on('click','#btn-6months',function(){
	$(".6months-package").fadeIn(800);
	$(".monthly-package").hide();
	$(".yearly-package").hide();
	$(this).removeClass('btn-outline-info').addClass('btn-primary');
	$('#btn-monthly').removeClass('btn-primary').addClass('btn-outline-info');
	$('#btn-yearly').removeClass('btn-primary').addClass('btn-outline-info');
});

$(document).on('click','#btn-yearly',function(){
	$(".yearly-package").fadeIn(800);
	$(".monthly-package").hide();
	$(".6months-package").hide();
	$(this).removeClass('btn-outline-info').addClass('btn-primary');
	$('#btn-monthly').removeClass('btn-primary').addClass('btn-outline-info');
	$('#btn-6months').removeClass('btn-primary').addClass('btn-outline-info');
});
</script>

@endsection
