@foreach($menus as $menu)
    @if(is_array($menu))
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
    @else
        <li class="nav-header">{{ strtoupper($menu) }}</li>
    @endif
@endforeach
