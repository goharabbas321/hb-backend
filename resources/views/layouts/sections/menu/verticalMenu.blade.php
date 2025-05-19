@php
    use Illuminate\Support\Facades\Route;
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    @if (!isset($navbarFull))
        <div class="app-brand demo">
            <a href="{{ url('/') }}" class="app-brand-link">
                <span class="app-brand-logo demo"><img src="{{ asset('/storage/' . $systemSettings['logo_light']) }}"
                        alt="Logo" style="width:36px; height: 52px;"></span>
                @if (getSetting('arabic_name'))
                    @if ($current_language == 'ar')
                        <span class="app-brand-text demo menu-text fw-bold">{{ $systemSettings['name_ar'] }}</span>
                    @else
                        <span class="app-brand-text demo menu-text fw-bold">{{ $systemSettings['name'] }}</span>
                    @endif
                @else
                    <span class="app-brand-text demo menu-text fw-bold">{{ $systemSettings['name'] }}</span>
                @endif
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                <i class="align-middle ti menu-toggle-icon d-none d-xl-block"></i>
                <i class="align-middle ti ti-x d-block d-xl-none ti-md"></i>
            </a>
        </div>
    @endif

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">
        @foreach (collect($menuData[0]['menu'])->map(fn($item) => (object) $item) as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                @if (isset($menu->menuHeaderPermission))
                    @can($menu->menuHeaderPermission)
                        <li class="menu-header small">
                            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                        </li>
                    @endcan
                @else
                    <li class="menu-header small">
                        <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
                    </li>
                @endif
            @else
                {{-- main menu --}}
                @if (checkUserPermission(isset($menu->permission) ? $menu->permission : ''))
                    <li class="menu-item {{ isMenuOpen($menu->slug) }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                            @isset($menu->badge)
                                <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}
                                </div>
                            @endisset
                        </a>

                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endcan
            @endif
        @endforeach
</ul>

</aside>
