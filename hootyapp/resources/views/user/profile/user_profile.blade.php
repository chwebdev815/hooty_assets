@extends('layouts.appUser') @section('title', 'Dashboard')
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
<main class="main">
    <!--CODE STARTS HERE-->
    <div id="profilePage" class="container col-md-8 offset-md-2">
        <div class="row">
            <div class="col-md pt-3">
                <div class="profileCard">
                    <div class=" float-right">
                        <button class="btn passBtn btn-primary" data-toggle="modal"
                            data-target="#changePasswordModal"><i class="fa fa-lock d-md-none"></i> <i
                                class="configIcon fa fa-cog d-md-none"></i> <span class="d-none d-md-block">Change
                                Password</span></button>
                    </div>
                    <ul class="nav  nav-tabs">
                        <li class="nav-item ">
                            <a class="nav-link active" data-toggle="tab" href="#home">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#menu1">Membership</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tabWidth tab-content">
                        <div id="home" class="tab-pane active active-primary">
                            <form action="{{URL::route('update_profile_info')}}" method="post">
                                {{ csrf_field() }}
                                <div>
                                    <img class="rounded-circle d-block mx-auto w-25" src="{{$profile->image}}">
                                    <figcaption class="figure-caption text-center">Profile Picture</figcaption>
                                </div>
                                <div class="col-xs-4 my-3">
                                    <label>First name</label>
                                    <input type="text" class="form-control mb-2" value="{{$profile->first_name}}">
                                    <label>Last name</label>
                                    <input type="text" class="form-control mb-2" value="{{$profile->last_name}}">
                                    <label>Email</label>
                                    <input type="email" class="form-control mb-2" value="{{$profile->email}}">
                                    <label>Company name</label>
                                    <input type="text" class="form-control mb-2" value="{{$profile->company_name}}">
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn  px-5 btn-primary">Update And Save</button>
                                </div>
                            </form>
                        </div>
                        <div id="menu1" class=" tab-pane fade">
                            <br>
                            <div class="row mb-2">
                                <div class="col-md">
                                    <h5 class="text-muted">Current Plan</h5>
                                    <h4>Agency</h4>
                                </div>
                                <div class="col-md">
                                    <h5 class="text-muted">Next Renewal</h5>
                                    <h4>5th September</h4>
                                </div>
                            </div>
                            <button type="button" data-toggle="modal" data-target="#upgradeModal"
                                class="btn btn-primary">Upgrade</button>
                            <button type="button" class="btn btn-secondary " id="planCancel">Cancel</button>

                            <div class="modal" id="upgradeModal" style="display:none;" aria-hidden="true">
                                <div class="modal-dialog-lg">
                                    <div class="modal-content">
                                        <div class="modal-header card-header">
                                            <h5 class="modal-title ">Upgrade</h5>
                                            <button class="close" data-dismiss="modal">×</button>
                                        </div>
                                        <div class="modal-body container">
                                            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                                                <h1 class="display-4">Pricing</h1>
                                                <p class="lead">Quickly build an effective pricing table for your
                                                    potential customers with this Bootstrap example. It's built with
                                                    default Bootstrap components and utilities with little
                                                    customization.</p>
                                            </div>
                                            <div class="card-deck mb-3 text-center">
                                                <div class="card mb-4 shadow-sm">
                                                    <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Free</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">$0s <small
                                                                class="text-muted">/ mo</small></h1>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                            <li>10 users included</li>
                                                            <li>2 GB of storage</li>
                                                            <li>Email support</li>
                                                            <li>Help center access</li>
                                                        </ul>
                                                        <button type="button" data-dismiss="modal"
                                                            class="btn btn-lg btn-block btn-outline-primary">Sign up for
                                                            free</button>
                                                    </div>
                                                </div>
                                                <div class="card mb-4 shadow-sm">
                                                    <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Pro</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">$15 <small
                                                                class="text-muted">/ mo</small></h1>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                            <li>20 users included</li>
                                                            <li>10 GB of storage</li>
                                                            <li>Priority email support</li>
                                                            <li>Help center access</li>
                                                        </ul>
                                                        <button type="button" data-dismiss="modal"
                                                            class="btn btn-lg btn-block btn-primary">Get
                                                            started</button>
                                                    </div>
                                                </div>
                                                <div class="card mb-4 shadow-sm">
                                                    <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Enterprise</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">$29 <small
                                                                class="text-muted">/ mo</small></h1>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                            <li>30 users included</li>
                                                            <li>15 GB of storage</li>
                                                            <li>Phone and email support</li>
                                                            <li>Help center access</li>
                                                        </ul>
                                                        <button type="button" data-dismiss="modal"
                                                            class="btn btn-lg btn-block btn-primary">Contact us</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mt-5">Billing</h4>
                            <div class="tableScroll ">
                                <table id="example" class="display headerNone mt-3" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>NAME</th>
                                            <th>NO.OF RECIPIENTS</th>
                                            <th>DELIVERED</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$150</td>
                                        </tr>
                                        <tr>
                                            <td>23/04/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$120</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$150</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$120</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$120</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$320</td>

                                        </tr>
                                        <tr>
                                            <td>03/05/2018</td>
                                            <td>Agency Plan</td>
                                            <td>$150</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" placeholder="Password">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" placeholder="New Password">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="icon-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" placeholder="Repeat New Password">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/sweet_alert.js') }}"></script>
<script src="{{asset('assets/js/profile.js') }}"></script>
@endsection