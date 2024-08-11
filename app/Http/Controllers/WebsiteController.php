<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Package;
use App\EmailSubscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use App\Utilities\Overrider;
use DB;
use Auth;
use Validator;
use File;

class WebsiteController extends Controller
{
	
	public function __construct()
    {	
		if(env('APP_INSTALLED',true) == true){
			$this->middleware(function ($request, $next) {
				
                if(isset($_GET['language'])){
                    session(['language' => $_GET['language']]);
                    return back();
                }
				return $next($request);
			});
			
			date_default_timezone_set(get_option('timezone','Asia/Dhaka'));  
		}
    }

    /**
     * Show the website frontpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    return view('theme.default.index');
    }


    public function getLandingPage(Request $request)
    {
        
        $url = $request->domain;
        $values = parse_url($url);
        $host = explode('.',$values['path']);

        if ($request->domain == getAppDomain()) {
            if( get_option('website_enable','yes') == 'no' ){	
                return redirect('login');
            } else {
                return view('theme.default.index');

            }
        } else {
            $p = \App\Project::where('custom_domain', $request->domain)
            ->orWhere('sub_domain', $request->domain)->orWhere('sub_domain', $host[0])->first();

            return File::get(public_path() . '/sites/'. $p->user_id .'/'. $p->id .'/index.html');
          
        }

    }

    /**
     * Show the website frontpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function sign_up()
    {
        if(! Auth::check() && get_option('allow_singup','yes') == 'yes'){
            return view('theme.default.sign_up');
        }

        return redirect('/');
    }

    public function contactus()
    {
        return view('theme.default.template.contactus');
    }

     /**
     * Show the website frontpage.
     *
     * @return \Illuminate\Http\Response
     */
    public function site($page = '')
    {
        $theme = get_option('active_theme','default');

        if( file_exists( resource_path() . "/views/theme/$theme/template/$page.blade.php") ){    
            return view("theme.$theme.template.$page");
        }else{
            abort(404);
        }
    }

    public function emaiL_subscribed(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:cm_email_subscribers|max:191',
        ],[
          'email.unique' => _lang('Sorry, You have already subscribed !')
        ]);
        
        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result'=>'error','message'=>$validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }
        
        $email_subscriber = new EmailSubscriber();
        $email_subscriber->email = $request->email;
        $email_subscriber->ip_address = request()->ip();
        $email_subscriber->save();

        if(! $request->ajax()){
           return back()->with('success', _lang('Thank you for subscription'));
        }else{
           return response()->json(['result'=>'success', 'action'=>'store', 'message'=>_lang('Thank you for subscription'),'data'=>$emaiL_subscriber]);
        }

    }

    public function send_message(Request $request)
    {
       @ini_set('max_execution_time', 0);
       @set_time_limit(0);
		setMailConfig();
        
       $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
       ]);
       
        //Send Email
        $name = $request->input("name");
        $email = $request->input("email");
        $subject = $request->input("subject");
        $message = $request->input("message");

        $mail  = new \stdClass();
        $mail->name = $name;
        $mail->email = $email;
        $mail->subject = $subject;
        $mail->message = $message;

        if(get_option('contact_email') != ''){
            try{
                Mail::to(get_option('contact_email'))->send(new ContactUs($mail));      
                return response(_lang('message has been sent successfully'), 200);
            }catch (\Exception $e) {
                return response(_lang('Error Occured, Please try again !'), 200);
            }        
        }

    }
	
	
}
