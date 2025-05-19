@php
    use Illuminate\Support\Facades\Route;
    $currentRouteName = Route::currentRouteName();
    $activeRoutes = ['front-pages-pricing', 'front-pages-payment', 'front-pages-checkout', 'front-pages-help-center'];
    $activeClass = in_array($currentRouteName, $activeRoutes) ? 'active' : '';
@endphp
<!-- Navbar: Start -->
<nav class="py-0 shadow-none layout-navbar">
    <div class="container">
        <div class="px-3 navbar navbar-expand-lg landing-navbar px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="py-0 navbar-brand app-brand demo d-flex py-lg-2 me-4 me-xl-8">
                <!-- Mobile menu toggle: Start-->
                <button class="px-0 border-0 navbar-toggler me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="align-middle ti ti-menu-2 ti-lg text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{ url('/') }}" class="app-brand-link">
                    <span class="app-brand-logo demo"><img src="{{ asset('/storage/' . $systemSettings['logo_dark']) }}"
                            alt="Logo" style="width:36px; height: 52px;"></span>
                    @if (getSetting('arabic_name'))
                        @if ($current_language == 'ar')
                            <span
                                class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ $systemSettings['name_ar'] }}</span>
                        @else
                            <span
                                class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ $systemSettings['name'] }}</span>
                        @endif
                    @else
                        <span
                            class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ $systemSettings['name'] }}</span>
                    @endif
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="top-0 border-0 navbar-toggler text-heading position-absolute end-0 scaleX-n1-rtl"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="ti ti-x ti-lg"></i>
                </button>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" aria-current="page"
                            href="{{ url('front-pages/landing') }}#landingHero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium"
                            href="{{ url('front-pages/landing') }}#landingFeatures">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('front-pages/landing') }}#landingTeam">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('front-pages/landing') }}#landingFAQ">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('front-pages/landing') }}#landingContact">Contact
                            us</a>
                    </li>
                    <li class="nav-item mega-dropdown {{ $activeClass }}">
                        <a href="javascript:void(0);"
                            class="nav-link dropdown-toggle navbar-ex-14-mega-dropdown mega-dropdown fw-medium"
                            aria-expanded="false" data-bs-toggle="mega-dropdown" data-trigger="hover">
                            <span>Pages</span>
                        </a>
                        <div class="p-4 dropdown-menu p-xl-8">
                            <div class="row gy-4">
                                <div class="col-12 col-lg">
                                    <div class="mb-3 h6 d-flex align-items-center mb-lg-5">
                                        <div class="flex-shrink-0 avatar me-3">
                                            <span class="rounded avatar-initial bg-label-primary"><i
                                                    class='ti ti-layout-grid ti-lg'></i></span>
                                        </div>
                                        <span class="ps-1">Other</span>
                                    </div>
                                    <ul class="nav flex-column">
                                        <li
                                            class="nav-item {{ $currentRouteName === 'front-pages-pricing' ? 'active' : '' }}">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('front-pages/pricing') }}">
                                                <i class='ti ti-circle me-1'></i>
                                                <span>Pricing</span>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ $currentRouteName === 'front-pages-payment' ? 'active' : '' }}">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('front-pages/payment') }}">
                                                <i class='ti ti-circle me-1'></i>
                                                <span>Payment</span>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ $currentRouteName === 'front-pages-checkout' ? 'active' : '' }}">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('front-pages/checkout') }}">
                                                <i class='ti ti-circle me-1'></i>
                                                <span>Checkout</span>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ $currentRouteName === 'front-pages-help-center' ? 'active' : '' }}">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('front-pages/help-center') }}">
                                                <i class='ti ti-circle me-1'></i>
                                                <span>Help Center</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg">
                                    <div class="mb-3 h6 d-flex align-items-center mb-lg-5">
                                        <div class="flex-shrink-0 avatar me-3">
                                            <span class="rounded avatar-initial bg-label-primary"><i
                                                    class='ti ti-lock-open ti-lg'></i></span>
                                        </div>
                                        <span class="ps-1">Auth Demo</span>
                                    </div>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/login-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Login (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/login-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Login (Cover)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/register-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Register (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/register-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Register (Cover)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/register-multisteps') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Register (Multi-steps)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/forgot-password-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Forgot Password (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/forgot-password-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Forgot Password (Cover)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/reset-password-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Reset Password (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/reset-password-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Reset Password (Cover)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 col-lg">
                                    <div class="mb-3 h6 d-flex align-items-center mb-lg-5">
                                        <div class="flex-shrink-0 avatar me-3">
                                            <span class="rounded avatar-initial bg-label-primary"><i
                                                    class='ti ti-file-analytics ti-lg'></i></span>
                                        </div>
                                        <span class="ps-1">Other</span>
                                    </div>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/pages/misc-error') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Error
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/pages/misc-under-maintenance') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Under Maintenance
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/pages/misc-comingsoon') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Coming Soon
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/pages/misc-not-authorized') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Not Authorized
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/verify-email-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Verify Email (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/verify-email-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Verify Email (Cover)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/two-steps-basic') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Two Steps (Basic)
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mega-dropdown-link"
                                                href="{{ url('/auth/two-steps-cover') }}" target="_blank">
                                                <i class='ti ti-circle me-1'></i>
                                                Two Steps (Cover)
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="p-2 bg-body nav-img-col">
                                        <img src="{{ asset('assets/img/front-pages/misc/nav-item-col-img.png') }}"
                                            alt="nav item col image" class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ url('/') }}" target="_blank">Admin</a>
                    </li>
                </ul>
            </div>
            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="flex-row navbar-nav align-items-center ms-auto">
                @if ($configData['hasCustomizer'] == true)
                    <!-- Style Switcher -->
                    <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-1">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <i class='ti ti-lg'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                    <span class="align-middle"><i class='ti ti-sun me-3'></i>Light</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                    <span class="align-middle"><i class="ti ti-moon-stars me-3"></i>Dark</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                    <span class="align-middle"><i
                                            class="ti ti-device-desktop-analytics me-3"></i>System</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- / Style Switcher-->
                @endif
                <!-- navbar button: Start -->
                <li>
                    @if (Auth::check())
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <span class="tf-icons ti ti-dashboard scaleX-n1-rtl me-md-1"></span>
                            <span class="d-none d-md-block">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <span class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span>
                            <span class="d-none d-md-block">Login</span>
                        </a>
                    @endif

                </li>
                <!-- navbar button: End -->
            </ul>
            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
<!-- Navbar: End -->
