@foreach($menus as $menu)
    @if(is_array($menu))
        <li class="nav-item">
            <a href="{{ 
                isset($menu['route'])
                    ? route($menu['route'])
                    : (isset($menu['url']) ? '#' . $menu['url'] : '#')
                }}" class="nav-link d-flex {{ isset($menu['sub_menu']) ? 'sub-menu-parent' : '' }}"
                {{isset($menu['url']) ? "data-toggle=collapse role=button aria-expanded=false aria-controls=" . $menu['url'] : '' }}>
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
                @if(isset($menu['sub_menu']))
                    <label for="check" class="ml-auto sub-menu-button">
                        <i class="fas fa-angle-down"></i>
                    </label>
                @endif
            </a>
            @if(isset($menu['sub_menu']))
            <ul class="collapse" id="{{ isset($menu['url']) ? $menu['url'] : '' }}">
                @foreach($menu['sub_menu'] as $sub_menu)
                    <li class="nav-item">
                        <a href="{{ 
                            isset($sub_menu['route'])
                                ? route($sub_menu['route'])
                                : (isset($sub_menu['url']) ? $sub_menu['url'] : '#')
                            }}" class="nav-link">
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
            @endif
        </li>
    @else
        <li class="nav-header">{{ strtoupper($menu) }}</li>
    @endif
@endforeach