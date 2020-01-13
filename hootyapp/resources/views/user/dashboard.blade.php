@extends('layouts.appUser')
@section('title', 'Dashboard')
@section('content')

<script>
    function changePeriod() {
        $("#changePeriodForm").submit();
    }

</script>
<?php

    $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
?>
<main class="main wait-for-load">
    <section id="sectionHead" class="pt-3">
        <div class="container">
            <div class="row mx-md-2">
                <div class="col-md-8">
                    <h3 class="text-dark">Dashboard</h3>
                </div>

                <div class="col-md-4 col-sm-12 search_monthly_record">
                    <form action="{{route('home_month')}}" method="post" id="changePeriodForm">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="input-group">
                            <select class="form-control" onchange="changePeriod()" id="example-select" name="monthly">
                                <option value="1" @if($month_no==1) selected="" @endif>January</option>
                                <option value="2" @if($month_no==2) selected="" @endif>February</option>
                                <option value="3" @if($month_no==3) selected="" @endif>March</option>
                                <option value="4" @if($month_no==4) selected="" @endif>April</option>
                                <option value="5" @if($month_no==5) selected="" @endif>May</option>
                                <option value="6" @if($month_no==6) selected="" @endif>June</option>
                                <option value="7" @if($month_no==7) selected="" @endif>July</option>
                                <option value="8" @if($month_no==8) selected="" @endif>August</option>
                                <option value="9" @if($month_no==9) selected="" @endif>September</option>
                                <option value="10" @if($month_no==10) selected="" @endif>October</option>
                                <option value="11" @if($month_no==11) selected="" @endif>November</option>
                                <option value="12" @if($month_no==12) selected="" @endif>December</option>
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
                                    <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4"
                                        data-toggle="tooltip" data-placement="right"
                                        title="Total number of emails sent to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
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
                                    <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4"
                                        data-toggle="tooltip" data-placement="right"
                                        title="Total number of emails delivered to journalists during <?php echo $months[$month_no - 1]; ?>"></i>
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
                                    <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4"
                                        data-toggle="tooltip" data-placement="right"
                                        title="Total number of emails opened by journalists during <?php echo $months[$month_no - 1]; ?>"></i>
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
                                    <i class="fa fa-lg fa-info-circle card-link text-secondary mt-4"
                                        data-toggle="tooltip" data-placement="right"
                                        title="Total number of emails replied by journalists during <?php echo $months[$month_no - 1]; ?>"></i>
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
    {{-- <section id="sectionTable" class="pt-3">
            <div class="container">
                <div class="row mx-md-2">
                    <h5 class="text-dark pl-3">Campaign Report</h5>
                </div>
                <div class="row mx-md-2">
                    <div class="col-md-12">
                        <table id="dashDtable" class="display responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>NO.OF RECIPIENTS</th>
                                    <th>DELIVERED</th>
                                    <th>OPENED</th>
                                    <!-- <th>REPLIED</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($chat_log)) @foreach($chat_log as $value)
                                <tr>
                                    <td>{{$value->title}}</td>
    <td>{{$value->Send}}</td>
    <td>{{$value->Delivery}}</td>
    <td>{{$value->Open}}</td>
    <!-- <td>3</td> -->
    </tr>
    @endforeach @endif
    </tbody>
    </table>
    </div>
    </div>
    </div>
    {{$walk_through_status}}
    </section> --}}
</main>
<script>
    window.walk_through_status =   {{$walk_through_status}}
        
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/5.0.7/highcharts.js"></script>
<script src="{{asset('assets/js/index.js')}}"></script>
@endsection