@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
    <link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <main class="main" style="overflow: hidden; margin-bottom: -26px;">
        <!-- CODE START HERE-->
        <div class="row">
            <div class="col-md-3 p-0" id="report-tab" style="height: calc(100vh - 54px);">
                <div id="sideHeader" class="pl-1">
                    <div class="h-10 py-2 px-3" id="report-tab" style="max-width=25%; border-bottom: 1px #f5f5f5 solid!important;"> <span class="text-dark h5 border-1 px-0 pl-2">Campaigns</span>
                        <input class="form-control border-0 rounded-0 px-0 mx-0 py-2 pl-2" type="text" style="max-width=25%;" placeholder=" Search"> </div>
                    <div class="list-group h-100 bg-white mb-5 pl-3" style="overflow-y: scroll; max-height: calc(100vh - 135px);" role="tablist">
                        <!--DISCOVER PARENT-->
                        @if(!empty($message))
                        @foreach($message as $key=>$value)
                        <a class="list-group-item list-group-item-action border-0 pl-1" id="campaignList" data-id="{!! $value->id !!}" data-link="#reportSection" href="#list-home" data-toggle="list">{!! $value->title !!}</a>
                        @endforeach
                        @endif
                        <!--END-->
                    </div>
                </div>
            </div>
            <div class="col-md-9 d-sm-down-none" id="reportBox" style="height: calc(100vh - 54px);">
                <div id="campaignName" class="" style="height: calc(100vh - 54px); overflow-y: auto;">
                    <div class="tab-content p-0" id="nav-tabContent">
                        <!--DISCOVER CHILD-->
                        <div class="tab-pane fade show active p-0" id="list_home" role="tabpanel">
                            <section id="sectionHead" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2"> <span href="" class="input-group-addon sidePanelBack pl-2 text-muted" id="backKey"><i class="fa fa-angle-left fa-2x d-md-none"></i></span>
                                        <h3 class="text-dark ml-3">Campaign Name </h3> <span class="m-0 badge badge-pill badge-secondary ml-2 mt-2 pl-1 pt-1 text-center" style="height: 20px">Press Pitch</span> </div>
                                </div>
                            </section>
                            <section class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h1>39</h1>
                                                    <p class="text-muted mb-0">Send</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h1>21</h1>
                                                    <p class="text-muted mb-0">Delivered</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h1>14</h1>
                                                    <p class="text-muted mb-0">Opened</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <h1>5</h1>
                                                    <p class="text-muted mb-0">Replied</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <canvas id="chartOpenRates"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <canvas id="chartReplyRates"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="sectionTable" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <h5 class="text-dark pl-3">Campaign Report</h5> </div>
                                    <div class="row mx-md-2">
                                        <div class="col-md-12">
                                            <table id="example" class="display responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>NAME</th>
                                                        <th>NO.OF RECIPIENTS</th>
                                                        <th>DELIVERED</th>
                                                        <th>OPENED</th>
                                                        <th>REPLIED</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td>15</td>
                                                        <td>2</td>
                                                        <td>1</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td>15</td>
                                                        <td>2</td>
                                                        <td>1</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td>15</td>
                                                        <td>2</td>
                                                        <td>1</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Test</td>
                                                        <td>15</td>
                                                        <td>2</td>
                                                        <td>1</td>
                                                        <td>3</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Andrew</td>
                                                        <td>23</td>
                                                        <td>4</td>
                                                        <td>8</td>
                                                        <td>61</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Andrew</td>
                                                        <td>23</td>
                                                        <td>4</td>
                                                        <td>8</td>
                                                        <td>61</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Andrew</td>
                                                        <td>23</td>
                                                        <td>4</td>
                                                        <td>8</td>
                                                        <td>61</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{asset('assets/js/reports.js') }}"></script>
@endsection