@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{URL::route('index')}}">Frontend</a></li>
                        <li class="breadcrumb-item"><a href="{{URL::route('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
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
                      <br>
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#menu_1">User Info</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu_2">Change Password</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#menu_3">Group</a>
                        </li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content tab_body">
                        <div id="menu_1" class="container tab-pane active">
                            <br>
                            <form action="{{URL::route('update_sub_profile_info')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">First name :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" name="first_name" value="{{$profile->first_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">Last name :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" name="last_name" value="{{$profile->last_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">Email :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="email" name="email" value="{{$profile->email}}">
                                    </div>
                                </div>
                                 <input type="hidden" name="sub_user_id" value="{{$profile->id}}">
                                <button type="submit" class="btn btn-success">Success</button>
                            </form>
                        </div>
                        <div id="menu_2" class="container tab-pane fade"><br>
                            <form action="{{URL::route('update_sub_profile_pass')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required="">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Confome Password:</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confome Enter Password" required="">
                                </div>
                                 <input type="hidden" name="sub_user_id" value="{{$profile->id}}">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div id="menu_3" class="container tab-pane fade"><br>
                            <table id="example" class="table table-striped table-bordered contacts-table table">
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
                                        <td></td>
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
            </div>
        </div>
    </div>
</div>
@endsection 
@section('footer_script')
@endsection 
