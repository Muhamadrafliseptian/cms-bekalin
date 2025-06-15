@php
    $menus = [
        [
            'header' => 'Pages',
            'items' => [
                [
                    'title' => 'Home',
                    'icon' => 'fas fa-home',
                    'prefix' => 'home.*',
                    'children' => [
                        ['title' => 'Banner', 'route' => 'home.banner.index'],
                        ['title' => 'Diskon', 'route' => 'home.diskon.index'],
                        ['title' => 'Promo', 'route' => 'home.promo.index'],
                        ['title' => 'Batch Menu', 'route' => 'home.batch-menu.index'],
                        ['title' => 'Benefit', 'route' => 'home.benefit.index'],
                        ['title' => 'Why Us', 'route' => 'home.why-us.index'],
                        ['title' => 'What`s Inside', 'route' => 'home.whats-inside.index'],
                        ['title' => 'Testimoni', 'route' => 'home.testimoni.index'],
                    ],
                ],
                [
                    'title' => 'FAQ',
                    'icon' => 'fas fa-comments',
                    'prefix' => 'faq.*',
                    'children' => [['title' => 'Faq', 'route' => 'faq.index']],
                ],
            ],
        ],
        [
            'header' => 'Master',
            'items' => [
                [
                    'title' => 'Batch',
                    'icon' => 'fas fa-table',
                    'prefix' => 'master.*',
                    'children' => [['title' => 'Batch Data', 'route' => 'master.batch.index']],
                ],
            ],
        ],
        [
            'header' => 'Settings',
            'items' => [
                [
                    'title' => 'Administrator',
                    'icon' => 'far fa-user',
                    'prefix' => 'profile.*',
                    'children' => [['title' => 'Data Administrator', 'route' => 'profile.administrator.index']],
                ],
            ],
        ],
    ];
@endphp

<div class="main-sidebar sidebar-style-2">
    <div class="ml-3 mt-3 d-flex align-items-center"></div>

    <aside id="sidebar-wrapper">
        <ul class="sidebar-menu">
            @foreach ($menus as $section)
                <li class="menu-header">{{ $section['header'] }}</li>
                @foreach ($section['items'] as $item)
                    @php
                        $isActive = isset($item['prefix']) && request()->routeIs($item['prefix']);
                    @endphp
                    <li class="dropdown {{ $isActive ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="{{ $item['icon'] }}"></i> <span>{{ $item['title'] }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($item['children'] as $child)
                                @php
                                    $isRoute = isset($child['route']);
                                    $isChildActive = $isRoute && request()->routeIs($child['route']);
                                @endphp
                                <li class="{{ $isChildActive ? 'active' : '' }}">
                                    <a class="nav-link"
                                        href="{{ $isRoute ? route($child['route']) : url($child['url']) }}">
                                        {{ $child['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </aside>
</div>
