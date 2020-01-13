@extends('layouts.appFrunted') @section('title', 'Dashboard')
@section('content')
<div class="stage" id="stage">
  <div class="block block-inverse block-fill-height app-header"
    style="background-image: url({{asset('frontTheme/assets/img/startup-1.jpg') }});">
    @include('frunted.layouts.header')


    <img class="app-graph" src="{{asset('frontTheme/assets/img/startup-0.svg') }}">

    <div class="block-xs-middle pb-5">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <h1 class="block-titleData frequency text-center">HOOTY is the AI that gets you press.</h1>
          </div>
          <div class="col-xs-5 col-md-4 ">
            <!-- top_slider_img -->
            <img src="{{asset('frontTheme/assets/img/Hooty-Chatbot-2.png') }}" width="100%">
          </div>
          <div class="col-xs-7 col-md-8">
            <br>
            <p class="lead mb-4 text-muted">Hooty <b>writes</b> your pitch.</p>
            <p class="lead mb-4 text-muted">Send to our <b>1.5m+</b> journalist database.</p>
            <p class="lead mb-4 text-muted">And, distribute <b>unlimited</b> press releases.</p>
            @guest
            <a href="{{URL::route('register')}}" class="btn btn-primary btn-lg">Create Account</a>
            @else
            <button class="btn btn-primary btn-lg">BOOK TICKETS</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="block block-secondary app-iphone-block">
    <div class="container">
      <div class="row app-align-center">

        <div class="col-sm-7 d-none d-md-block">
          <img class="app-iphone" src="{{asset('frontTheme/assets/img/Search-3.png') }}" style="width: 100%;">
        </div>

        <div class="col-md-5 col-sm-12 ml-auto">
          <h2>Meet Hooty</h2>
          <h4>Ditch your publicist forever.</h4>
          <p class="lead mb-4">Hooty helps you reach out to our 1.5m database of journalists and columnists to get you
            the press you need.</p>
        </div>
      </div>

    </div>
  </div>

  <div class="block block-inverse block-secondary app-code-block">
    <div class="container">
      <div class="row app-align-center">
        <div class="col-md-6 order-2 order-md-1">
          <div class="row enrite">
            <div class="col-xs-9 col-md-9 text-right">
              <h4 class="m-b-0">Chat with Hooty</h2>
                <p>Chat with Hooty to get your pitch ready to distribute</p>
            </div>
            <div class="col-xs-3 col-md-3">
              <img src="{{asset('frontTheme/assets/img/Hooty-Chatbot-3.png') }}" style="width: 85%;/* height: 100px; */"
                alt="varun" class="img-circle img-responsive">
            </div>

            <div class="col-xs-9 col-md-9 text-right">
              <h4 class="m-b-0">Search our database</h2>
                <p>Search our 1.5m+ journalist database by outlet or beat.</p>
            </div>
            <div class="col-xs-3 col-md-3">
              <img src="{{asset('frontTheme/assets/img/entire/icon1.png') }}" style="width: 85%;" alt="varun"
                class="img-circle img-responsive">
            </div>

            <div class="col-xs-9 col-md-9 text-right">
              <h4 class="m-b-0">Pitch journalists</h2>
                <p>Create journalist lists and send your press pitch to your journalist list</p>
            </div>
            <div class="col-xs-3 col-md-3">
              <img src="{{asset('frontTheme/assets/img/entire/icon2.png') }}" style="width: 85%;" alt="varun"
                class="img-circle img-responsive">
            </div>

            <div class="col-xs-9 col-md-9 text-right">
              <h4 class="m-b-0">Distribute unlimited press releases</h2>
                <p>Send as many press releases as you’d like</p>
            </div>
            <div class="col-xs-3 col-md-3">
              <img src="{{asset('frontTheme/assets/img/entire/icon6.png') }}" style="width: 85%;" alt="varun"
                class="img-circle img-responsive">
            </div>
          </div>
        </div>
        <div class="col-md-5 ">
          <!-- ml-auto order-1 order-md-2 -->
          <img src="{{asset('frontTheme/assets/img/Hooty-slider-1.png') }}" style="width: 100%;">
        </div>
      </div>
    </div>
  </div>

  <div class="block block-inverse app-high-praise"
    style="background-image: url({{asset('frontTheme/assets/img/startup-3.jpg') }})">
    <div class="container">
      <div class="row app-align-center py-3 justify-content-end">
        <div class="col-sm-7 col-md-5 py-5">
          <h6 class="text-muted text-uppercase mb-2">High Praise</h6>
          <h2 class="mb-4">“Go Analytics is amazing. Decisions that used to take weeks, now only takes minutes and is
            available to everyone on my team.”</h2>
          <p class="mb-4 text-muted">Cindy Smith, founder of Cool Startup</p>
        </div>
      </div>
    </div>
  </div>

  <div class="block app-ribbon py-5">
    <div class="container text-xs-center">
      <img src="{{asset('frontTheme/assets/img/startup-4.svg') }}">
      <img src="{{asset('frontTheme/assets/img/startup-5.svg') }}">
      <img src="{{asset('frontTheme/assets/img/startup-6.svg') }}">
      <img src="{{asset('frontTheme/assets/img/startup-7.svg') }}">
      <img src="{{asset('frontTheme/assets/img/startup-8.svg') }}">
    </div>
  </div>

  <div class="block block-secondary app-block-marketing-grid">
    <div class="container text-xs-center">

      <div class="row mb-5 justify-content-center">
        <div class="col-10 col-sm-8 col-lg-6">
          <h6 class="text-muted text-uppercase mb-2">Inside the machine</h6>
          <h2 class="mb-4">It’s not hard to see how we make your life easier every day.</h2>
        </div>
      </div>

      <div class="row app-marketing-grid">
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-9.svg') }}">
          <p><strong>Hooty Writes Your Pitch For You.</strong></p>
          <p>Stop Wasting Time And Money Writing Your Pitch. Let Hooty Handle It For You.</p>
        </div>
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-10.svg') }}">
          <p><strong>Send To Our 1.5m+ Database.</strong></p>
          <p>Stop Wasting Time And Money Trying To Find The Right Journalist To Cover Your Story.</p>
        </div>
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-11.svg') }}">
          <p><strong>Push Press Releases Too!</strong></p>
          <p>In Hooty 2.0, You’ll Be Able To Send And Distribute Press Releases Too!</p>
        </div>
      </div>

      <div class="row app-marketing-grid">
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-12.svg') }}">
          <p><strong>Rich calculations.</strong> Limitless ways to splice and dice your data.</p>
        </div>
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-13.svg') }}">
          <p><strong>Mobile apps.</strong> iOS and Android apps available for monitoring.</p>
        </div>
        <div class="col-md-4 px-4 mb-5">
          <img class="mb-1" src="{{asset('frontTheme/assets/img/startup-14.svg') }}">
          <p><strong>Secure connections.</strong> Every single request is routed through HTTPS.</p>
        </div>
      </div>
    </div>
  </div>

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