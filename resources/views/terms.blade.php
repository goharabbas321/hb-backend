@php
    $configData = appClasses();
@endphp

@extends('layouts/blankLayout')

@section('title', 'Terms of Service - Front Pages')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
@endsection

<!-- Page Styles -->
@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/front-page-landing.scss'])
    <style>
        h1{
            font-size: 24px !important;
        }
    </style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/nouislider/nouislider.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')

@endsection


@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- FAQ: Start -->
        <section id="landingFAQ" class="section-py bg-body landing-faq">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Terms of Service</span>
                </div>
                <h4 class="mb-1 text-center">Terms of
                    <span class="position-relative fw-extrabold z-1">Service
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1">
                    </span>
                </h4>
                <p class="mb-12 text-center pb-md-4">Here are the terms of service for the system
                </p>
                <div class="row gy-12 align-items-center">
                    <div class="col-lg-12">
                        <div class="p-6 card">
                            {!! $terms !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ: End -->
    </div>
@endsection
