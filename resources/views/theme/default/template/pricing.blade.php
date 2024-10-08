@extends('theme.default.layouts.website')

<style>
    .pricing .label {
        top: 1.785714em !important;
        right: 0.785714em !important;
    }
</style>

@section('header')
<section class="text-center imagebg space--lg" data-overlay="3">
    @if (get_option('sub_banner_image'))
    <div class="background-image-holder">
        <img alt="background" src="{{ asset('public/uploads/media/'.get_array_option('sub_banner_image')) }}" />
    </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-6">
                <h1 class="header-title">{{ _lang('Pricing') }}</h1>
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>
@endsection

@section('content')


    <section class="text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="cta">
                        <h2>{{ _lang('Our Pricing') }}</h2>
                        <p class="lead">
                            {{ _lang('Stop wasting time and money designing and managing a website that does not get results. Happiness guaranteed!') }}
                        </p>
                    </div>
                </div>
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    <section>
        <div class="container">

            <div class="row pricing-headline">
                <div class="col-md-12 text-center"> 
                    <button class="btn btn--primary type--uppercase btn-hop mb-0" id="btn-monthly">
                        {{ _lang('Monthly Plan') }}
                    </button>
                    <button class="btn btn--primary type--uppercase btn-not-hop" id="btn-6months">
                        {{ _lang('6 Months Plan') }}
                    </button>
                    <button class="btn btn--primary type--uppercase btn-not-hop" id="btn-yearly">
                        {{ _lang('Yearly Plan') }}
                    </button>
                </div>
            </div>


            <div class="row pricing-content">
                @php $currency = currency(get_option('currency','USD')); @endphp
                
                @foreach(\App\Package::all() as $package)
                    <!-- Monthly Package -->
                    <div class="col-md-4 monthly-package">
                        <div class="pricing pricing-1 boxed boxed--lg boxed--border boxed--emphasis">
                            <h3>{{ $package->package_name }}</h3>
                            <span class="h2">
                                <strong>{{ g_decimal_place($package->cost_per_month, $currency) }}</strong>
                            </span>
                            <span class="type--fine-print">{{ _lang('Per Month') }}.</span>
                            @if ($package->is_featured == 1)
                                <span class="label">{{ _lang('Value') }}</span>
                            @endif
                            <hr>
                            <ul>
                                <li>
                                    <span class="checkmark bg--primary-1"></span>
                                    @if($package->type == 'free')
                                    {{ $package->websites_limit.' '._lang('Websites') }}
                                    @else
                                    <span>{{ unserialize($package->websites_limit)['monthly'].' '._lang('Websites') }}</span>
                                    @endif
                                </li>
                            </ul>
                            <a class="btn btn--{{ $package->is_featured == 1 ? 'primary-1' : 'primary' }}" href="{{ url('register/client_signup?package_type=monthly&package='.$package->id) }}">
                                <span class="btn__text">
                                    {{ _lang('Get Started') }}
                                </span>
                            </a>
                        </div>
                        <!--end of pricing-->
                    </div>

                    <!-- 6 Months Package -->
                    <div class="col-md-4 6months-package" style="display:none">
                        <div class="pricing pricing-1 boxed boxed--lg boxed--border boxed--emphasis">
                            <h3>{{ $package->package_name }}</h3>
                            <span class="h2">
                                <strong>{{ g_decimal_place($package->cost_per_6_months, $currency) }}</strong>
                            </span>
                            <span class="type--fine-print">{{ _lang('Per 6 Months') }}.</span>
                            @if ($package->is_featured == 1)
                                <span class="label">{{ _lang('Value') }}</span>
                            @endif
                            <hr>
                            <ul>
                                <li>
                                    <span class="checkmark bg--primary-1"></span>
                                    @if($package->type == 'free')
                                    {{ $package->websites_limit.' '._lang('Websites') }}
                                    @else
                                    <span>{{ unserialize($package->websites_limit)['6_months'].' '._lang('Websites') }}</span>
                                    @endif
                                </li>
                            </ul>
                            <a class="btn btn--{{ $package->is_featured == 1 ? 'primary-1' : 'primary' }}" href="{{ url('register/client_signup?package_type=6_months&package='.$package->id) }}">
                                <span class="btn__text">
                                    {{ _lang('Get Started') }}
                                </span>
                            </a>
                        </div>
                        <!--end of pricing-->
                    </div>

                    <!-- Yearly Package -->
                    <div class="col-md-4 yearly-package" style="display:none">
                        <div class="pricing pricing-1 boxed boxed--lg boxed--border boxed--emphasis">
                            <h3>{{ $package->package_name }}</h3>
                            <span class="h2">
                                <strong>{{ g_decimal_place($package->cost_per_year, $currency) }}</strong>
                            </span>
                            <span class="type--fine-print">{{ _lang('Per Year') }}.</span>
                            @if ($package->is_featured == 1)
                                <span class="label">{{ _lang('Value') }}</span>
                            @endif
                            <hr>
                            <ul>
                                <li>
                                    <span class="checkmark bg--primary-1"></span>
                                    @if($package->type == 'free')
                                    {{ $package->websites_limit.' '._lang('Websites') }}
                                    @else
                                    <span>{{ unserialize($package->websites_limit)['yearly'].' '._lang('Websites') }}</span>
                                    @endif
                                </li>
                            </ul>
                            <a class="btn btn--{{ $package->is_featured == 1 ? 'primary-1' : 'primary' }}" href="{{ url('register/client_signup?register/client_signup?package_type=yearly&package='.$package->id) }}">
                                <span class="btn__text">
                                    {{ _lang('Get Started') }}
                                </span>
                            </a>
                        </div>
                        <!--end of pricing-->
                    </div>
                @endforeach
            </div>
            <!--end of row-->
        </div>
        <!--end of container-->
    </section>
    
