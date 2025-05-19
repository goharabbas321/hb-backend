@php
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/layoutMaster')

@section('title', $current_language == 'ar' ? 'الصفحة الرئيسية' : 'Home')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['Modules/Front/resources/assets/js/app.js'])
@endsection


@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relatived">
                <img src="{{ asset('assets/img/front-pages/backgrounds/hero-bg.png') }}" alt="hero background"
                    class="top-0 position-absolute start-50 translate-middle-x object-fit-cover w-100 h-100" data-speed="1" />
                <div class="container">
                    <div class="text-center hero-text-box position-relative">
                        <h1 class="text-primary hero-title display-6 fw-extrabold">One dashboard to manage all your
                            businesses</h1>
                        <h2 class="mb-6 hero-sub-title h6">
                            Production-ready & easy to use Admin Template<br class="d-none d-lg-block" />
                            for Reliability and Customizability.
                        </h2>
                        <div class="landing-hero-btn d-inline-block position-relative">
                            <span class="hero-btn-item position-absolute d-none d-md-flex fw-medium">Join community
                                <img src="{{ asset('assets/img/front-pages/icons/Join-community-arrow.png') }}"
                                    alt="Join community arrow" class="scaleX-n1-rtl" /></span>
                            <a href="#landingPricing" class="btn btn-primary btn-lg">Get early access</a>
                        </div>
                    </div>
                    <div id="heroDashboardAnimation" class="hero-animation-img">
                        <a href="{{ url('/app/ecommerce/dashboard') }}" target="_blank">
                            <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                                <img src="{{ asset('assets/img/front-pages/landing-page/hero-dashboard-' . $configData['style'] . '.png') }}"
                                    alt="hero dashboard" class="animation-img"
                                    data-app-light-img="front-pages/landing-page/hero-dashboard-light.png"
                                    data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
                                <img src="{{ asset('assets/img/front-pages/landing-page/hero-elements-' . $configData['style'] . '.png') }}"
                                    alt="hero elements"
                                    class="top-0 position-absolute hero-elements-img animation-img start-0"
                                    data-app-light-img="front-pages/landing-page/hero-elements-light.png"
                                    data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="landing-hero-blank"></div>
        </section>
        <!-- Hero: End -->

        <!-- Useful features: Start -->
        <section id="landingFeatures" class="section-py landing-features">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Useful Features</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Everything you need
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                    to start your next project
                </h4>
                <p class="mb-12 text-center">Not just a set of tools, the package includes ready-to-deploy conceptual
                    application.</p>
                <div class="features-icon-wrapper row gx-0 gy-6 g-sm-12">
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/laptop.png') }}" alt="laptop charging" />
                        </div>
                        <h5 class="mb-2">Quality Code</h5>
                        <p class="features-icon-description">Code structure that all developers will easily understand and
                            fall in love with.</p>
                    </div>
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/rocket.png') }}" alt="transition up" />
                        </div>
                        <h5 class="mb-2">Continuous Updates</h5>
                        <p class="features-icon-description">Free updates for the next 12 months, including new demos and
                            features.</p>
                    </div>
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/paper.png') }}" alt="edit" />
                        </div>
                        <h5 class="mb-2">Stater-Kit</h5>
                        <p class="features-icon-description">Start your project quickly without having to remove unnecessary
                            features.</p>
                    </div>
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/check.png') }}" alt="3d select solid" />
                        </div>
                        <h5 class="mb-2">API Ready</h5>
                        <p class="features-icon-description">Just change the endpoint and see your own data loaded within
                            seconds.</p>
                    </div>
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/user.png') }}" alt="lifebelt" />
                        </div>
                        <h5 class="mb-2">Excellent Support</h5>
                        <p class="features-icon-description">An easy-to-follow doc with lots of references and code
                            examples.</p>
                    </div>
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('assets/img/front-pages/icons/keyboard.png') }}" alt="google docs" />
                        </div>
                        <h5 class="mb-2">Well Documented</h5>
                        <p class="features-icon-description">An easy-to-follow doc with lots of references and code
                            examples.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Useful features: End -->

        <!-- Real customers reviews: Start -->
        <section id="landingReviews" class="pb-0 section-py bg-body landing-reviews">
            <!-- What people say slider: Start -->
            <div class="container">
                <div class="mb-5 row align-items-center gx-0 gy-4 g-lg-5 pb-md-5">
                    <div class="col-md-6 col-lg-5 col-xl-3">
                        <div class="mb-4">
                            <span class="badge bg-label-primary">Real Customers Reviews</span>
                        </div>
                        <h4 class="mb-1">
                            <span class="position-relative fw-extrabold z-1">What people say
                                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                                    alt="laptop charging"
                                    class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                            </span>
                        </h4>
                        <p class="mb-5 mb-md-12">
                            See what our customers have to<br class="d-none d-xl-block" />
                            say about their experience.
                        </p>
                        <div class="landing-reviews-btns">
                            <button id="reviews-previous-btn" class="btn btn-label-primary reviews-btn me-4 scaleX-n1-rtl"
                                type="button">
                                <i class="ti ti-chevron-left ti-md"></i>
                            </button>
                            <button id="reviews-next-btn" class="btn btn-label-primary reviews-btn scaleX-n1-rtl"
                                type="button">
                                <i class="ti ti-chevron-right ti-md"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 col-xl-9">
                        <div class="overflow-hidden swiper-reviews-carousel">
                            <div class="swiper" id="swiper-reviews">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-1.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “Vuexy is hands down the most useful front end Bootstrap theme I've ever
                                                    used. I can't wait
                                                    to use it again for my next project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Cecilia Payne</h6>
                                                        <p class="mb-0 small text-muted">CEO of Airbnb</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-2.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “I've never used a theme as versatile and flexible as Vuexy. It's my go
                                                    to for building
                                                    dashboard sites on almost any project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Eugenia Moore</h6>
                                                        <p class="mb-0 small text-muted">Founder of Hubspot</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-3.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    This template is really clean & well documented. The docs are really
                                                    easy to understand and
                                                    it's always easy to find a screenshot from their website.
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Curtis Fletcher</h6>
                                                        <p class="mb-0 small text-muted">Design Lead at Dribbble</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-4.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    All the requirements for developers have been taken into consideration,
                                                    so I’m able to build
                                                    any interface I want.
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Sara Smith</h6>
                                                        <p class="mb-0 small text-muted">Founder of Continental</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-5.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “I've never used a theme as versatile and flexible as Vuexy. It's my go
                                                    to for building
                                                    dashboard sites on almost any project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Eugenia Moore</h6>
                                                        <p class="mb-0 small text-muted">Founder of Hubspot</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-6.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam nemo
                                                    mollitia, ad eum
                                                    officia numquam nostrum repellendus consequuntur!
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star-filled"></i>
                                                    <i class="ti ti-star"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Sara Smith</h6>
                                                        <p class="mb-0 small text-muted">Founder of Continental</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- What people say slider: End -->
            <hr class="m-0 mt-6 mt-md-12" />
            <!-- Logo slider: Start -->
            <div class="container">
                <div class="py-8 swiper-logo-carousel">
                    <div class="swiper" id="swiper-clients-logos">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_1-' . $configData['style'] . '.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_1-light.png"
                                    data-app-dark-img="front-pages/branding/logo_1-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_2-' . $configData['style'] . '.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_2-light.png"
                                    data-app-dark-img="front-pages/branding/logo_2-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_3-' . $configData['style'] . '.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_3-light.png"
                                    data-app-dark-img="front-pages/branding/logo_3-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_4-' . $configData['style'] . '.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_4-light.png"
                                    data-app-dark-img="front-pages/branding/logo_4-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_5-' . $configData['style'] . '.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_5-light.png"
                                    data-app-dark-img="front-pages/branding/logo_5-dark.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logo slider: End -->
        </section>
        <!-- Real customers reviews: End -->

        <!-- Our great team: Start -->
        <section id="landingTeam" class="section-py landing-team">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Our Great Team</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Supported
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                    by Real People
                </h4>
                <p class="pb-0 text-center mb-md-11 pb-xl-12">Who is behind these great-looking interfaces?</p>
                <div class="mt-2 row gy-12">
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-primary border-bottom-0 border-label-primary position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-1.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50 scaleX-n1-rtl"
                                    alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-primary">
                                <h5 class="mb-0 card-title">Sophie Gilbert</h5>
                                <p class="mb-0 text-muted">Project Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-info border-bottom-0 border-label-info position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-2.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50 scaleX-n1-rtl"
                                    alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-info">
                                <h5 class="mb-0 card-title">Paul Miles</h5>
                                <p class="mb-0 text-muted">UI Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-danger border-bottom-0 border-label-danger position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-3.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50 scaleX-n1-rtl"
                                    alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-danger">
                                <h5 class="mb-0 card-title">Nannie Ford</h5>
                                <p class="mb-0 text-muted">Development Lead</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-success border-bottom-0 border-label-success position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-4.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50 scaleX-n1-rtl"
                                    alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-success">
                                <h5 class="mb-0 card-title">Chris Watkins</h5>
                                <p class="mb-0 text-muted">Marketing Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Our great team: End -->

        <!-- Pricing plans: Start -->
        <section id="landingPricing" class="section-py bg-body landing-pricing">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Pricing Plans</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Tailored pricing plans
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                    designed for you
                </h4>
                <p class="pb-2 text-center mb-7">All plans include 40+ advanced tools and features to boost your
                    product.<br />Choose the best plan to fit your needs.</p>
                <div class="mb-12 text-center">
                    <div class="pt-3 position-relative d-inline-block pt-md-0">
                        <label class="switch switch-sm switch-primary me-0">
                            <span class="switch-label fs-6 text-body me-3">Pay Monthly</span>
                            <input type="checkbox" class="switch-input price-duration-toggler" checked />
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                            <span class="switch-label fs-6 text-body ms-3">Pay Annual</span>
                        </label>
                        <div class="pricing-plans-item position-absolute d-flex">
                            <img src="{{ asset('assets/img/front-pages/icons/pricing-plans-arrow.png') }}"
                                alt="pricing plans arrow" class="scaleX-n1-rtl" />
                            <span class="mt-2 fw-medium ms-1"> Save 25%</span>
                        </div>
                    </div>
                </div>
                <div class="row g-6 pt-lg-5">
                    <!-- Basic Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/paper-airplane.png') }}"
                                        alt="paper airplane icon" class="pb-2 mb-8" />
                                    <h4 class="mb-0">Basic</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$19</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$14</span>
                                        <sub class="h6 text-muted mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-muted price-yearly-toggle d-none">$ 168 / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Timeline
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Basic search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Live chat widget
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Email marketing
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Custom Forms
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Traffic analytics
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Basic Support
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="{{ url('/front-pages/payment') }}" class="btn btn-label-primary">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Basic Plan: End -->

                    <!-- Favourite Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="border shadow-xl card border-primary">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/plane.png') }}" alt="plane icon"
                                        class="pb-2 mb-8" />
                                    <h4 class="mb-0">Team</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$29</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$22</span>
                                        <sub class="h6 text-muted mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-muted price-yearly-toggle d-none">$ 264 / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Everything in basic
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Timeline with database
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Advanced search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Marketing automation
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Advanced chatbot
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Campaign management
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Collaboration tools
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="{{ url('/front-pages/payment') }}" class="btn btn-primary">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Favourite Plan: End -->

                    <!-- Standard Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/shuttle-rocket.png') }}"
                                        alt="shuttle rocket icon" class="pb-2 mb-8" />
                                    <h4 class="mb-0">Enterprise</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$49</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$37</span>
                                        <sub class="h6 text-muted mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-muted price-yearly-toggle d-none">$ 444 / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Everything in premium
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Timeline with database
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Fuzzy search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            A/B testing sanbox
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Custom permissions
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Social media automation
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-2"><i
                                                    class="ti ti-check ti-14px"></i></span>
                                            Sales automation tools
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="{{ url('/front-pages/payment') }}" class="btn btn-label-primary">Get
                                        Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Standard Plan: End -->
                </div>
            </div>
        </section>
        <!-- Pricing plans: End -->

        <!-- Fun facts: Start -->
        <section id="landingFunFacts" class="section-py landing-fun-facts">
            <div class="container">
                <div class="row gy-6">
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-primary">
                            <div class="text-center card-body">
                                <img src="{{ asset('assets/img/front-pages/icons/laptop.png') }}" alt="laptop"
                                    class="mb-4" />
                                <h3 class="mb-0">7.1k+</h3>
                                <p class="mb-0 fw-medium">
                                    Support Tickets<br />
                                    Resolved
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-success">
                            <div class="text-center card-body">
                                <img src="{{ asset('assets/img/front-pages/icons/user-success.png') }}" alt="laptop"
                                    class="mb-4" />
                                <h3 class="mb-0">50k+</h3>
                                <p class="mb-0 fw-medium">
                                    Join creatives<br />
                                    community
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-info">
                            <div class="text-center card-body">
                                <img src="{{ asset('assets/img/front-pages/icons/diamond-info.png') }}" alt="laptop"
                                    class="mb-4" />
                                <h3 class="mb-0">4.8/5</h3>
                                <p class="mb-0 fw-medium">
                                    Highly Rated<br />
                                    Products
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-warning">
                            <div class="text-center card-body">
                                <img src="{{ asset('assets/img/front-pages/icons/check-warning.png') }}" alt="laptop"
                                    class="mb-4" />
                                <h3 class="mb-0">100%</h3>
                                <p class="mb-0 fw-medium">
                                    Money Back<br />
                                    Guarantee
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fun facts: End -->

        <!-- FAQ: Start -->
        <section id="landingFAQ" class="section-py bg-body landing-faq">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">FAQ</span>
                </div>
                <h4 class="mb-1 text-center">Frequently asked
                    <span class="position-relative fw-extrabold z-1">questions
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                </h4>
                <p class="mb-12 text-center pb-md-4">Browse through these FAQs to find answers to commonly asked questions.
                </p>
                <div class="row gy-12 align-items-center">
                    <div class="col-lg-5">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/front-pages/landing-page/faq-boy-with-logos.png') }}"
                                alt="faq boy with logos" class="faq-image" />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion" id="accordionExample">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                        Do you charge for each upgrade?
                                    </button>
                                </h2>

                                <div id="accordionOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Lemon drops chocolate cake gummies carrot cake chupa chups muffin topping. Sesame
                                        snaps icing
                                        marzipan gummi bears macaroon dragée danish caramels powder. Bear claw dragée pastry
                                        topping
                                        soufflé. Wafer gummi bears marshmallow pastry pie.
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionTwo" aria-expanded="false"
                                        aria-controls="accordionTwo">
                                        Do I need to purchase a license for each website?
                                    </button>
                                </h2>
                                <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Dessert ice cream donut oat cake jelly-o pie sugar plum cheesecake. Bear claw dragée
                                        oat cake
                                        dragée ice cream halvah tootsie roll. Danish cake oat cake pie macaroon tart donut
                                        gummies. Jelly
                                        beans candy canes carrot cake. Fruitcake chocolate chupa chups.
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item active">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionThree" aria-expanded="false"
                                        aria-controls="accordionThree">
                                        What is regular license?
                                    </button>
                                </h2>
                                <div id="accordionThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Regular license can be used for end products that do not charge users for access or
                                        service(access
                                        is free and there will be no monthly subscription fee). Single regular license can
                                        be used for
                                        single end product and end product can be used by you or your client. If you want to
                                        sell end
                                        product to multiple clients then you will need to purchase separate license for each
                                        client. The
                                        same rule applies if you want to use the same end product on multiple domains(unique
                                        setup). For
                                        more info on regular license you can check official description.
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFour" aria-expanded="false"
                                        aria-controls="accordionFour">
                                        What is extended license?
                                    </button>
                                </h2>
                                <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis et aliquid quaerat
                                        possimus maxime!
                                        Mollitia reprehenderit neque repellat deleniti delectus architecto dolorum maxime,
                                        blanditiis
                                        earum ea, incidunt quam possimus cumque.
                                    </div>
                                </div>
                            </div>
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFive" aria-expanded="false"
                                        aria-controls="accordionFive">
                                        Which license is applicable for SASS application?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sequi molestias
                                        exercitationem ab cum
                                        nemo facere voluptates veritatis quia, eveniet veniam at et repudiandae mollitia
                                        ipsam quasi
                                        labore enim architecto non!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ: End -->

        <!-- CTA: Start -->
        <section id="landingCTA" class="pb-0 section-py landing-cta position-relative p-lg-0">
            <img src="{{ asset('assets/img/front-pages/backgrounds/cta-bg-' . $configData['style'] . '.png') }}"
                class="bottom-0 position-absolute end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image"
                data-app-light-img="front-pages/backgrounds/cta-bg-light.png"
                data-app-dark-img="front-pages/backgrounds/cta-bg-dark.png" />
            <div class="container">
                <div class="row align-items-center gy-12">
                    <div class="col-lg-6 text-start text-sm-center text-lg-start">
                        <h3 class="mb-0 cta-title text-primary fw-bold">Ready to Get Started?</h3>
                        <h5 class="mb-8 text-body">Start your project with a 14-day free trial</h5>
                        <a href="{{ url('/front-pages/payment') }}" class="btn btn-lg btn-primary">Get Started</a>
                    </div>
                    <div class="text-center col-lg-6 pt-lg-12 text-lg-end">
                        <img src="{{ asset('assets/img/front-pages/landing-page/cta-dashboard.png') }}"
                            alt="cta dashboard" class="img-fluid mt-lg-4" />
                    </div>
                </div>
            </div>
        </section>
        <!-- CTA: End -->

        <!-- Contact Us: Start -->
        <section id="landingContact" class="section-py bg-body landing-contact">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Contact US</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Let's work
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                    together
                </h4>
                <p class="mb-12 text-center pb-md-4">Any question or remark? just write us a message</p>
                <div class="row g-6">
                    <div class="col-lg-5">
                        <div class="p-2 border contact-img-box position-relative h-100">
                            <img src="{{ asset('assets/img/front-pages/icons/contact-border.png') }}"
                                alt="contact border"
                                class="contact-border-img position-absolute d-none d-lg-block scaleX-n1-rtl" />
                            <img src="{{ asset('assets/img/front-pages/landing-page/contact-customer-service.png') }}"
                                alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
                            <div class="p-4 pb-2">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded badge bg-label-primary p-1_5 me-3"><i
                                                    class="ti ti-mail ti-lg"></i></div>
                                            <div>
                                                <p class="mb-0">Email</p>
                                                <h6 class="mb-0"><a href="mailto:example@gmail.com"
                                                        class="text-heading">example@gmail.com</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded badge bg-label-success p-1_5 me-3"><i
                                                    class="ti ti-phone-call ti-lg"></i></div>
                                            <div>
                                                <p class="mb-0">Phone</p>
                                                <h6 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234
                                                        568 963</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="mb-2">Send a message</h4>
                                <p class="mb-6">
                                    If you would like to discuss anything related to payment, account, licensing,<br
                                        class="d-none d-lg-block" />
                                    partnerships, or have pre-sales questions, you’re at the right place.
                                </p>
                                <form>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-fullname">Full Name</label>
                                            <input type="text" class="form-control" id="contact-form-fullname"
                                                placeholder="john" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-email">Email</label>
                                            <input type="text" id="contact-form-email" class="form-control"
                                                placeholder="johndoe@gmail.com" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="contact-form-message">Message</label>
                                            <textarea id="contact-form-message" class="form-control" rows="7" placeholder="Write a message"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Send inquiry</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Us: End -->
    </div>
@endsection
