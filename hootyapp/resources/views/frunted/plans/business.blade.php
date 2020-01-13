@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<style>
@media only screen and (min-width: 600px) {
  .w-md-50 {
    width: 50% !important;
  }
}
</style>
<div class="stage" id="stage">
	<div class="block block-inverse block-fill-height app-header" style="background-color:#696969">
		@include('frunted.layouts.header')
		<div class="m-5">
		<h2 class="text-center">HOOTY LITE</h2>
		<p class="text-center">$250 PER YEAR</p>
		<p class="pb-2 text-center">For the first 1k users! (Save $1,250)</p>
		</div>
		<div class="container">


			<div class="d-flex justify-content-center">

				<div class="d-flex flex-column w-100 w-md-50" style="background-color:#a7a5a5;padding:20px">
					<form action="{{URL::route('pay_lite_yearly')}}" method="post" id="payment-form">
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
							<div id="example2-card-cvc"></div>


						</div>
						<div class="p-2">
							<div class="mb-1" id="card-errors" role="alert"></div>


						</div>
						<div class="p-2 text-center">
							<div class="mb-1 " id="card-errors" role="alert"></div>

							<button class="m-2 btn btn-primary make-payment">Start 30-day trial</button>

						</div>
						<!-- Used to display form errors. -->
				</div>
				</form>
			</div>





		</div>
	</div>
</div>

<script src="{{asset('frontTheme/assets/js/jquery.min.js') }}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/stripeFrontend.js')}}"></script>

@endsection