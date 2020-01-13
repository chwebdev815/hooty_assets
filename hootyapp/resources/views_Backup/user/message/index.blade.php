@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index')}}">Frontend</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Message List</li>
                    </ol>
                </div>
                <h4 class="page-title">Message List</h4>
                <div class="text-right">
                    <a href="{{URL::route('message_create')}}" class="btn btn-primary ml-2">+ Message Create</a>
                    </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table_responsive">
                    <table id="datatable-buttons" class="table  nowrap dataTable no-footer dtr-inline">
                        <thead>
                            <tr>
                                <th width="20%">#</th>
                                <th width="10%">Title</th>
                                <th width="20%">Date</th>
                                <th width="30%">Action</th>
                                <th>Text Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($messages))
                            @foreach($messages as $key=>$value)
                            <tr @if($value->chat_status != 0) class="undread"  @endif>

                                <td>
                                    {!! $key +1 !!}
                                </td>
                                <td>{!! $value->title !!}</td>
                                <td>{!! date_format($value->created_at, 'F j, Y') !!}</td>
                                <td>
                                    <a href="{{URL::route('message_show',$value->id)}}">
                                        <button type="button" class="btn btn-primary">Show</button>
                                    </a>
                                    <!-- a href="#" class="remove-record" data-toggle="modal" data-url="{!! URL::route('sub_user.destroy', $value->id) !!}" data-id="{{$value->id}}" data-target="#custom-width-modal">
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </a> -->
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
                                <th>Action</th>
                                <th>Text Message</th>
                            </tr>
                        </tfoot>
                    </table>
                    @include('user.layouts.deleteRecord')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('footer_script')
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
<script type="text/javascript">
$(document).ready(function(){
    // For A Delete Record Popup
    $('.remove-record').click(function() {
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');

        $('#custom-width-modal').find(".remove-record-model").attr("action",url);
        $('#custom-width-modal').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
        $('#custom-width-modal').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
    });
});

</script>
@endsection 
