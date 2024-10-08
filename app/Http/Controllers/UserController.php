<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User;
use App\Company;
use App\Role;
use App\Package;
use App\AccessControl;
use Validator;
use Hash;
use Image;
use DB;

class UserController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_type = 'user')
    {
		if(! $user_type == 'user' ||  ! $user_type == 'admin'){
		   abort(404);
		}
		$title = $user_type == 'user' ? _lang('User List') : _lang('Admin List');
        $users = User::where("user_type",$user_type)
                     ->orderBy("id","desc")->get();
        return view('backend.user.list',compact('users','title'));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if( ! $request->ajax()){
		   return view('backend.user.create');
		}else{
           return view('backend.user.modal.create');
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {	
		$package = Package::findOrFail($request->package_id);
		if($package->type == 'free') {
			
			$validator = Validator::make($request->all(), [
				'business_name' => 'required|max:191',
				'name' => 'required|max:191',
				'email' => 'required|email|unique:users|max:191',
				'password' => 'required|max:20|min:6|confirmed',
				'status' => 'required',
				'package_id' => 'required',
				'profile_picture' => 'nullable|image|max:5120',
			]);
			
			if ($validator->fails()) {
				if($request->ajax()){ 
					return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
				}else{
					return redirect('users/create')
								->withErrors($validator)
								->withInput();
				}			
			}

			DB::beginTransaction();

		//Create Company
		$company = new Company();
		$company->business_name = $request->business_name;
		$company->status = $request->status;
		$company->package_id = $request->package_id;
		$company->package_type = 'Free';
		$company->membership_type = 'Free';
		
		$company->valid_to = '3022-06-20';
		
		//Package Details
		$package = $company->package;
		$company->websites_limit = $package->websites_limit;
		$company->recurring_transaction = 'No';
		$company->online_payment = 'No';

		$company->save();
			

		} else {

			$validator = Validator::make($request->all(), [
				'business_name' => 'required|max:191',
				'name' => 'required|max:191',
				'email' => 'required|email|unique:users|max:191',
				'password' => 'required|max:20|min:6|confirmed',
				'membership_type' => 'required',
				'status' => 'required',
				'package_id' => 'required',
				'package_type' => 'required',
				'profile_picture' => 'nullable|image|max:5120',
			]);
			
			if ($validator->fails()) {
				if($request->ajax()){ 
					return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
				}else{
					return redirect('users/create')
								->withErrors($validator)
								->withInput();
				}			
			}

			DB::beginTransaction();

		//Create Company
		$company = new Company();
		$company->business_name = $request->business_name;
		$company->status = $request->status;
		$company->package_id = $request->package_id;
		$company->package_type = $request->package_type;
		$company->membership_type = $request->membership_type;
		
		if ($company->package_type == 'monthly') {
			$company->valid_to = date('Y-m-d', strtotime('+1 month'));
		} elseif ($company->package_type == '6_months') {
			$company->valid_to = date('Y-m-d', strtotime('+6 months'));
		} else {
			$company->valid_to = date('Y-m-d', strtotime('+1 year'));
		}
		

		//Package Details
		$company->websites_limit = unserialize($company->package->websites_limit)[$company->package_type];
		$company->recurring_transaction = unserialize($company->package->recurring_transaction)[$company->package_type];
		$company->online_payment = unserialize($company->package->online_payment)[$company->package_type];

		$company->save();
	
		}


        $role = new Role();
        $role->name = 'manager';
        $role->description = 'For manging the websites';
		$role->company_id = $company->id;

        $role->save();

		$permission = new AccessControl();
		$permission->role_id = $role->id;
		$permission->permission = 'websites.create';
		$permission->save();

        //Create User		
        $user = new User();
	    $user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->email_verified_at = date('Y-m-d H:i:s');
		$user->password = Hash::make($request->password);
		$user->user_type = 'user';
		$user->role_id = $role->id;
		$user->status = $request->input('status');
	    $user->profile_picture = 'default.png';
	    $user->company_id = $company->id;
		if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           //$image->move(base_path('public/uploads/profile/'),$file_name);
           Image::make($image)->crop(300, 300)->save(base_path('public/uploads/profile/') .$file_name);
		   $user->profile_picture = $file_name;
		}
        $user->save();

        DB::commit();
		
        
		if(! $request->ajax()){
           return redirect('users/create')->with('success', _lang('Saved Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'store','message'=>_lang('Saved Sucessfully'),'data'=>$user]);
		}
        
   }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user = User::find($id);
		if(! $request->ajax()){
		    return view('backend.user.view',compact('user','id'));
		}else{
			return view('backend.user.modal.view',compact('user','id'));
		} 
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $user = User::find($id);
		if(! $request->ajax()){
		   return view('backend.user.edit',compact('user','id'));
		}else{
           return view('backend.user.modal.edit',compact('user','id'));
		}  
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE') == true  && User::find($id)->email == "demo@larabuilder.com"){
            if($request->ajax()) {
                return response()->json(['result' => 'error', 'action' => 'update', 'message' => _lang('DEMO MODE NOT ALLOWED')]);
            }else{
                return redirect()->back()->with('error', _lang('DEMO MODE NOT ALLOWED'));
            }
        }
		$user = User::find($id);

		$package = Package::findOrFail($request->package_id);
		if($package->type == 'free') {


			$validator = Validator::make($request->all(), [
				'business_name' => 'required|max:191',
				'name' => 'required|max:191',
				'email' => [
					'required',
					Rule::unique('users')->ignore($id),
				],
				'password' => 'nullable|max:20|min:6|confirmed',
				'status' => 'required',
				'package_id' => 'required',
				'profile_picture' => 'nullable|image|max:5120',
			]);
			
			if ($validator->fails()) {
				if($request->ajax()){ 
					return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
				}else{
					return redirect()->route('users.edit', $id)
								->withErrors($validator)
								->withInput();
				}			
			}

			DB::beginTransaction();

			//Update Company
			$company = Company::find($user->company_id);
			$previous_package = $company->package_id;

			$company->business_name = $request->business_name;
			$company->status = $request->status;
			$company->package_id = $request->package_id;
			$company->package_type = 'Free';
			$company->membership_type = 'Free';

			//Package Details Update
			if( $previous_package != $request->package_id ){
				
				$company->valid_to = '3022-06-20';

				$package = $company->package;
				
				$company->websites_limit = $package->websites_limit;
				$company->recurring_transaction = 'NO';
				$company->online_payment = 'NO';
			}

			$company->save();

		} else {

		$validator = Validator::make($request->all(), [
			'business_name' => 'required|max:191',
			'name' => 'required|max:191',
			'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
			'password' => 'nullable|max:20|min:6|confirmed',
			'membership_type' => 'required',
			'status' => 'required',
			'package_id' => 'required',
			'package_type' => 'required',
			'profile_picture' => 'nullable|image|max:5120',
		]);
		
		if ($validator->fails()) {
			if($request->ajax()){ 
			    return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
			}else{
				return redirect()->route('users.edit', $id)
							->withErrors($validator)
							->withInput();
			}			
		}

		DB::beginTransaction();

		//Update Company
		$company = Company::find($user->company_id);
		$previous_package = $company->package_id;
		
		$company->business_name = $request->business_name;
		$company->status = $request->status;
		$company->package_id = $request->package_id;
		$company->package_type = $request->package_type;
		$company->membership_type = $request->membership_type;

	
		if ($company->package_type == 'monthly') {
			$company->valid_to = date('Y-m-d', strtotime('+1 month'));
		} elseif ($company->package_type == '6_months') {
			$company->valid_to = date('Y-m-d', strtotime('+6 months'));
		} else {
			$company->valid_to = date('Y-m-d', strtotime('+1 year'));
		}
		
			
			$company->websites_limit = unserialize($company->package->websites_limit)[$company->package_type];
			$company->recurring_transaction = unserialize($company->package->recurring_transaction)[$company->package_type];
			$company->online_payment = unserialize($company->package->online_payment)[$company->package_type];

		$company->save();

		}

        
		
		
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		if($request->password){
            $user->password = Hash::make($request->password);
        }
		$user->status = $request->input('status');
	    if ($request->hasFile('profile_picture')){
           $image = $request->file('profile_picture');
           $file_name = "profile_".time().'.'.$image->getClientOriginalExtension();
           //$image->move(base_path('public/uploads/profile/'),$file_name);
           Image::make($image)->crop(300, 300)->save(base_path('public/uploads/profile/') .$file_name);
		   $user->profile_picture = $file_name;
		}
        $user->save();		

		DB::commit();
		

		if(! $request->ajax()){
           return redirect('users')->with('success', _lang('Updated Sucessfully'));
        }else{
		   return response()->json(['result'=>'success','action'=>'update', 'message'=>_lang('Updated Sucessfully'),'data'=>$user]);
		}
	    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(env('DEMO_MODE') == true  && User::find($id)->email == "demo@larabuilder.com"){
            return redirect('users')->with('error', _lang('DEMO MODE NOT ALLOWED'));
        }
        DB::beginTransaction();
		
        $user = User::find($id);

		$company = Company::find($user->company_id);
        $company->delete();
	    
		User::where('company_id',$user->company_id)->delete();
		
		DB::commit();
		
        return redirect('users')->with('success',_lang('Removed Sucessfully'));
    }
	
}
