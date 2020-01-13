@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<div class="stage" id="stage">
  <div class="block block-inverse block-fill-height app-header"
    style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});padding: 100px 0rem 0px 0px;">
    @include('frunted.layouts.header')

    <div class="block app-price-plans">
      <div class="container text-center">

        <div class="row mb-5 justify-content-center">
          <div class="col-10 col-md-8 col-lg-6">
            <h6 class="text-muted text-uppercase mb-2">Business Talk</h6>
            <h2>No plans. We just bump your plan whenever you need it.</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 px-4 pb-2 mb-5">
            <div class="px-2 mb-2">
              <h6 class="text-muted text-uppercase mb-4">Beta</h6>
              <h1>$99</h1>
            </div>

            <ul class="list-unstyled list-bordered text-xs-left my-4">
              <li class="py-4"><strong>10k</strong> monthly requests</li>
              <li class="py-4"><strong>9am-5pm</strong> technical supprt</li>
              <li class="py-4"><strong>Public</strong> API access</li>
            </ul>

            <a href="{{URL::route('beta_plan')}}" class="btn btn-lg btn-primary btn-block">
              Start <span class="d-none d-xl-inline">a personal account</span>
            </a>
          </div>

          <div class="col-md-4 px-4 pb-2 mb-5">
            <div class="px-2">
              <h6 class="text-muted text-uppercase mb-4">Business</h6>
              <h1>$149</h1>
              <p class="pb-2">The perfect sized plan for small businesses to get started.</p>
            </div>

            <ul class="list-unstyled list-bordered text-xs-left my-4">
              <li class="py-4"><strong>100k</strong> monthly requests</li>
              <li class="py-4"><strong>24/7</strong> technical supprt</li>
              <li class="py-4"><strong>Public</strong> API access</li>
            </ul>

            <a href="{{URL::route('business_plan')}}" class="btn btn-lg btn-primary btn-block">
              Start <span class="d-none d-xl-inline">a business account</span>
            </a>
          </div>

          <div class="col-md-4 px-4 pb-1 mb-5">
            <div class="px-2">
              <h6 class="text-muted text-uppercase mb-4">Agency</h6>
              <h1>$400</h1>
              <p class="pb-2">An unlimited plan that will scale infinitely to any size project.</p>
            </div>

            <ul class="list-unstyled list-bordered text-xs-left my-4">
              <li class="py-4"><strong>Unlimited</strong> monthly requests</li>
              <li class="py-4"><strong>24/7</strong> technical supprt</li>
              <li class="py-4"><strong>Public &amp; Private</strong> API access</li>
            </ul>

            <a href="{{URL::route('agency_plan')}}" class="btn btn-lg btn-primary btn-block">
              Start <span class="d-none d-xl-inline">a corporate account</span>
            </a>
          </div>
        </div>

      </div>
    </div>
    <div class="block block-inverse app-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-5 mb-5">
            <ul class="list-unstyled list-spaced">
              <li class="mb-2">
                <h6 class="text-uppercase">About</h6>
              </li>
              <li class="text-muted">
                We’ve been working on Go Analytics for the better part of a decade and are super proud of what we’ve
                created. If you’d like to learn more, or are interested in a job, contact us anytime at <a
                  href="mailto: themes@getbootstrap.com">themes@getbootstrap.com</a>.
              </li>
            </ul>
          </div>
          <div class="col-md-2 ml-auto mb-5">
            <ul class="list-unstyled list-spaced">
              <li class="mb-2">
                <h6 class="text-uppercase">Product</h6>
              </li>
              <li class="text-muted">Features</li>
              <li class="text-muted">Examples</li>
              <li class="text-muted">Tour</li>
              <li class="text-muted">Gallery</li>
            </ul>
          </div>
          <div class="col-md-2 mb-5">
            <ul class="list-unstyled list-spaced">
              <li class="mb-2">
                <h6 class="text-uppercase">Apis</h6>
              </li>
              <li class="text-muted">Rich data</li>
              <li class="text-muted">Simple data</li>
              <li class="text-muted">Real time</li>
              <li class="text-muted">Social</li>
            </ul>
          </div>
          <div class="col-md-2 mb-5">
            <ul class="list-unstyled list-spaced">
              <li class="mb-2">
                <h6 class="text-uppercase">Legal</h6>
              </li>
              <li class="text-muted">Terms</li>
              <li class="text-muted">Legal</li>
              <li class="text-muted">Privacy</li>
              <li class="text-muted">License</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
  @endsection