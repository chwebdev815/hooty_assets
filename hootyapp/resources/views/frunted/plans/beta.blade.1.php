@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<style>

</style>
<div class="stage" id="stage">
    <div class="block block-inverse block-fill-height app-header" style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});">
        @include('frunted.layouts.header')
				<h2 class="text-center">HOOTY LITE</h2>
				<p  class="text-center">$125 PER MONTH</p>
        <div class="container payment_card ">

				<div class="row">
				<div class="d-flex flex-column w-50" style="background-color:#a7a5a5;padding:20px">
				<form action="{{URL::route('pay_lite_monthly')}}" method="post"  id="payment-form">
		     		{{ csrf_field() }}
						<div class="p-2">
							<label class="mb-1" for="card-element">
										Credit or debit card
							</label>

						</div>
						<div class="p-2">

							<div class="mb-1" id="card-element"></div>
						</div>
						<div class="p-2">
										<div class="mb-1" id="example2-card-number">

										</div>
						</div>
						<div class="p-2">
						<div class="mb-1" id="example2-card-expiry"></div>

						</div>
						<div class="p-2">
						<div id="example2-card-cvc" ></div>


						</div>
						<div class="p-2">
						<div class="mb-1" id="card-errors" role="alert"></div>


						</div>
						<div class="p-2 text-center">
						<div class="mb-1 " id="card-errors" role="alert"></div>

						<button class="m-2 btn btn-primary">Submit Payment</button>

						</div>
					<!-- Used to display form errors. -->
					</div>
					</form>
				</div>

				</div>


        </div>
     </div>
</div>

<script src="{{asset('frontTheme/assets/js/jquery.min.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/stripeFrontend.js')}}"></script>

@endsection
