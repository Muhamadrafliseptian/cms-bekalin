@php
    $menus = [
        [
            'header' => 'Pages',
            'items' => [
                [
                    'title' => 'Home',
                    'icon' => 'fas fa-home',
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
                    'children' => [['title' => 'Batch Data', 'route' => 'master.batch.index']],
                ],
                [
                    'title' => 'Meta',
                    'icon' => 'fab fa-google',
                    'children' => [['title' => 'Meta Data', 'route' => 'master.meta.index']],
                ],
                [
                    'title' => 'Menu',
                    'icon' => 'fas fa-bars',
                    'children' => [['title' => 'Menu Data', 'route' => 'master.menu.index']],
                ],
            ],
        ],
        [
            'header' => 'Settings',
            'items' => [
                [
                    'title' => 'Administrator',
                    'icon' => 'far fa-user',
                    'children' => [['title' => 'Data Administrator', 'route' => 'profile.administrator.index']],
                ],
            ],
        ],
    ];
@endphp

<div class="main-sidebar sidebar-style-2">
    <div class="ml-3 mt-3 d-flex align-items-center"></div>
    <div class="sidebar-brand">
        <a href="{{ route('dashboard.index') }}">
            <img src="{{ asset('assets/img/bekalin/logo.png') }}" alt="Bekelin Logo" class="img-fluid" width="60"
                height="60">
        </a>
    </div>

    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('dashboard.index') }}">
            <img src="{{ asset('assets/img/bekalin/logo.png') }}" alt="Logo" class="img-fluid" height="60" width="60">
        </a>
    </div>


    <aside id="sidebar-wrapper">
        <ul class="sidebar-menu">
            @foreach ($menus as $section)
                <li class="menu-header">{{ $section['header'] }}</li>

                @foreach ($section['items'] as $item)
                    @php
                        $active = collect($item['children'] ?? [])
                            ->pluck('route')
                            ->filter()
                            ->some(fn($r) => request()->routeIs($r));
                    @endphp

                    <li class="dropdown {{ $active ? 'active' : '' }}">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                            <i class="{{ $item['icon'] ?? 'fas fa-circle' }}"></i>
                            <span>{{ $item['title'] }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($item['children'] ?? [] as $child)
                                @php
                                    $isActiveChild = isset($child['route']) && request()->routeIs($child['route']);
                                    $childLink = isset($child['route'])
                                        ? route($child['route'])
                                        : url($child['url'] ?? '#');
                                @endphp
                                <li class="{{ $isActiveChild ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ $childLink }}">
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
