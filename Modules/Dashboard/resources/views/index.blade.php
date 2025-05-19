@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss'])
@endsection

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/cards-advance.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')

@endsection

@section('content')

    <div class="row g-6">
        <!-- Gamification Card -->
        <div class="col-md-12">
            <div class="card h-100">
                <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                            <h2 class="card-title pb-xl-2">مرحبا بكم في نظام!🎉</h2>
                            <p class="mb-4 fs-large">وَإِن تَعُدُّوا۟ نِعْمَةَ ٱللَّهِ لَا تُحْصُوهَآ ۗ إِنَّ ٱللَّهَ
                                لَغَفُورٌ رَّحِيمٌ</p>
                            <p></p>
                            <a href="#" class="btn btn-primary">عرض</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                        <div class="card-body pb-0 px-0 px-md-4 ps-0">
                            <img src="{{ url('/') }}/assets/img/illustrations/page-pricing-standard.png"
                                alt="View Profile" data-app-light-img="illustrations/page-pricing-standard.png"
                                data-app-dark-img="illustrations/page-pricing-standard.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
