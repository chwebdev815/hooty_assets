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
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
                <h4 class="page-title">User</h4>
                <div class="text-right">
                    <a href="javascript: void(0);" class="btn btn-primary ml-2" data-toggle="modal" data-target="#create_user">+ Add User</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data['users']))
                            @foreach($data['users'] as $value)
                            <tr>
                                <td>{{$value->first_name}}</td>
                                <td>{{$value->last_name}}</td>
                                <td>{{$value->email}}</td>
                                <td>
                                    <a href="{{URL::route('user_profile_index',$value->id)}}">
                                        <button type="button" class="btn btn-primary">Show</button>
                                    </a>
                                    <a href="#" class="remove-record" data-toggle="modal" data-url="{!! URL::route('sub_user.destroy', $value->id) !!}" data-id="{{$value->id}}" data-target="#custom-width-modal">
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Add Modal -->
                    <div class="modal" id="create_user">
                        <div class="modal-dialog">
                          <div class="modal-content">
                          
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Create User</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                            <!-- Modal body -->
                            <form action="{{URL::route('sub_user.store')}}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                      <label for="first_name">First Name:</label>
                                      <input type="text" class="form-control" id="first_name" placeholder="Enter First Name" name="first_name">
                                    </div>
                                    <div class="form-group">
                                      <label for="last_name">Last Name:</label>
                                      <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name">
                                    </div>
                                    <div class="form-group">
                                      <label for="email">Email:</label>
                                      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                    </div>
                                    <div class="form-group">
                                      <label for="pwd">Password:</label>
                                      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
                                    </div>
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    <!-- End Model -->
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
