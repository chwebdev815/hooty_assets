<div class="container py-4 fixed-top app-navbar">
  <nav class="navbar navbar-transparent navbar-padded navbar-expand-md">
    <a class="navbar-brand mr-auto" href="{{URL::route('index')}}">
      <strong style="background: #fff; padding: 12px; border-radius: 4px; color: #28669F;">Hooty</strong>
    </a>
    <!-- <button
      class="navbar-toggler"
      type="button"
      data-target="#stage"
      data-toggle="stage"
      data-distance="-250">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <div class="d-none d-md-block text-uppercase">
      <ul class="navbar-nav">
        <li class="nav-item px-1 ">
          <a class="nav-link" href="{{URL::route('index')}}">HOME</a>
        </li>
        @guest
          <li class="nav-item px-1 ">
            <a class="nav-link" href="{{URL::route('login')}}">LOGIN</a>
          </li>
        @else
          <li class="nav-item px-1 ">
            <a class="nav-link" href="{{URL::route('login')}}">GOTO-BACKEND</a>
          </li>
          <li class="nav-item px-1 ">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i></a></a>
          </li>
        @endif
      </ul>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </nav>
</div>