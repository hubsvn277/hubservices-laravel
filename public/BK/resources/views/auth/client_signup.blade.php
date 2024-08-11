@extends('layouts.login')

@section('content')
	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
				<!--begin::Aside-->
				<div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside">
					<div class="kt-grid__item">
						<a href="#" class="kt-login__logo">
           				<img alt="Logo" src="{{ get_logo() }}"/>
						</a>
					</div>
					<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
						<div class="kt-grid__item kt-grid__item--middle">
							<h3 class="kt-login__title">{{ _lang('Sign Up') }}!</h3>
							<h4 class="kt-login__subtitle">{{ _lang('Sign up to use our features') }}.</h4>
						</div>
					</div>
					<div class="kt-grid__item">
						<div class="kt-login__info">
							<div class="kt-login__copyright">
								&copy; {{ date('Y').' '.get_option('company_name') }}
							</div>
						</div>
					</div>
				</div>
				<!--begin::Aside-->
				<!--begin::Content-->
				<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

                    <div class="kt-login__head">
                        <span class="kt-login__signup-label">{{ _lang('Do you an account?')}}</span>&nbsp;&nbsp;
                        <a href="{{ url('login') }}" class="kt-link kt-login__signup-link">{{ _lang('Sign In') }}</a>
                    </div>
                    
					<!--begin::Body-->
					<div class="kt-login__body">

						<!--begin::Signin-->
						<div class="kt-login__form">
                            @if(Session::has('error'))
                                <div class="alert alert-danger text-center">
                                    <strong>{{ session('error') }}</strong>
                                </div>
                            @endif
					
                            @if(Session::has('registration_success'))
                                <div class="alert alert-success text-center">
                                    <strong>{{ session('registration_success') }}</strong>
                                </div>
                            @endif

							<!--begin::Form-->
                            <form method="POST" class="kt-form" autocomplete="off" action="{{ url('register/client_signup') }}">
                                @csrf


                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input id="name" type="text" placeholder="{{ _lang('Business Name') }}" class="form-control{{ $errors->has('business_name') ? ' is-invalid' : '' }}" name="business_name" value="{{ old('business_name') }}" required autofocus>

                                        @if ($errors->has('business_name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('business_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input id="name" type="text" placeholder="{{ _lang('Name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <input id="email" type="email" placeholder="{{ _lang('E-Mail Address') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php $free = DB::table('packages')->where('type', 'free')->first(); @endphp
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <select id="package" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="package" required>
                                            <option value="">{{ _lang('Select Package') }}</option>
                                            @if(isset($free) && $free != '')
                                                <option type="{{$free->type}}" value="{{$free->id}}">{{$free->package_name}}</option>
                                            @endif
                                            {{ create_option('packages','id','package_name') }}
                                        </select>    

                                        @if ($errors->has('package'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('package') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="package_type form-group row">
                                    <div class="col-md-12">
                                        <select id="package_type" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="package_type" required>
                                            <option value="">{{ _lang('Select Package Type') }}</option>
                                            <option value="monthly">{{ _lang('Monthly Pack') }}</option>
                                            <option value="yearly">{{ _lang('Yearly Pack') }}</option> 
                                        </select>    

                                        @if ($errors->has('package_type'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('package_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <input id="password" type="password" placeholder="{{ _lang('Password') }}" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control" placeholder="{{ _lang('Confirm Password') }}" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                   <div class="col-md-12">
                                        {!! NoCaptcha::renderJs('en', false, 'recaptchaCallback') !!}
                                        {!! NoCaptcha::display() !!}
                                        
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                   </div>
                               </div>
                                
								<div class="kt-login__actions mt-3">
									<button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">{{ _lang('Sign Up') }}</button>
								</div>
							</form>
                            <!--end::Form-->
                            
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Body-->
				</div>
				<!--end::Content-->
			</div>
		</div>
	</div>
@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/assets/js/jquery-3.1.1.min.js') }}"></script>
<script>

var package = "{{ isset($_GET['package']) ? $_GET['package'] : '' }}";
$("#package").val(package);

var package_type = "{{ isset($_GET['package_type']) ? $_GET['package_type'] : '' }}";
$("#package_type").val(package_type);

const select = document.getElementById('package');

select.addEventListener('change', function handleChange(event) {
    if( select.options[select.selectedIndex].getAttribute('type') == 'free') {
        
        $('.package_type').removeClass('d-block');
        $('.package_type').addClass('d-none');
        $('#package_type').removeAttr('required');
        $('#package_type').attr('disabled', 'disabled');
    
    } else {
        $('.package_type').removeClass('d-none');
        $('.package_type').addClass('d-block');
        $('#package_type').attr('required', 'required');
        $('#package_type').removeAttr('disabled');
    }
    });

</script>
@endsection