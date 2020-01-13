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
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2><strong>User List</strong>  </h2>
                        <!-- <label class="color">Plugin for <strong>Bootstrap3</strong></label> -->
                    </header>
                    <div class="panel-tools fully color" align="right" data-toolscolor="#6CC3A0">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload" title="Reload"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <form>
                            <div class="">
                                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($user))
                                        @foreach($user as $key=>$value)
                                        <tr>

                                            <td>{!! $key !!}</td>
                                            <td>{!! $value->first_name !!}</td>
                                            <td>{!! $value->last_name !!}</td>
                                            <td>{!! $value->email !!}</td>
                                            <td>
                                                <span class="block_btn_{{$value->id}} @if($value->user_status != 1) display_non @endif">Active</span> 
                                                <span class="active_btn_{{$value->id}} @if($value->user_status == 1) display_non @endif">Block</span> 
                                            </td>
                                            <td data-id="{{$value->id}}">
                                                <a href="{{URL::route('user_profile',$value->id)}}">
                                                    <button type="button" class="btn btn-theme-inverse">Show</button>
                                                </a>
                                                <a href="{{URL::route('admin_sub_user',$value->id)}}">
                                                    <button type="button" class="btn btn-primary">Show Sub User</button>
                                                </a>
                                                <button type="button" class="btn btn-danger block_btn block_btn_{{$value->id}} @if($value->user_status != 1) display_non @endif">Block</button>
                                                <button type="button" class="btn btn-success active_btn active_btn_{{$value->id}} @if($value->user_status == 1) display_non @endif">Active</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <!-- //content > row > col-lg-12 -->

        </div>
        <!-- //content > row-->

    </div>
    <!-- //content-->

    <footer id="site-footer">
        <section>&copy; Copyright 2014, By </section>
    </footer>

</div>

<!-- //main-->
<script type="text/javascript">
    var block_url = "<?php echo route('admin_user_block','')?>";
    var active_url = "<?php echo route('admin_user_active','')?>";
</script>
@endsection 
@section('footer_script')