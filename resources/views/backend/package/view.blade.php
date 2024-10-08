@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
	<div class="card">
	<div class="d-none panel-title">{{ _lang('View Package') }}</div>

	<div class="card-body">
	    <table class="table table-bordered">
			<tr>
				<td>{{ _lang('Package Name') }}</td>
				<td colspan="3">{{ $package->package_name }}</td>
			</tr>
			
			<tr>
				<td><b>{{ _lang('Features') }}</b></td>
				<td><b>{{ _lang('Monthly') }}</b></td>
				<td><b>{{ _lang('6 Months') }}</b></td>
				<td><b>{{ _lang('Yearly') }}</b></td>
			</tr>
			
			<tr>
				<td>{{ _lang('Staff Limit') }}</td>
				<td>{{ unserialize($package->websites_limit)['monthly'] }}</td>
				<td>{{ unserialize($package->websites_limit)['6_months'] }}</td>
				<td>{{ unserialize($package->websites_limit)['yearly'] }}</td>
			</tr>
			
			<tr>
				<td>{{ _lang('Recurring Transaction') }}</td>
				<td>{{ ucwords(unserialize($package->recurring_transaction)['monthly']) }}</td>
				<td>{{ ucwords(unserialize($package->recurring_transaction)['6_months']) }}</td>
				<td>{{ ucwords(unserialize($package->recurring_transaction)['yearly']) }}</td>
			</tr>
			
			<tr>
				<td>{{ _lang('Online Payment') }}</td>
				<td>{{ ucwords(unserialize($package->online_payment)['monthly']) }}</td>
				<td>{{ ucwords(unserialize($package->online_payment)['6_months']) }}</td>
				<td>{{ ucwords(unserialize($package->online_payment)['yearly']) }}</td>
			</tr>
			
			<tr>
				<td>{{ _lang('Cost') }}</td>
				<td><b>{{ decimalPlace($package->cost_per_month, currency()).' / '._lang('Month') }}</b></td>
				<td><b>{{ decimalPlace($package->cost_per_6_months, currency()).' / '._lang('6 Months') }}</b></td>
				<td><b>{{ decimalPlace($package->cost_per_year, currency()).' / '._lang('Year') }}</b></td>
			</tr>	
		</table>
	</div>
  </div>
 </div>
</div>
@endsection
