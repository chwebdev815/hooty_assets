@extends('admin.layouts.app') @section('title', 'Dashboard') @section('content')

<div id="main">

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><a href="#">Library</a></li>
        <li class="active">Data</li>
    </ol>
    <!-- //breadcrumb-->

    <div id="content">

        <div class="row">

            <div class="col-lg-6">
                <section class="panel corner-flip">
                    <header class="panel-heading sm" data-color="theme-inverse">
                        <h2><strong>JournaList</strong> Upload CSV</h2>
                        <!-- <label class="color">Form Class :<strong><em>form-horizontal</em></strong> </label> -->
                    </header>
                    <div class="panel-tools color" align="right" data-toolscolor="#4EA582">
                        <ul class="tooltip-area">
                            <li><a href="javascript:void(0)" class="btn btn-collapse" title="Collapse"><i class="fa fa-sort-amount-asc"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-reload" title="Reload"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="javascript:void(0)" class="btn btn-close" title="Close"><i class="fa fa-times"></i></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">

                        <!-- <form action="csv" method="POST" enctype=" multipart/form-data" class="form-horizontal" > -->
                        {!! Form::open(array('URL::route'=>'csv','files'=>true,'class'=>'register-form')) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token()}}">

                        <div class="form-group">
                            <label class="control-label" for="exampleInputFile">File input</label>
                            <div>
                                {!! Form::file('frontimage') !!}
                                <p class="help-block">some help text here.</p>
                            </div>
                        </div>
                        <div class="form-group offset">
                            <div>
                                <!-- <button type="submit" class="btn btn-theme">Submit</button> -->
                                <input type="submit" name="sd" value="Submit" class="btn btn-theme">
                                <button type="reset" class="btn">Cancel</button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </section>

            </div>
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <h2><strong>Journalist</strong>  </h2>
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
                                <p class="text-right">
                                <button type="button" class="btn btn-primary delete_selected_btn">Delete Selected</button>
                                </p>
                                <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Email address</th>
                                            <th>Domain name</th>
                                            <th>Organization</th>
                                            <th>Type</th>
                                            <th>Keywords</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>
                                                Action
                                            </th>
                                            <th>Position</th>
                                            <th>Twitter handle</th>
                                            <th>LinkedIn URL</th>
                                            <th>Phone number</th>
                                            <th>Sources</th>
                                            <th>Confidence score</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($data as $d)
                                        <tr class="row_del_id_{{$d->id}}">
                                            <td>{{$d->email_address}}</td>
                                            <td>{{$d->Domain_name}}</td>
                                            <td>{{$d->Organization}}</td>
                                            <td>{{$d->Type}}</td>
                                            <td></td>
                                            <td>{{$d->First_name}}</td>
                                            <td>{{$d->Last_name}}</td>
                                            <td>
                                                 <input type="checkbox" name="delete_journalist" value="{{$d->id}}" class="select_delete">
                                            </td>
                                            <td>{{$d->Position}}</td>
                                            <td>{{$d->Twitter_handle}}</td>
                                            <td>{{$d->LinkedIn_URL}}</td>
                                            <td>{{$d->Phone_number}}</td>
                                            <td>{{$d->Sources}}</td>
                                            <td>{{$d->Confidence_score}}</td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Email address</th>
                                            <th>Domain name</th>
                                            <th>Organization</th>
                                            <th>Type</th>
                                            <th>Keywords</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th style="text-align: left">
                                                <input type="checkbox" class="all_jornalist_select">
                                                <label>Select All</label>
                                            </th>
                                            <th>Position</th>
                                            <th>Twitter handle</th>
                                            <th>LinkedIn URL</th>
                                            <th>Phone number</th>
                                            <th>Sources</th>
                                            <th>Confidence score</th>
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
    var JournaList_delete = "<?php echo route('JournaList_delete')?>";
</script>
@endsection 
@section('footer_script')