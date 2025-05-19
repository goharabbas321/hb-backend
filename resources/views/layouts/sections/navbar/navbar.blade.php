@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    $containerNav = $configData['contentLayout'] === 'compact' ? 'container-xxl' : 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="py-0 navbar-brand app-brand demo d-none d-xl-flex me-4">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
            <span class="app-brand-text demo menu-text fw-bold">{{ $systemSettings['name'] }}</span>
        </a>
        @if (isset($menuHorizontal))
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i class="align-middle ti ti-x ti-md"></i>
            </a>
        @endif
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="px-0 nav-item nav-link me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-md"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    @if (!isset($menuHorizontal))
        <!-- Search -->
        <!--<div class="navbar-nav align-items-center">
            <div class="mb-0 nav-item navbar-search-wrapper">
                <a class="px-0 nav-item nav-link search-toggler d-flex align-items-center" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
                    <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
                </a>
            </div>
        </div> -->
        <!-- /Search -->
    @endif

    <ul class="flex-row navbar-nav align-items-center ms-auto">
        @if (isset($menuHorizontal))
            <!-- Search -->
            <!--<li class="nav-item navbar-search-wrapper">
                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill search-toggler"
                    href="javascript:void(0);">
                    <i class="ti ti-search ti-md"></i>
                </a>
            </li> -->
            <!-- /Search -->
        @endif

        <!-- Clear Cache -->
        <li class="nav-item">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                href="{{ route('clear.cache') }}">
                <i class='ti ti-eraser rounded-circle ti-md'></i>
            </a>
        </li>
        <!--/ Clear Cache -->

        <!-- Language -->
        <li class="nav-item dropdown-language dropdown">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class='ti ti-language rounded-circle ti-md'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach ($languages as $language)
                    <li>
                        <a class="dropdown-item {{ app()->getLocale() === $language->code ? 'active' : '' }}"
                            href="{{ url('lang/' . $language->code) }}" data-language="{{ $language->code }}"
                            data-text-direction="{{ $language->is_rtl ? 'rtl' : 'ltr' }}">
                            <span>{{ __($language->name) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <!--/ Language -->

        @if ($configData['hasCustomizer'] == true)
            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-3 me-xl-2">
                <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='ti ti-md'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i
                                    class='ti ti-sun ti-md me-3'></i>{{ __('messages.theme.light') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i
                                    class="ti ti-moon-stars ti-md me-3"></i>{{ __('messages.theme.dark') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                            <span class="align-middle"><i
                                    class="ti ti-device-desktop-analytics ti-md me-3"></i>{{ __('messages.theme.system') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher -->
        @endif

        <!-- Quick links  -->
        <!--<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <i class='ti ti-layout-grid-add ti-md'></i>
            </a>
            <div class="p-0 dropdown-menu dropdown-menu-end">
                <div class="dropdown-menu-header border-bottom">
                    <div class="py-3 dropdown-header d-flex align-items-center">
                        <h6 class="mb-0 me-auto">Shortcuts</h6>
                        <a href="javascript:void(0)"
                            class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
                                class="ti ti-plus text-heading"></i></a>
                    </div>
                </div>
                <div class="dropdown-shortcuts-list scrollable-container">
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-calendar ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('app/calendar') }}" class="stretched-link">Calendar</a>
                            <small>Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-file-dollar ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('app/invoice/list') }}" class="stretched-link">Invoice App</a>
                            <small>Manage Accounts</small>
                        </div>
                    </div>
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-user ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('app/user/list') }}" class="stretched-link">User App</a>
                            <small>Manage Users</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-users ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('app/access-roles') }}" class="stretched-link">Role Management</a>
                            <small>Permission</small>
                        </div>
                    </div>
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-device-desktop-analytics ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('/') }}" class="stretched-link">Dashboard</a>
                            <small>User Dashboard</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-settings ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('pages/account-settings-account') }}" class="stretched-link">Setting</a>
                            <small>Account Settings</small>
                        </div>
                    </div>
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-help ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('pages/faq') }}" class="stretched-link">FAQs</a>
                            <small>FAQs & Articles</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-3 dropdown-shortcuts-icon rounded-circle">
                                <i class="ti ti-square ti-26px text-heading"></i>
                            </span>
                            <a href="{{ url('modal-examples') }}" class="stretched-link">Modals</a>
                            <small>Useful Popups</small>
                        </div>
                    </div>
                </div>
            </div>
        </li> -->
        <!-- Quick links -->

        <!-- Notification -->
        <!-- <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow"
                href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                aria-expanded="false">
                <span class="position-relative">
                    <i class="ti ti-bell ti-md"></i>
                    <span class="border badge rounded-pill bg-danger badge-dot badge-notifications"></span>
                </span>
            </a>
            <ul class="p-0 dropdown-menu dropdown-menu-end">
                <li class="dropdown-menu-header border-bottom">
                    <div class="py-3 dropdown-header d-flex align-items-center">
                        <h6 class="mb-0 me-auto">Notification</h6>
                        <div class="mb-0 d-flex align-items-center h6">
                            <span class="badge bg-label-primary me-2">8 New</span>
                            <a href="javascript:void(0)"
                                class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                    class="ti ti-mail-opened text-heading"></i></a>
                        </div>
                    </div>
                </li>
                <li class="dropdown-notifications-list scrollable-container">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt
                                            class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Congratulation Lettie 🎉</h6>
                                    <small class="mb-1 d-block text-body">Won the monthly best seller gold
                                        badge</small>
                                    <small class="text-muted">1h ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Charles Franklin</h6>
                                    <small class="mb-1 d-block text-body">Accepted your connection</small>
                                    <small class="text-muted">12hr ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt
                                            class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">New Message ✉️</h6>
                                    <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                                    <small class="text-muted">1h ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-success"><i
                                                class="ti ti-shopping-cart"></i></span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Whoo! You have new order 🛒 </h6>
                                    <small class="mb-1 d-block text-body">ACME Inc. made new order $1,154</small>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/avatars/9.png') }}" alt
                                            class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Application has been approved 🚀 </h6>
                                    <small class="mb-1 d-block text-body">Your ABC project application has been
                                        approved.</small>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-success"><i
                                                class="ti ti-chart-pie"></i></span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Monthly report is generated</h6>
                                    <small class="mb-1 d-block text-body">July monthly financial report is generated
                                    </small>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/avatars/5.png') }}" alt
                                            class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">Send connection request</h6>
                                    <small class="mb-1 d-block text-body">Peter sent you connection request</small>
                                    <small class="text-muted">4 days ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/img/avatars/6.png') }}" alt
                                            class="rounded-circle">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">New message from Jane</h6>
                                    <small class="mb-1 d-block text-body">Your have new message from Jane</small>
                                    <small class="text-muted">5 days ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-warning"><i
                                                class="ti ti-alert-triangle"></i></span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">CPU is running high</h6>
                                    <small class="mb-1 d-block text-body">CPU Utilization Percent is currently at
                                        88.63%,</small>
                                    <small class="text-muted">5 days ago</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                            class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                            class="ti ti-x"></span></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="border-top">
                    <div class="p-4 d-grid">
                        <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                            <small class="align-middle">View all notifications</small>
                        </a>
                    </div>
                </li>
            </ul>
        </li> -->
        <!--/ Notification -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="p-0 nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
                        alt class="rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="mt-0 dropdown-item"
                        href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-2">
                                <div class="avatar avatar-online">
                                    <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
                                        alt class="rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small
                                    class="text-muted">{{ __(Auth::user()->roles->pluck('name')[0] ?? '') }}</small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="my-1 dropdown-divider mx-n2"></div>
                </li>
                @can('read_profile')
                    <li>
                        <a class="dropdown-item"
                            href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}">
                            <i class="ti ti-user me-3 ti-md"></i><span
                                class="align-middle">{{ __('messages.navbar.menu.profile') }}</span>
                        </a>
                    </li>
                @endcan

                @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
                    @can('read_api')
                        <li>
                            <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                                <i class="ti ti-key ti-md me-3"></i><span
                                    class="align-middle">{{ __('messages.navbar.menu.api') }}</span>
                            </a>
                        </li>
                    @endcan
                @endif

                @if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <li>
                        <div class="my-1 dropdown-divider mx-n2"></div>
                    </li>
                    <li>
                        <h6 class="dropdown-header">Manage Team</h6>
                    </li>
                    <li>
                        <div class="my-1 dropdown-divider mx-n2"></div>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
                            <i class="ti ti-settings ti-md me-3"></i><span class="align-middle">Team Settings</span>
                        </a>
                    </li>
                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <li>
                            <a class="dropdown-item" href="{{ route('teams.create') }}">
                                <i class="ti ti-user ti-md me-3"></i><span class="align-middle">Create New Team</span>
                            </a>
                        </li>
                    @endcan

                    @if (Auth::user()->allTeams()->count() > 1)
                        <li>
                            <div class="my-1 dropdown-divider mx-n2"></div>
                        </li>
                        <li>
                            <h6 class="dropdown-header">Switch Teams</h6>
                        </li>
                        <li>
                            <div class="my-1 dropdown-divider mx-n2"></div>
                        </li>
                    @endif

                    @if (Auth::user())
                        @foreach (Auth::user()->allTeams() as $team)
                            {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}

                            {{-- <x-switchable-team :team="$team" /> --}}
                        @endforeach
                    @endif
                @endif
                <li>
                    <div class="my-1 dropdown-divider mx-n2"></div>
                </li>
                @if (Auth::check())
                    <li>
                        <div class="px-2 pt-2 pb-1 d-grid">
                            <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <small class="align-middle">{{ __('messages.navbar.menu.logout') }}</small>
                                <i class="ti ti-logout ms-2 ti-14px"></i>
                            </a>
                        </div>
                    </li>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                @else
                    <li>
                        <div class="px-2 pt-2 pb-1 d-grid">
                            <a class="btn btn-sm btn-danger d-flex"
                                href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
                                <small class="align-middle">Login</small>
                                <i class="ti ti-login ms-2 ti-14px"></i>
                            </a>
                        </div>
                    </li>
                @endif
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

<!-- Search Small Screens -->
<div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
    <input type="text"
        class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0"
        placeholder="Search..." aria-label="Search...">
    <i class="cursor-pointer ti ti-x search-toggler"></i>
</div>
<!--/ Search Small Screens -->
@if (isset($navbarDetached) && $navbarDetached == '')
    </div>
@endif
</nav>
<!-- / Navbar -->
