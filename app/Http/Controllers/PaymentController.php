<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Package;
use App\PaymentHistory;
use App\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\PremiumMembershipMail;
use App\Utilities\Overrider;
use Validator;
use DB;
use Auth;
use Carbon\Carbon;

class PaymentController extends Controller
{
	
	public function __construct()
    {	
		date_default_timezone_set(get_option('timezone','Asia/Dhaka'));	
    }
   
    public function payment_history()
    {	
		$payment_history = \App\PaymentHistory::where("status","pending")
											  ->where('created_at', '<=', Carbon::now()->subHours(2)->toDateTimeString());
		$payment_history->delete();
		
		$payment_history = \App\PaymentHistory::where("status","paid")
											  ->orderBy('id','desc')
											  ->paginate(15);
		return view('backend.user.payments',compact('payment_history'));
    }

    public function create_offline_payment(){
       return view('backend.offline_payment.create');
    }

	public function store_offline_payment(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'package' => 'required',
			'package_type' => 'required',
			'user' => 'required',
		]);
		
		if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();                
		}
	
		DB::beginTransaction();
		
		$package = Package::find($request->package);
		$user = User::find($request->user);
		$company = Company::find($user->company_id);
	
		if($request->package_type == 'monthly'){
			$company->valid_to = date('Y-m-d', strtotime('+1 month'));
			$company->package_type = 'monthly';
		} elseif($request->package_type == '6_months') {
			$company->valid_to = date('Y-m-d', strtotime('+6 months'));
			$company->package_type = '6_months';
		} else {
			$company->valid_to = date('Y-m-d', strtotime('+1 year'));
			$company->package_type = 'yearly';
		}
	
		$company->membership_type = 'member';
		$company->last_email = NULL;
	
		// Update Package Details
		$company->package_id = $package->id;
		$company->websites_limit = unserialize($package->websites_limit)[$company->package_type];
		$company->recurring_transaction = unserialize($package->recurring_transaction)[$company->package_type];
		$company->online_payment = unserialize($package->online_payment)[$company->package_type];
	
		$company->save();
	
		// Create Payment History
		$payment = new PaymentHistory();
		$payment->company_id = $company->id;
		$payment->title = "Buy {$package->package_name} Package";
		$payment->method = "Offline";
		$payment->currency = get_option('currency', 'USD');
		
		if($request->package_type == 'monthly'){
			$payment->amount = $package->cost_per_month;
		} elseif($request->package_type == '6_months') {
			$payment->amount = $package->cost_per_6_months; // Assuming `cost_per_6_months` is stored in the database
		} else {
			$payment->amount = $package->cost_per_year;
		}
	
		$payment->package_id = $package->id;
		$payment->package_type = $request->package_type;
		$payment->status = 'paid';
		$payment->save();
	
		DB::commit();
	
		// Replace parameters
		$replace = array(
			'{name}' => $user->name,
			'{email}' => $user->email,
			'{valid_to}' => date('d M,Y', strtotime($company->valid_to)),
		);
		
		// Send email confirmation
		Overrider::load("Settings");
		$template = EmailTemplate::where('name', 'premium_membership')->first();
		$template->body = process_string($replace, $template->body);
	
		try{
			Mail::to($user->email)->send(new PremiumMembershipMail($template));
		}catch (\Exception $e) {
			// Handle email sending failure
		}
	
		if($payment->id > 0){
			return back()->with('success', _lang('Offline Payment Made Successfully'));
		} else {
			return back()->with('error', _lang('Error Occurred, Please try again!'));
		}
	}
	
}
