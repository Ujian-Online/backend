@foreach($menus as $menu)
    @if(is_array($menu) and !isset($menu['sub_menu']))
        <li class="nav-item">
            <a href="{{
                isset($menu['route'])
                    ? route($menu['route'])
                    : (isset($menu['url']) ? $menu['url'] : '#')
                }}" class="nav-link {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                <i class="nav-icon {{ $menu['icon'] ? $menu['icon'] : '' }}"></i>
                <p>
                    {{ $menu['title'] }}

                    @if(
                        isset($menu['badge']) and
                        !empty($menu['badge']) and
                        is_array($menu['badge'])
                    )
                        <span
                            class="{{ $menu['badge']['class'] }}"
                            id="{{ $menu['badge']['id'] }}">
                                {{ $menu['badge']['value'] }}
                        </span>
                    @endif
                </p>
            </a>
        </li>
    @elseif(is_array($menu) and isset($menu['sub_menu']))
        <li class="nav-item has-treeview {{ request()->routeIs($menu['active']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs($menu['active']) ? 'active' : '' }}">
                <i class="nav-icon {{ $menu['icon'] ? $menu['icon'] : '' }}"></i>
                <p>
                    {{ $menu['title'] }}
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                @foreach($menu['sub_menu'] as $sub_menu)
                    <li class="nav-item">
                        <a href="{{
                            isset($sub_menu['route'])
                                ? route($sub_menu['route'])
                                : (isset($sub_menu['url']) ? $sub_menu['url'] : '#')
                            }}" class="nav-link {{ request()->routeIs($sub_menu['active']) ? 'active' : '' }}">
                            <i class="nav-icon {{ $sub_menu['icon'] ? $sub_menu['icon'] : '' }}"></i>
                            <p>
                                {{ $sub_menu['title'] }}

                                @if(
                                    isset($sub_menu['badge']) and
                                    !empty($sub_menu['badge']) and
                                    is_array($sub_menu['badge'])
                                )
                                    <span
                                        class="{{ $sub_menu['badge']['class'] }}"
                                        id="{{ $sub_menu['badge']['id'] }}">
                                        {{ $sub_menu['badge']['value'] }}
                                    </span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        <li class="nav-header">{{ strtoupper($menu) }}</li>
    @endif
@endforeach
