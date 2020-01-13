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
                    <a href="javascript: void(0);" class="btn btn-primary ml-2" data-toggle="modal"
                        data-target="#create_user">+ Add User</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#menu_1">User Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu_2">Change Image</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu_3">Change Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu_4">My Plans</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content tab_body">
                        <div id="menu_1" class="container tab-pane active">
                            <br>
                            <form action="{{URL::route('update_profile_info')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">First name :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" name="first_name"
                                            value="{{$profile->first_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">Last name :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" name="last_name"
                                            value="{{$profile->last_name}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">Email :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="email" name="email"
                                            value="{{$profile->email}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label form-control-label">Company Name :</label>
                                    <div class="col-lg-10">
                                        <input class="form-control" type="text" name="company_name"
                                            value="{{$profile->company_name}}">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                        <div id="menu_2" class="container tab-pane">
                            <br>
                            <form action="{{URL::route('update_profile_image')}}" method="post"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label form-control-label">Image :</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" type="file" name="image"
                                            value="{{$profile->first_name}}">
                                    </div>
                                    <div class="col-md-4">
                                        @if(empty($profile->image))
                                        <h3>Image Not Exist</h3>
                                        @else
                                        <a href="{{route('delete_profile_image')}}" class="btn btn-danger">X Remove
                                            Image</a>
                                        <img src="{{$profile->image }}" alt="user-image" width="100%">

                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                        </div>
                        <div id="menu_3" class="container tab-pane fade"><br>
                            <form action="{{URL::route('update_profile_pass')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Enter Password" required="">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Confome Password:</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confome Enter Password" required="">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                        <div id="menu_4" class="container tab-pane fade"><br>
                            <div class="table-responsive-sm">
                                <table class="table table-sm table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Plan</th>
                                            <th>Price</th>
                                            <th>Expire Last Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($last_paln))
                                        <tr>
                                            <td>{{$last_paln->plan_name}}</td>
                                            <td>{{$last_paln->pay}}</td>
                                            <td><span class="badge badge-primary">{{$last_paln->expiry_date}}</span>
                                            </td>

                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-center">No Plans Selected</td>
                                        </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    @endsection
    @section('footer_script')
    @endsection