@endsection

@section('js-script')

<script type="text/javascript">     
    (function($){		
		"use strict";

        $('body').on('click', '#btn-monthly', function(){
            $(this).addClass('btn-hop');
            $(this).removeClass('btn-not-hop');
            $('#btn-6months').removeClass('btn-hop');
            $('#btn-6months').addClass('btn-not-hop');
            $('#btn-yearly').removeClass('btn-hop');
            $('#btn-yearly').addClass('btn-not-hop');
            $('.yearly-package').css('display', 'none');
            $('.6months-package').css('display', 'none');
            $('.monthly-package').css('display', 'block');
            $('#btn-yearly').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-6months').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-monthly').removeClass('btn-outline-info').addClass('btn-primary');
        });

        $('body').on('click', '#btn-6months', function(){
            $(this).addClass('btn-hop');
            $(this).removeClass('btn-not-hop');
            $('#btn-monthly').removeClass('btn-hop');
            $('#btn-monthly').addClass('btn-not-hop');
            $('#btn-yearly').removeClass('btn-hop');
            $('#btn-yearly').addClass('btn-not-hop');
            $('.monthly-package').css('display', 'none');
            $('.yearly-package').css('display', 'none');
            $('.6months-package').css('display', 'block');
            $('#btn-yearly').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-monthly').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-6months').removeClass('btn-outline-info').addClass('btn-primary');
        });

        $('body').on('click', '#btn-yearly', function(){
            $(this).addClass('btn-hop');
            $(this).removeClass('btn-not-hop');
            $('#btn-monthly').removeClass('btn-hop');
            $('#btn-monthly').addClass('btn-not-hop');
            $('#btn-6months').removeClass('btn-hop');
            $('#btn-6months').addClass('btn-not-hop');
            $('.monthly-package').css('display', 'none');
            $('.6months-package').css('display', 'none');
            $('.yearly-package').css('display', 'block');
            $('#btn-6months').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-monthly').removeClass('btn-primary').addClass('btn-outline-info');
            $('#btn-yearly').removeClass('btn-outline-info').addClass('btn-primary');
        });

    })(jQuery); <!-- End jQuery -->
</script>
@endsection
