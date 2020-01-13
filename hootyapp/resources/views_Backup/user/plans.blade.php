@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<div class="container-fluid">                 
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index') }}">Frontend</a></li>
                        <li class="breadcrumb-item active">Plans</li>
                    </ol>
                </div>
                <h4 class="page-title">Plans</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 


    <div class="row justify-content-center">
        <div class="col-xl-10">

            <!-- Pricing Title-->
            <div class="text-center">
                <h3 class="mb-2">Your Plans is expired </h3>
                <p class="text-muted w-50 m-auto">
                    We have plans and prices that fit your business perfectly. Make your client site a success with our products.
                </p>
            </div>

            <!-- Plans -->
            <div class="row mt-sm-5 mt-3 mb-3">
                <div class="col-md-4">
                    <div class="card card-pricing @if(!empty($last_paln)) @if($last_paln->plan == 1) card-pricing-recommended @endif @endif">
                        <div class="card-body text-center">
                            @if(!empty($last_paln))
                                @if($last_paln->plan == 1)
                                <div class="card-pricing-plan-tag">My old plan</div>
                                @endif
                            @endif
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">Beta</p>
                            <i class="card-pricing-icon dripicons-user text-primary"></i>
                            <h2 class="card-pricing-price">$99 <span>/ Month</span></h2>
                            <ul class="card-pricing-features">
                                <li>10k monthly requests</li>
                                <li>9am-5pm technical supprt</li>
                                <li>Public API access</li>
                                <li>1000 User</li>
                                <li>Email Support</li>
                            </ul>
                            <a href="{{URL::route('beta_plan')}}" class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</a>
                        </div>
                    </div> <!-- end Pricing_card -->
                </div> <!-- end col -->

                <div class="col-md-4">
                    <div class="card card-pricing @if(!empty($last_paln)) @if($last_paln->plan == 2) card-pricing-recommended" @endif @endif">
                        <div class="card-body text-center">
                            @if(!empty($last_paln))
                                @if($last_paln->plan == 2)
                                <div class="card-pricing-plan-tag">My old plan</div>
                                @endif
                            @endif
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">Business</p>
                            <i class="card-pricing-icon dripicons-briefcase text-primary"></i>
                            <h2 class="card-pricing-price">$149 <span>/ Month</span></h2>
                            <ul class="card-pricing-features">
                                <li>100k monthly requests</li>
                                <li>24/7 technical supprt</li>
                                <li>Public API access</li>
                                <li>10000 User</li>
                                <li>Email Support</li>
                            </ul>
                            <a href="{{URL::route('business_plan')}}" class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</a>
                        </div>
                    </div> <!-- end Pricing_card -->
                </div> <!-- end col -->

                <div class="col-md-4">
                    <div class="card card-pricing @if(!empty($last_paln)) @if($last_paln->plan == 3) card-pricing-recommended" @endif @endif">
                        <div class="card-body text-center">
                            @if(!empty($last_paln)) 
                                @if($last_paln->plan == 3)
                                <div class="card-pricing-plan-tag">My old plan</div>
                                @endif
                            @endif
                            <p class="card-pricing-plan-name font-weight-bold text-uppercase">Agency</p>
                            <i class="card-pricing-icon dripicons-store text-primary"></i>
                            <h2 class="card-pricing-price">$400 <span>/ Month</span></h2>
                            <ul class="card-pricing-features">
                                <li>Unlimited monthly requests</li>
                                <li>24/7 technical supprt</li>
                                <li>Public API access</li>
                                <li>Unlimited User</li>
                                <li>Email Support</li>
                            </ul>
                            <a href="{{URL::route('agency_plan')}}" class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</a>
                        </div>
                    </div> <!-- end Pricing_card -->
                </div> <!-- end col -->

            </div>
            <!-- end row -->

        </div> <!-- end col-->
    </div>
    <!-- end row -->
    
</div>
@endsection 

@section('footer_script')
<script src="{{asset('userTheme/assets/js/vendor/jquery.dataTables.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.html5.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.flash.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.print.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.keyTable.min.js') }}"></script>


<script src="{{asset('userTheme/assets/js/pages/demo.datatable-init.js') }}"></script>
@endsection
