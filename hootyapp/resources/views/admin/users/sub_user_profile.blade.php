@extends('admin.layouts.app') @section('title', 'Dashboard') @section('content')

<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li class="active">Message</li>
        <li class="active">Data</li>
    </ol>
    <!-- //breadcrumb-->
    <div id="content">
        <div class="row">
            <div class="col-lg-3">
                <section class="panel">
                    <div class="avatar-slide">
                        <span class="easy-chart avatar-chart" data-color="theme-inverse" data-percent="100%"
                            data-track-color="rgba(255,255,255,0.1)" data-line-width="5" data-size="118">
                            <span class="percent" style="line-height: 118px;">100%</span>
                            @if(empty($profile->image))
                            <img alt="" src="{{asset('user.png')}}" class="circle">
                            @else
                            <img alt="" src="{{$profile->image}}" class="circle">
                            @endif
                            <canvas height="118" width="118"></canvas></span>
                        <!-- //avatar-chart-->

                        <div class="avatar-detail">
                            <p><a href="#">Hi, {{$profile->first_name}}</a></p>
                            <p><a href="#">{{$profile->email}}</a></p>
                        </div>
                        <!-- //avatar-detail-->

                        <div class="avatar-link btn-group btn-group-justified">
                            <a class="btn" href="#" title="Portfolio"><i class="fa fa-briefcase"></i></a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-9">
                <section class="panel">
                    <header class="panel-heading">
                        <h2><strong>User Info</strong> </h2>
                        <!-- <label class="color">Plugin for <strong>Bootstrap3</strong></label> -->
                    </header>
                    <div class="panel-tools fully color" align="right" data-toolscolor="#6CC3A0">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i
                                        class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload" title="Reload"><i
                                        class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i
                                        class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tabbable">
                            <ul id="profile-tab" class="nav nav-tabs" data-provide="tabdrop">
                                <li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle"
                                        data-toggle="dropdown" href="#"><i class="fa fa-align-right"></i> <span
                                            class="badge"></span></a>
                                    <ul class="dropdown-menu"></ul>
                                </li>
                                <li><a href="#" id="prevtab" data-change="prev"><i class="fa fa-chevron-left"></i></a>
                                </li>
                                <li><a href="#" id="nexttab" class="change" data-change="next"><i
                                            class="fa fa-chevron-right"></i></a></li>
                                <li class="active"><a href="#tab1" data-toggle="tab">User info</a></li>
                                <li class=""><a href="#tab2" data-toggle="tab">Groups</a></li>
                            </ul>
                            <div class="tab-content row">
                                <div class="tab-pane fade in active col-lg-12" id="tab1">
                                    <div class="table-responsive table-bordered">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Lebale</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                <tr>
                                                    <th>First Name</th>
                                                    <td>{{$profile->first_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Last Name</th>
                                                    <td>{{$profile->last_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{$profile->email}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade col-lg-12" id="tab2">
                                    <div class="table-responsive table-bordered">
                                        <table id="example" class="table table-striped table-bordered nowrap"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Group Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($group))
                                                @foreach($group as $value)
                                                <tr>
                                                    <td>{{$value->name}}</td>
                                                    <td data-id="{{$value->id}}"><button data-toggle="modal"
                                                            data-target="#md-full-width" type="button"
                                                            class="btn btn-primary show_member">Show Member</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Group Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- //tab-content -->
                        </div>
                    </div>
                </section>
            </div>
            <!-- //content > row > col-lg-12 -->

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->
    <div id="md-full-width" class="modal fade container">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                    class="fa fa-times"></i></button>
            <h4 class="modal-title group_name"></h4>
        </div>
        <!-- //modal-header-->
        <div class="modal-body">
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody align="center" class="member_row_data">
                    </tbody>
                </table>
            </div>
        </div>
        <!-- //modal-body-->
    </div>

    <footer id="site-footer">
        <section>&copy; Copyright 2014, By </section>
    </footer>

</div>

<!-- //main-->

@endsection
<script type="text/javascript">
    var block_url = "<?php echo route('admin_user_block','')?>";
    var active_url = "<?php echo route('admin_user_active','')?>";
    var url = "<?php echo route('admin_user_member','')?>";
</script>
@section('footer_script')