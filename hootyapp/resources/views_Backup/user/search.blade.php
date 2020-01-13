@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-6 google-search_box">
            <div class="page-title-box text-center">
                <br>
                <!-- <img src="{{asset('logo_icon.png')}}" width="150px;" style="margin: auto;"> -->
                <br>
                <h2>Hooty</h2>
                <div class="app-search">
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search...">
                        <span class="mdi mdi-magnify"></span>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3 text-right"></div>
                        <div class="col-md-3">
                            <button class="btn btn-block btn-primary live_search_outlet" type="button">Outlet</button>
                        </div>
                        <div class="col-md-3 text-left">
                            <button class="btn btn-block btn-primary live_search_keyword" type="button">Keywords</button>
                        </div>
                        <div class="col-md-3 text-right"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row search_deta_box" style="display: none;">
        <div class="col-xl-12">
            
            <div class="card">
                <input type="hidden" value="" id="t_record">
                <input type="hidden" value="" id="no_record">
                <input type="hidden" value="0" id="selected">
                <div class="card-body">
                    <form action="{!! URL::route('group_store') !!}" method="post">
                        {{ csrf_field() }}
                        <table   class="table table-striped dt-responsive nowrap table-fixed-header">
                        <thead id="myHeader">
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <div class="custom-control custom-checkbox" style="min-height: 1rem;">
                                            <input type="checkbox" class="custom-control-input" id="allselect">
                                            <label class="custom-control-label select_box_margin" for="allselect"></label>
                                            Select All
                                        </div>
                                    </button>
                                </th>
                                <th colspan="2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm count_btn">
                                        
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm count_selected_btn">
                                        <sam class="total_record">0</sam> - <sam class="view_record">Record Selected</sam>
                                    </button>
                                </th>
                                <th colspan="1" class="myth">
                                    <div class="text-right ">
                                        <a href="javascript: void(0);" class="btn btn-primary ml-2" data-toggle="modal" data-target="#addGroup">+ Add List</a>
                                    </div>
                                </th>
                            </tr>
                            <tr class="select_all_record_label">
                                <th colspan="1"></th>
                                <th colspan="2">
                                    <button type="button" class="btn btn-outline-primary btn-rounded all_row_seleced">
                                        
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-rounded all_row_remove_seleced live_search">
                                        
                                    </button>
                                </th>

                            </tr>
                            <tr>
                                <th width="15%">Select</th>
                                <th width="30%">Name</th>
                                <th width="20%">Outlet</th>
                                <th>Keywords</th>
                            </tr>
                        </thead>
                        <tbody class="list_data" id="list_data">

                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal" id="addGroup" style="z-index: 999999;">
                        <div class="modal-dialog" style="box-shadow: 2px 5px 20px 7px;">
                          <div class="modal-content">
                          
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Create List</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            <div class="modal-body input-group">
                                <input list="browsers" name="name" class="group_name_box form-control" placeholder="Select....">
                                    <datalist id="browsers">
                                    @if(!empty($data['group']))
                                        @foreach($data['group'] as $value)
                                            <option value="{{$value->name}}" style="background: red">
                                        @endforeach
                                    @endif
                                </datalist>
                                <input type="submit" value="Submit" class="btn btn-primary ml-2" style="margin-left: 0px !important;">
                            </div>
                            
                            <!-- Modal footer -->
                            <div class="modal-footer">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    <!-- End Model -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('footer_script')
<script type="text/javascript">
    var url = "<?php echo route('contact_index')?>";

    $(document).keypress(function(e) {
        if(e.which == 13) {
            var page = 1;
            
        }
    });
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
<script src="{{asset('userTheme/assets/js/search.js') }}"></script>
@endsection
