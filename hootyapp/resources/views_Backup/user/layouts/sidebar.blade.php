<div class="left-side-menu">
    <div class="slimscroll-menu fxo-widget">

        <!-- LOGO -->
        <a href="#" class="logo text-left" style="margin-left: 30px;margin-bottom: 20px; ">
            <span class="logo-lg" style="float: right;width: 85%;line-height: 22px;">
                HOOTY
            </span>
            <img src="{{asset('logo_icon.png') }}" width="22px;" style="margin: 0px 9px 0px -1px;" id="Hooty_menu" class="fxo-widget-button-control-inner top_logo">
        </a>
        <a href="#" class="logo text-center">
            <i class="dripicons-menu full_width_menu_icon"></i>
        </a>

        <!--- Sidemenu -->
        <ul class="metismenu side-nav fxo-widget-items">

            <li class="side-nav-item">
                <a href="{{URL::route('home')}}" class="side-nav-link">
                    <i class="dripicons-meter" id="Dashboard_menu"></i>
                    <!-- <span class="badge badge-success float-right">7</span> -->
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{URL::route('contact_index')}}" class="side-nav-link">
                    <i class="dripicons-search" id="Search_memu"></i>
                    <span> Search </span>
                </a>
            </li>
            <li class="side-nav-item fxo-widget-item fxo-widget-item-control fxo-widget-item-control-revealed">
                <a href="#" class="side-nav-link fxo-widget-button fxo-widget-button-control hooty_menu_logo fxo-widget-button fxo-widget-button-control" id="widget-control-btn">
                    <img src="{{asset('logo_icon.png') }}" width="22px;" style="margin: 0px 9px 0px -1px;" id="Hooty_menu" class="fxo-widget-button-control-inner">
                    <!-- <span class="badge badge-success float-right">7</span> -->
                    <span> Hooty </span>
                </a>
            </li>
            @if(auth()->guard('web')->user()->type == 1 && auth()->guard('web')->user()->plan_id == 3)
            <!-- <li class="side-nav-item">
                <a href="{{URL::route('sub_user.index')}}" class="side-nav-link">
                    <i class="dripicons-user"></i>
                    <span> User </span>
                </a>
            </li> -->
            @endif

             <li class="side-nav-item">
                <a href="{{URL::route('message_create')}}" class="side-nav-link">
                    <i class="dripicons-mail" id="Compose_menu"></i>
                    <span> Compose </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{URL::route('message')}}" class="side-nav-link">
                    <i class="dripicons-inbox" id="Inbox_menu"></i>
                    <span> Inbox </span>
                </a>
            </li>   

            <!-- <li class="side-nav-item">
                <a href="{{URL::route('group_index')}}" class="side-nav-link">
                    <i class="dripicons-user"></i>
                    <span> Group </span>
                </a>
            </li> -->
            
        </ul>
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>