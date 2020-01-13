@extends('layouts.appUser') @section('title', 'Dashboard') 
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
.btn-xs{line-height: 0.8;}
.email_click_lict div.dataTables_wrapper div.dataTables_filter input{width: 120px;}
</style>
{!! Charts::assets() !!}
<div class="container-fluid">

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index') }}">Frontend</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title col-md-4 col-sm-12">Dashboard</h4>
                <div class="col-md-4 col-sm-12 search_monthly_record">    
                    <form action="{{route('home_month')}}" method="post">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <select class="form-control" id="example-select" name="monthly">
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
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- <div class="card">
        <div class="card-body">
            <form action="{{route('home_type_date')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xl-3">
                        <a href="{{route('home')}}" type="button" class="btn btn-block @if((Request::is('home'))) btn-success @else btn-primary @endif">Last Week</a>
                    </div>
                    <div class="col-xl-3">
                        <a href="{{route('home_month')}}" type="button" class="btn btn-block @if((Request::is('home/month'))) btn-success @else btn-primary @endif"">Last Month</a>
                    </div>
                        <div class="col-xl-4" style="padding-right: 0px;">
                            <input type="text" name="date" class="form-control date" id="daterangetime" data-toggle="date-picker" data-time-picker="true" data-locale="{'format': 'YY-m-d'}">
                        </div>
                        <div class="col-xl-2" style="padding-left: 0px;">
                            <button type="submit" class="btn btn-block @if((Request::is('home/Date'))) btn-success @else btn-primary @endif"">Apply</button>
                        </div>
                </div>
            </form>
        </div>
    </div> -->
    <div class="row">
        <div class="col-lg-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="mdi mdi-account-multiple widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Send">Send</h5>
                    <h3 class="mt-3 mb-3">{!! $Send !!}</h3>
                    <!-- <p class="mb-0 text-muted">
                        <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p> -->
                </div> 
            </div> 
        </div> 

        <div class="col-lg-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="mdi mdi-cart-plus widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Open">Open</h5>
                    <h3 class="mt-3 mb-3">{!! $Open !!}</h3>
                </div> 
            </div> 
        </div> 
        <div class="col-lg-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="mdi mdi-currency-usd widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Delivery">Delivery</h5>
                    <h3 class="mt-3 mb-3">{!! $Delivery !!}</h3>
                </div> 
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-right">
                        <i class="mdi mdi-pulse widget-icon"></i>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-0" title="Number of Click">Click</h5>
                    <h3 class="mt-3 mb-3">{!! $Click !!}</h3>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $paiChart->render() !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            {!! $Clickchart->render() !!}
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            {!! $Openchart->render() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Compaigns</th>
                                        <th>Send</th>
                                        <th>Delivery</th>
                                        <th>Open</th>
                                        <th>Click</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($chat_log))
                                    @foreach($chat_log as $value)
                                    <tr>
                                        <td>{{$value->title}}</td>
                                        <td>{{$value->Send}}</td>
                                        <td>{{$value->Delivery}}</td>
                                        <td>{{$value->Open}}</td>
                                        <td data-id="{{$value->campaign_id}}">
                                            <button type="button" class="btn btn-success btn-xs show_email_click_list">{{$value->Click}}</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Compaigns</th>
                                        <th>Send</th>
                                        <th>Delivery</th>
                                        <th>Open</th>
                                        <th>Click</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 email_click_lict">
                    <div class="card">
                        <h4 class="text-center">Click List</h4>
                        <div class="card-body">
                            <table id="basic-datatable" class="table dt-responsive nowrap dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Click</th>
                                    </tr>
                                </thead>
                                <tbody class="user_click_list">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Compaigns</th>
                                        <th>Click</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <h4 class="text-center">Latest Reply Message List</h4>
                        <div class="card-body">
                            <table id="selection-datatable" class="table dt-responsive nowrap dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Open</th>
                                        <th>Text Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($message))
                                    @foreach($message as $key=>$value)
                                    <tr>
                                        <td>
                                            {!! $key + 1 !!}
                                        </td>
                                        <td>{!! $value->title !!}</td>
                                        <td>{!! date_format($value->created_at, 'F j, Y') !!}</td>
                                        <td>
                                            @if($value->chat_status != 0)
                                            <a href="{{URL::route('message_show',$value->id)}}">
                                                <button type="button" class="btn btn-outline-success btn-rounded">{{$value->chat_status}} New</button>
                                            </a>
                                            @endif
                                        </td>
                                        <td>{!! $value->text !!}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Open</th>
                                        <th>Text Message</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->
    </div>

</div>
@endsection
@section('footer_script')
<script type="text/javascript">
    var url = "<?php echo route('show_email_click_list','')?>";
</script>
<script src="{{asset('userTheme/assets/js/vendor/jquery.dataTables.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.html5.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.flash.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/buttons.print.min.js') }}"></script>
<script src="{{asset('userTheme/assets/js/vendor/dataTables.keyTable.min.js') }}"></script>

<script src="{{asset('userTheme/assets/js/pages/demo.datatable-init.js') }}"></script>
@endsection 