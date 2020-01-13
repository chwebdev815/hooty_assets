<div id="wrapper">
    <div id="header">
        <div class="tools-bar">
            <ul class="nav navbar-nav nav-main-xs">
                <li><a href="#menu" class="icon-toolsbar"><i class="fa fa-bars"></i></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right tooltip-area">

                <li><a href="#menu-right" data-toggle="tooltip" title="Right Menu" data-container="body" data-placement="left"><i class="fa fa-align-right"></i></a></li>

                <li class="hidden-xs hidden-sm"><a href="#" class="h-seperate">Help</a></li>

                <li><button class="btn btn-circle btn-header-search" ><i class="fa fa-search"></i></button></li>

                <li>
                    <a href="#" class="nav-collapse avatar-header" data-toggle="tooltip" title="Show / hide  menu" data-container="body" data-placement="bottom">
                        <img alt="" src="{{asset('user.png')}}"  class="circle">
                        <span class="badge">3</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                        <em><strong>Hi</strong>, Admin </em> <i class="dropdown-icon fa fa-angle-down"></i>

                    </a>
                    <ul class="dropdown-menu pull-right icon-right arrow">
                        <!-- <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Setting </a></li>
                        <li><a href="#"><i class="fa fa-bookmark"></i> Bookmarks</a></li>
                        <li><a href="#"><i class="fa fa-money"></i> Make a Deposit</a></li>
                        <li class="divider"></li> -->
                        <li><a href="{{URL::route('admin_logout')}}"><i class="fa fa-sign-out"></i> Signout </a></li>
                    </ul>
                </li>

                <li class="visible-lg">
                    <a href="#" class="h-seperate fullscreen" data-toggle="tooltip" title="Full Screen" data-container="body"  data-placement="left">
                        <i class="fa fa-expand"></i>
                    </a>
                </li>
            </ul>
        </div>

    <!-- //tools-bar-->     
    </div>

    <!-- //header-->
    <div class="widget-top-search">
        <span class="icon"><a href="#" class="close-header-search"><i class="fa fa-times"></i></a></span>
        <form id="top-search">
            <h2><strong>Quick</strong> Search</h2>
            <div class="input-group">
                <input  type="text" name="q" placeholder="Find something..." class="form-control" />
                <span class="input-group-btn">
                <button class="btn" type="button" title="With Sound"><i class="fa fa-microphone"></i></button>
                <button class="btn" type="button" title="Visual Keyboard"><i class="fa fa-keyboard-o"></i></button>
                <button class="btn" type="button" title="Advance Search"><i class="fa fa-th"></i></button>
                </span>
            </div>
        </form>
    </div>
    <!-- //widget-top-search-->

        