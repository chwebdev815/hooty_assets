@extends('admin.layouts.app') @section('title', 'Dashboard') @section('content')
{!! Charts::assets() !!}
<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">
        <div class="row">
            <form action="{{route('admin_home_month')}}" method="post">
                <div class="col-md-3" style="padding-right: 0px">
                    {{ csrf_field() }}
                    <select class="form-control" name="monthly">
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
                <div class="col-md-4" style="padding-left: 0px">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <BR>
        <div class="row">
            <div class="col-md-3">
                    <div class="well bg-send">
                            <div class="widget-tile">
                                <section>
                                        <h5><strong>Send</strong></h5>
                                        <h2>{!! $Send !!}</h2>
                                </section>
                                <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                            </div>
                    </div>
            </div>
            <div class="col-md-3">
                    <div class="well bg-open">
                            <div class="widget-tile">
                                <section>
                                        <h5><strong>Open</strong></h5>
                                        <h2>{!! $Delivery !!}</h2>
                                </section>
                                <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                            </div>
                    </div>
            </div>
            <div class="col-md-3">
                    <div class="well bg-delivery">
                            <div class="widget-tile">
                                <section>
                                        <h5><strong>Delivery</strong></h5>
                                        <h2>{!! $Open !!}</h2>
                                </section>
                                <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                            </div>
                    </div>
            </div>
            <div class="col-md-3">
                    <div class="well bg-click">
                            <div class="widget-tile">
                                <section>
                                        <h5><strong>Click</strong></h5>
                                        <h2>{!! $Click !!}</h2>
                                </section>
                                <div class="hold-icon"><i class="fa fa-bar-chart-o"></i></div>
                            </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="card-body">
                                {!! $paiChart->render() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                {!! $Clickchart->render() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {!! $Openchart->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy; Copyright 2018, By </section>
    </footer>

</div>

<!-- //main-->

@endsection 
@section('footer_script')