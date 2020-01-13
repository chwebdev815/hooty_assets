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
                        <li class="breadcrumb-item active">Groups Member</li>
                    </ol>
                </div>
                <h4 class="page-title">Groups Member</h4>
                <div class="text-right">
                    <a href="" class="btn btn-primary ml-2">+ Add Group</a>
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
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data['groups_member']))
                            @foreach($data['groups_member'] as $d)
                            <tr>
                                <td>{{$d->id}}</td>
                                <td>{{$d->First_name}}</td>
                                <td>{{$d->Last_name}}</td>
                                <td>
                                    <a href="{{URL::route('member_delete',$d->id)}}"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </form>
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
@endsection 
