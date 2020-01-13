@extends('layouts.appUser') 
@section('title', 'Dashboard') 
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

<script>
    function changePeriod() {
        $("#changePeriodForm").submit();
    }

</script>

<?php

    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
?>

    <main class="main" style="overflow: hidden; margin-bottom: -26px;">
        <!-- CODE START HERE-->
        <div class="row m-0">
            <div id="report-tab" class="col-md-2  d-sm-down-none p-0" style="height: calc(100vh - 54px);">
                <div id="sideHeader">
                    <div class="h-10 py-2" id="report-tab" style="max-width=25%; border-bottom: 1px #f5f5f5 solid!important;">
                        <!-- <span class="text-dark h5 border-1 px-0 pl-2">Campaigns</span>
                        <div style="border-top:1px solid #00000010; margin-bottom: -5px; margin-top: 5px;">
                            <input class="form-control border-0 rounded-0 px-0 mx-0 p-2" type="text" style="max-width=25%;" placeholder=" Search">
                        </div> -->
                        <h5 class="text-dark h5 border-1 px-0 pl-2 m-0" style="height:60px; line-height:3">Campaigns</h5>
                    </div>
                    <div class="list-group h-100 bg-white mb-5" style="overflow-y: scroll; max-height: calc(100vh - 135px);" role="tablist">
                        <!--DISCOVER PARENT-->
                        @if(!empty($messages)) @foreach($messages as $key=>$value)
                        <a class="list-group-item list-group-item-action border-1 pl-1" href="{{URL::route('getReports',['id' => $value->id])}}">{!! $value->title !!}
                                <i style="position:absolute;right:5px; top:50%; margin-top:-5px; color:#ccc" class="fa fa-chevron-right"></i>
                        </a> @endforeach @endif
                        <!--END-->
                    </div>
                </div>
            </div>
            <div id="reportBox" class="col-md-10 p-0" style="height: calc(100vh - 54px);">
                <div id="campaignName" class="" style="height: calc(100vh - 54px); overflow-y: auto;">
                    <div class="tab-content p-0" id="nav-tabContent">
                        <!--DISCOVER CHILD-->
                        <div class="tab-pane fade show active p-0" id="list_home" role="tabpanel">
                            <section id="sectionHead" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <div class="col-md-8 col-sm-12" style="display: inherit;">
                                            <span href="" class="d-sm-block d-lg-none input-group-addon pr-2 sidePanelBack text-muted" id="backKey"><i class="fa fa-angle-left fa-2x d-md-none"></i></span>
                                            <h3 class="text-dark">{{ $message[0]->title }} </h3> <span class="m-0 badge badge-pill badge-secondary ml-2 mt-2 pl-1 pt-1 text-center"
                                                style="height: 20px">Press Pitch</span>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <form action="{{route('getReportsByDate', ['id' => $message[0]->id])}}" id="changePeriodForm" method="post">
                                                {{ csrf_field() }}
                                                <div class="input-group">
                                                    <select onChange="changePeriod()" class="form-control" id="example-select" name="monthly">
                                                        <option value="1" @if($month_no == 1) selected="" @endif>January</option>
                                                        <option value="2" @if($month_no == 2) selected="" @endif>February</option>
                                                        <option value="3" @if($month_no == 3) selected="" @endif>March</option>
                                                        <option value="4" @if($month_no == 4) selected="" @endif>April</option>
                                                        <option value="5" @if($month_no == 5) selected="" @endif>May</option>
                                                        <option value="6" @if($month_no == 6) selected="" @endif>June</option>
                                                        <option value="7" @if($month_no == 7) selected="" @endif>July</option>
                                                        <option value="8" @if($month_no == 8) selected="" @endif>August</option>
                                                        <option value="9" @if($month_no == 9) selected="" @endif>September</option>
                                                        <option value="10" @if($month_no == 10) selected="" @endif>October</option>
                                                        <option value="11" @if($month_no == 11) selected="" @endif>November</option>
                                                        <option value="12" @if($month_no == 12) selected="" @endif>December</option> 
                                                </select>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="sectionBoxes" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center ">
                                                <div class="card-body">
                                                    <h1 class="font-weight-bold">{!! $Send !!}
                                                        <sup class="explanation">
                                                        <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4" data-toggle="tooltip" data-placement="right" title="Total number of emails sent to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
                                                    </sup>
                                                    </h1>
                                                    <p class="text-muted mb-0">Send</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center ">
                                                <div class="card-body">
                                                    <h1 class="font-weight-bold">{!! $Delivery !!}
                                                        <sup class="explanation">
                                                        <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4" data-toggle="tooltip" data-placement="right" title="Total number of emails sent to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
                                                    </sup>
                                                    </h1>
                                                    <p class="text-muted mb-0">Delivered</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center ">
                                                <div class="card-body">
                                                    <h1 class="font-weight-bold">{!! $Open !!}
                                                        <sup class="explanation">
                                                        <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4" data-toggle="tooltip" data-placement="right" title="Total number of emails sent to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
                                                    </sup>
                                                    </h1>
                                                    <p class="text-muted mb-0">Opened</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="card text-center ">
                                                <div class="card-body">
                                                    <h1 class="font-weight-bold">{!! $Click !!}
                                                        <sup class="explanation">
                                                        <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4" data-toggle="tooltip" data-placement="right" title="Total number of emails sent to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
                                                    </sup>
                                                    </h1>
                                                    <p class="text-muted mb-0">Replied</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="sectionGraph" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- <canvas id="chartOpenRates" class="text-muted"></canvas> -->
                                                    {!! $Openchart->render() !!}

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- <canvas id="chartReplyRates"></canvas> -->
                                                    {!! $Clickchart->render() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="sectionTable" class="pt-3">
                                <div class="container">
                                    <div class="row mx-md-2">
                                        <h5 class="text-dark pl-3">Listwise Report</h5>
                                    </div>
                                    <div class="row mx-md-2 mb-5 pb-5">
                                        <div class="col-md-12">
                                            @if(!empty($listwise_reports && sizeof($listwise_reports) > 0))
                                            <table id="listWiseReport" class="display responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>LIST NAME</th>
                                                        <th>NO.OF RECIPIENTS</th>
                                                        <th>DELIVERED</th>
                                                        <th>OPENED</th>
                                                        <th>REPLIED</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($listwise_reports as $value)
                                                    <tr>
                                                        <td>{{$value->name}}</td>
                                                        <td>{{round(sqrt($value->TotalMembers))}}</td>
                                                        <td>{{$value->Delivery}}</td>
                                                        <td>{{$value->Open}}</td>
                                                        <td>{{$value->Click}}</td>
                                                        <!-- <td>3</td> -->
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            @elseif (!empty($journalist_wise_reports && sizeof($journalist_wise_reports) > 0))
                                            <table id="listWiseReport" class="display responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>JOURNALIST</th>
                                                        <th>DELIVERED</th>
                                                        <th>OPENED</th>
                                                        <th>REPLIED</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($journalist_wise_reports as $value)
                                                    <tr>
                                                        <td>{{$value->First_name}}</td>

                                                        @if($value->Delivery > 0)
                                                        <td><i class="fa fa-check"></i></td>
                                                        @else
                                                        <td>-</td>
                                                        @endif @if($value->Open > 0)
                                                        <td><i class="fa fa-check"></i></td>
                                                        @else
                                                        <td>-</td>
                                                        @endif @if($value->Click > 0)
                                                        <td><i class="fa fa-check"></i></td>
                                                        @else
                                                        <td>-</td>
                                                        @endif
                                                        <!-- <td>3</td> -->
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            @endif
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
    <script src="{{asset('assets/js/reports.js') }}"></script>
@endsection