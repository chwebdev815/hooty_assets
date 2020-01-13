@extends('layouts.appFrunted') @section('title', 'Dashboard') 
@section('content')
<div class="stage" id="stage">
    <div class="block block-inverse block-fill-height app-header" style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});">
        @include('frunted.layouts.header')
        <h2 class="text-center">Payment Seccess</h2>
        <div class="text-center col-md-6 success_style">
			<div class="text_des">
			  <p><img src="{{asset('frontTheme/assets/img/img.png') }}"> Thank You !</p>
			</div>
		</div>	
     </div>
</div> 
@endsection 