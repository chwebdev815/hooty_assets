@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
    <link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <main class="main" style="overflow: hidden; margin-bottom: -26px;">
        <!-- CODE START HERE-->
        <div class="row m-0">
            <div id="report-tab" class="col-md-12 p-0" style="height: calc(100vh - 54px);">
                <div id="sideHeader">
                    <div class="h-10 py-2" id="report-tab" style="max-width=25%; border-bottom: 1px #f5f5f5 solid!important;">
                        <span class="text-dark h5 border-1 px-0 pl-2">Campaigns</span>
                        <div style="border-top:1px solid #00000010; margin-bottom: -5px; margin-top: 5px;">
                            <input class="form-control border-0 rounded-0 px-0 mx-0 p-2" type="text" style="max-width=25%;" placeholder=" Search">
                        </div>
                    </div>
                    <div class="list-group h-100 bg-white mb-5" style="overflow-y: scroll; max-height: calc(100vh - 135px);" role="tablist">
                        <!--DISCOVER PARENT-->
                        @if(!empty($messages))
                        @foreach($messages as $key=>$value)
                        <a class="list-group-item list-group-item-action border-0 pl-1" href="{{URL::route('getReports',['id' => $value->id])}}" >{!! $value->title !!}</a>
                        @endforeach
                        @endif
                        <!--END-->
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
    <script src="{{asset('assets/js/reports.js') }}"></script>
@endsection