<nav class="mt-2">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ Auth::user()->media_url ?? gravatar(Auth::user()->email) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ ucfirst(explode("@", Auth::user()->email)[0]) }}</a>
            @if(Auth::user()->can("isTuk"))
                <a href="#" class="d-block" style="white-space: normal; word-wrap: break-word;">TUK: {{ ucwords(Auth::user()->tuk->tuk->title) }}</a>
            @else
                <a href="#" class="d-block" style="white-space: normal; word-wrap: break-word;">{{ strtoupper(Auth::user()->type) }}</a>
            @endif
        </div>
    </div>


    <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">

    {{-- Menu For Admin Access --}}
     @can('isAdmin')

        @include(
            'layouts.adminlte.sidebar-child', [
                "menus" => config('adminlte.menu_sidebar.admin')
            ]
        )

    {{-- Menu For TUK Access --}}
     @elsecan('isTuk')

            @include(
               'layouts.adminlte.sidebar-child', [
                   "menus" => config('adminlte.menu_sidebar.tuk')
               ]
           )

    {{-- Menu For Assesor Access --}}
     @elsecan('isAssesor')

            @include(
               'layouts.adminlte.sidebar-child', [
                   "menus" => config('adminlte.menu_sidebar.asesor')
               ]
            )

     @endcan


        {{-- Log Out Button in Sidebar --}}
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>{{ trans('theme.logout') }}</p>
            </a>
        </li>
    </ul>
</nav>
