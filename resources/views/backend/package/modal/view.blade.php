<table class="table table-bordered">
	<tr>
		<td>{{ _lang('Package Name') }}</td>
		<td colspan="3">{{ $package->package_name }}</td>
	</tr>
	
	<tr>
		@if($package->type != 'free')
		<td><b>{{ _lang('Features') }}</b></td>
		<td><b>{{ _lang('Monthly') }}</b></td>
		<td><b>{{ _lang('6 Months') }}</b></td>
		<td><b>{{ _lang('Yearly') }}</b></td>
		@endif
	</tr>
	
	<tr>
		<td>{{ _lang('Websites Limit') }}</td>
		@if($package->type == 'free')
		<td colspan="3">{{ $package->websites_limit }}</td>
		@else
		<td>{{ unserialize($package->websites_limit)['monthly'] }}</td>
		<td>{{ unserialize($package->websites_limit)['6_months'] }}</td>
		<td>{{ unserialize($package->websites_limit)['yearly'] }}</td>
		@endif
	</tr>

	<tr>
		<td>{{ _lang('Recurring Transaction') }}</td>
		@if($package->type == 'free')
		<td colspan="3">{{ ucwords($package->recurring_transaction) }}</td>
		@else
		<td>{{ ucwords(unserialize($package->recurring_transaction)['monthly']) }}</td>
		<td>{{ ucwords(unserialize($package->recurring_transaction)['6_months']) }}</td>
		<td>{{ ucwords(unserialize($package->recurring_transaction)['yearly']) }}</td>
		@endif
	</tr>
	
	<tr>
		<td>{{ _lang('Online Payment') }}</td>
		@if($package->type == 'free')
		<td colspan="3">{{ ucwords($package->online_payment) }}</td>
		@else
		<td>{{ ucwords(unserialize($package->online_payment)['monthly']) }}</td>
		<td>{{ ucwords(unserialize($package->online_payment)['6_months']) }}</td>
		<td>{{ ucwords(unserialize($package->online_payment)['yearly']) }}</td>
		@endif
	</tr>
	
	<tr>
		<td>{{ _lang('Cost') }}</td>
		@if($package->type == 'free')
		<td colspan="3"><b>{{ decimalPlace($package->cost_per_month, currency()).' / '._lang('Month') }}</b></td>
		@else
		<td><b>{{ decimalPlace($package->cost_per_month, currency()).' / '._lang('Month') }}</b></td>
		<td><b>{{ decimalPlace($package->cost_per_6_months, currency()).' / '._lang('6 Months') }}</b></td>
		<td><b>{{ decimalPlace($package->cost_per_year, currency()).' / '._lang('Year') }}</b></td>
		@endif
	</tr>	
</table>
