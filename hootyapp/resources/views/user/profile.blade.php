@extends('layouts.appUser')
@section('title', 'Dashboard')
@section('content')
<link href="{{asset('userTheme/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

<link type="text/css" rel="stylesheet" href="{{URL::asset('assets/css/profileImageUpload.css')}}" />
<link rel="stylesheet" href="{{URL::asset('assets/css/croppie.css')}}">
<!--***NEW***-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<main class="main">
    <!--CODE STARTS HERE-->

    <div id="profilePage" class="container col-md-8 offset-md-2">
        <div class="row">
            <div class="col-md pt-3">
                <div class="profileCard">
                    <ul class="nav  nav-tabs">
                        <li class="nav-item ">
                            <a class="nav-link active" data-toggle="tab" href="#profile">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#membership">Membership</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#changePassword">Change Password</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tabWidth tab-content">
                        <div id="profile" class="tab-pane active active-primary">
                            <div>
                                <form action="{{URL::route('update_profile_info')}}" method="post"
                                    enctype="multipart/form-data" id="profile">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                    <input id="image" name="image" type="hidden"> @if (empty($profile->image))
                                    <img class="profile-pic circle rounded-circle d-block mx-auto " data-toggle="modal"
                                        data-target="#imageCropModal" src="{{asset('assets/img/avatars/user.png') }}">
                                    @else
                                    <img class="profile-pic circle rounded-circle d-block mx-auto " data-toggle="modal"
                                        data-target="#imageCropModal" src="{{$profile->image}}">
                                    @endif
                                    <div class="p-image">
                                        <input class="file-upload" type="file" name="image" accept="image/*" />
                                    </div>
                                    <figcaption class="figure-caption text-center">Profile Picture</figcaption>
                            </div>

                            <div class="col-xs-4 my-3">
                                <label><strong>First name</strong></label>
                                <input type="text" class="form-control mb-2" name="first_name"
                                    value="{{$profile->first_name}}">
                                <label><strong>Last name</strong></label>
                                <input type="text" class="form-control mb-2" name="last_name"
                                    value="{{$profile->last_name}}">
                                <label><strong>Email</strong></label>
                                <input type="email" class="form-control mb-2" name="email" value="{{$profile->email}}"
                                    disabled>
                                <label><strong>Company name</strong></label>
                                <input type="text" class="form-control mb-2" name="company_name"
                                    value="{{$profile->company_name}}">
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn  px-5 btn-primary">Update And Save</button>
                            </div>
                            </form>


                        </div>
                        <div id="membership" class=" tab-pane fade">
                            <br>
                            <div class="row mb-2">
                                <div class="col-md">
                                    <h5 class="text-muted">Current Plan</h5>
                                    <h4>Hooty lite</h4>
                                    @if ($last_paln == 3)
                                    Plan : Monthly
                                    @else
                                    Plan : Yearly
                                    @endif
                                </div>
                                <div class="col-md">
                                    <h5 class="text-muted">
                                        @if ($current_status == -1)
                                        Cancels at
                                        @else
                                        Next billing date
                                        @endif

                                    </h5>
                                    <h4>{{$next_billing}}</h4>

                                </div>
                            </div>
                            <button type="button" data-toggle="modal" data-target="#upgradeModal"
                                class="btn btn-primary">Upgrade</button>
                            <button type="button" class="btn btn-secondary" id="planCancel">Cancel</button>
                            <button type="button" class="btn btn-secondary d-none" id="planResume">Resume</button>


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
                                            </div>
                                            <div class="card-deck mb-3 text-center">
                                                <div class="card mb-4 shadow-sm">
                                                    <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Hooty Lite</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">$125 <small
                                                                class="text-muted">/ month</small></h1>
                                                        <ul class=" text-center list-unstyled mt-3 mb-4">
                                                            <li class="py-4"><span
                                                                    class="fa fa-check mr-1"></span>Journalist Database
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Pitch Builder</li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Video pitch builder
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Article database
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Newsjacking alerts
                                                            </li>
                                                        </ul>
                                                        <button type="button" id="lite_montly" data-plan="3"
                                                            class="lite_plan btn btn-lg btn-block btn-outline-primary">GET
                                                            STARTED <span class="d-none d-xl-inline">30-DAY FREE
                                                                TRIAL</span></button>
                                                    </div>
                                                </div>
                                                <div class="card mb-4 shadow-sm">
                                                    <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Hooty Lite</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <h1 class="card-title pricing-card-title">$250 <small
                                                                class="text-muted">/ year</small></h1>
                                                        <ul class="text-center list-unstyled mt-3 mb-4">
                                                            <li class="py-4"><span
                                                                    class="fa fa-check mr-1"></span>Journalist Database
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Pitch Builder</li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Video pitch builder
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Article database
                                                            </li>
                                                            <li class="py-4"><span
                                                                    class="fa fa-check  mr-1"></span>Newsjacking alerts
                                                            </li>
                                                        </ul>

                                                        <button type="button" id="lite_yearly" data-plan="4"
                                                            class="lite_plan btn btn-lg btn-block btn-primary">GET
                                                            STARTED <span class="d-none d-xl-inline">30-DAY FREE
                                                                TRIAL</span></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="changePassword" class="tab-pane fade">
                            <form action="{{URL::route('update_profile_pass')}}" method="post">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <label><strong>New password</strong></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-lock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="password" name="password"
                                            placeholder="New Password">
                                    </div>
                                    <label><strong>Repeat password</strong></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="icon-lock"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            placeholder="Repeat New Password">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal" id="imageCropModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">


                <button class="close" data-dismiss="modal">×</button>


                <div class="row my-3 ">
                    <div class="col-md  text-center ml-5">
                        <div id="upload-demo" style="width:350px"></div>
                    </div>
                    <div class="col-md  mt-5">
                        <strong>Select Image:</strong>
                        <br />

                        <input name="image" type="file" id="upload">
                        <br />
                    </div>


                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-primary upload-result">Upload Image</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel"
    aria-hidden="true">
    <form action="{{URL::route('update_profile_pass')}}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                            <i class="icon-lock"></i>
                          </span>
                        </div>
                        <input class="form-control" type="password" placeholder="Password">
                    </div> -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" name="password" placeholder="New Password">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" name="password_confirmation"
                            placeholder="Repeat New Password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
    {{$current_status}}
</div>


<script type="text/javascript">
    var currentPlanId = <?php echo $last_paln ?>;
 var current_status = <?php echo $current_status?>
</script>
<script src="{{asset('assets/js/sweet_alert.js') }}"></script>
<script src="{{asset('assets/js/profile.js') }}"></script>
<script src="{{asset('assets/js/croppie.js') }}"></script>
<!--***NEW***-->
@endsection