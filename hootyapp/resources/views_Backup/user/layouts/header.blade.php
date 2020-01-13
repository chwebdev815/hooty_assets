<div class="navbar-custom">
    <ul class="list-unstyled topbar-right-menu float-right mb-0">

        <!-- <li class="dropdown notification-list">
            <a href="javascript:void(0);" class="nav-link right-bar-toggle mr-0">
                <i class="mdi mdi-settings noti-icon"></i>
            </a>
        </li> -->


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                @if(empty(auth()->guard('web')->user()->image))
                <img src="{{asset('user.png') }}" alt="user-image" class="rounded">
                @else
                <img src="{{auth()->guard('web')->user()->image }}" alt="user-image" class="rounded">
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                <!-- item-->
                <a href="{{URL::route('profile_index')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle"></i>
                    <span>My Account</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-logout"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </li>

    </ul>
    <div class="app-search">
        <form>
            <div class="input-group">
                <div class="input-group-append menu_icon">
                    <i class="dripicons-menu"></i>
                </div>
            </div>
        </form>
    </div>
    <button class="button-menu-mobile open-left disable-btn">
        <i class="mdi mdi-menu"></i>
    </button>
</div>