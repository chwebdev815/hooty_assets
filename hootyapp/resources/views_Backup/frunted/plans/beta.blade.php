@extends('layouts.appFrunted') @section('title', 'Dashboard') 
@section('content')
<div class="stage" id="stage">
    <div class="block block-inverse block-fill-height app-header" style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});">
        @include('frunted.layouts.header')
        <h2 class="text-center">Beta Plan Payment $99</h2>
        <div class="container payment_card col-md-6">
	        <form action="{{URL::route('pay_with_beta')}}" method="post" class="row">
	            {{ csrf_field() }}
	            <div class="col-md-12">
		            <label>Card Number</label>
		            <div class="input-group{{ $errors->has('card_no') ? ' has-error' : '' }}">
					    <input type="text" name="card_no" value="{{ old('card_no') }}" class="form-control" id="card_no" placeholder="Valid Card Number">
					    <div class="input-group-btn">
					      <button class="btn btn-default" type="submit">
					        <i class="fa fa-cc-visa" aria-hidden="true"></i>
					      </button>
					    </div>
					    @if ($errors->has('card_no'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card_no') }}</strong>
                            </span>
                        @endif
					</div>
					<br>
	            </div>
	            <div class="col-md-6">
	            	<div class="form-group {{ $errors->has('ccExpiryMonth') ? ' has-error' : '' }}">
					    <label for="date">Expiration Month</label>
					    <input type="text" name="ccExpiryMonth" id="ccExpiryMonth" class="form-control" placeholder="mm">
					</div>
					@if ($errors->has('ccExpiryMonth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ccExpiryMonth') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="col-md-6">
	            	<div class="form-group {{ $errors->has('ccExpiryYear') ? ' has-error' : '' }}">
					    <label for="date">Expiration Year</label>
					    <input type="text" name="ccExpiryYear" id="ccExpiryYear" class="form-control" placeholder="yy">
					</div>
					@if ($errors->has('ccExpiryYear'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ccExpiryYear') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="col-md-12">
	            	<div class="form-group {{ $errors->has('cvvNumber') ? ' has-error' : '' }}">
					    <label for="cvc">CV Code</label>
					    <input type="text" name="cvvNumber" id="cvvNumber" class="form-control" placeholder="CVC">
					</div>
					@if ($errors->has('cvvNumber'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cvvNumber') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="col-md-12 text-center">
	            	<br>
	            	<button type="submit" class="btn btn-success">Payment</button>
	            </div>
	        </form>
        </div>	
     </div>
</div> 
@endsection 