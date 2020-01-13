@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<div class="stage" id="stage">
  <div class="block block-inverse block-fill-height app-header"
    style="background-color:#696969;padding: 100px 0rem 0px 0px;">
    @include('frunted.layouts.header')

    <div class="block app-price-plans" style="background-color:#696969;">
      <div class="container text-center">

        <div class="row mb-5 justify-content-center">
          <div class="col-10 col-md-8 col-lg-6">
            <h5 class="text-uppercase mb-2 text-light">Pricing Plans</h5>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 p-4 pb-2 mb-5">
            <div class="bg-white p-4">
              <div class="px-2 mb-2">
                <h6 class="text-muted text-uppercase mb-4">Hooty Lite</h6>
                <h1>$125 PER MONTH</h1>
              </div>

              <ul class=" text-center list-unstyled list-bordered text-xs-left my-4">
                <li class="py-4"><span class="fa fa-check mr-1"></span>Journalist Database</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Pitch Builder</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Video pitch builder</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Article database</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Newsjacking alerts</li>

              </ul>

              <a href="{{URL::route('hooty_lite_monthly')}}" class="btn btn-lg btn-primary btn-block">
                GET STARTED <span class="d-none d-xl-inline"> 30-DAY FREE TRIAL</span>
              </a>
            </div>
          </div>

          <div class="col-md-6 p-4 pb-2 mb-5">
            <div class="bg-white p-4">
              <div class="px-2">
                <h6 class="text-muted text-uppercase mb-4">Hooty Lite
                  For the first 1k users! (Save $1,250)</h6>
                <h1>$250 PER YEAR</h1>
              </div>

              <ul class="text-center list-unstyled list-bordered text-xs-left my-4">
                <li class="py-4"><span class="fa fa-check mr-1"></span>Journalist Database</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Pitch Builder</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Video pitch builder</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Article database</li>
                <li class="py-4"><span class="fa fa-check  mr-1"></span>Newsjacking alerts</li>
              </ul>

              <a href="{{URL::route('hooty_lite_yearly')}}" class="btn btn-lg btn-primary btn-block">
                GET STARTED <span class="d-none d-xl-inline">30-DAY FREE TRIAL</span>
              </a>
            </div>
          </div>


        </div>

      </div>
    </div>


  </div>

  @endsection