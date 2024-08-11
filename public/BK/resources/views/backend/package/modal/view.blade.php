<table class="table table-bordered">
	<tr>
		<td>{{ _lang('Package Name') }}</td>
		<td colspan="2">{{ $package->package_name }}</td>
	</tr>
	
	<tr>
		@if($package->type != 'free')
		<td><b>{{ _lang('Features') }}</b></td>
		<td><b>{{ _lang('Monthly') }}</b></td>
		<td><b>{{ _lang('Yearly') }}</b></td>
		@endif
	</tr>
	
	<tr>
		<td>{{ _lang('Websites Limit') }}</td>
		@if($package->type == 'free')
		<td>{{ $package->websites_limit }}</td>
		@else
		<td>{{ unserialize($package->websites_limit)['monthly'] }}</td>
		<td>{{ unserialize($package->websites_limit)['yearly'] }}</td>
		@endif
	</tr>

	<tr>
		<td>{{ _lang('Recurring Transaction') }}</td>
		<td>{{ ucwords(unserialize($package->recurring_transaction)['monthly']) }}</td>
		<td>{{ ucwords(unserialize($package->recurring_transaction)['yearly']) }}</td>
	</tr>
	
	<tr>
		<td>{{ _lang('Online Payment') }}</td>
		<td>{{ ucwords(unserialize($package->online_payment)['monthly']) }}</td>
		<td>{{ ucwords(unserialize($package->online_payment)['yearly']) }}</td>
	</tr>
	
	<tr>
		<td>{{ _lang('Cost') }}</td>
		<td><b>{{ decimalPlace($package->cost_per_month, currency()).' / '._lang('Month') }}</b></td>
		<td><b>{{ decimalPlace($package->cost_per_year, currency()).' / '._lang('Year') }}</b></td>
	</tr>	
</table>

