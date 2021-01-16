<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown user-menu">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
      <img src="{{ gravatar(Auth::user()->email) }}" class="user-image img-circle bg-white elevation-2" alt="User Image">
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      {{-- User image --}}
      <li class="user-header">
        <img src="{{ gravatar(Auth::user()->email) }}" class="img-circle elevation-2" alt="User Image">

        <p>
          {{ strtolower(Auth::user()->email) }}
          <small>{{ ucfirst(Auth::user()->type) }}</small>
        </p>
      </li>

      {{-- Menu Footer --}}
      <li class="user-footer">
        <a href="#" class="btn btn-default btn-flat">Profile</a>
        <a href="{{ route('logout') }}" class="btn btn-danger btn-flat float-right" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i>
          {{ trans('theme.logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST"
            style="display: none;">
            @csrf
        </form>
      </li>
    </ul>
  </li>
</ul>
