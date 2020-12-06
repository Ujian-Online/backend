<ul class="navbar-nav mr-auto">

    @can('isAdmin')
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.share.*') ? 'active' : '' }}" href="{{ route('admin.share.index') }}">Shares</a>
        </li>
        <li class="nav-item dropdown {{ request()->routeIs('admin.googledriveapi.*') ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Google Drive
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item {{ request()->routeIs('admin.googledriveapi.*') ? 'active' : '' }}" href="{{ route('admin.googledriveapi.index') }}">Google Drive API</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item {{ request()->routeIs('admin.googledriveaccount.*') ? 'active' : '' }}" href="{{ route('admin.googledriveaccount.index') }}">Google Drive Account</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">Users</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Settings
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Websites Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Pages Settings</a>
                <a class="dropdown-item" href="#">FAQs Settings</a>
            </div>
        </li> --}}

    @elsecan('isEditor')
        <li class="nav-item">
            <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Shares</a>
        </li>
    @else

        <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
        </li>

    @endcan
</ul>