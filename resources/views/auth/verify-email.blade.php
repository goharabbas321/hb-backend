@php
    $customizerHidden = 'customizer-hide';
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', ($current_language == 'ar') ? 'التحقق من البريد الإلكتروني' : 'Verify Email')

@section('page-style')
    <!-- Page -->
    @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="m-0 authentication-inner row">
            <!-- /Left Text -->
            <div class="p-0 d-none d-lg-flex col-lg-8">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-verify-email-illustration-' . $configData['style'] . '.png') }}"
                        alt="auth-verify-email-cover" class="my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-verify-email-illustration-light.png"
                        data-app-dark-img="illustrations/auth-verify-email-illustration-dark.png">

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-' . $configData['style'] . '.png') }}"
                        alt="auth-verify-email-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!--  Verify email -->
            <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="mx-auto mt-5 mt-12 w-px-400">
                    <h4 class="mb-1">{{ __('messages.verify_email.heading') }} ✉️</h4>
                    <p class="mb-0 text-start">
                        {!! __('messages.verify_email.sub_heading', ['email' => Auth::user()->email]) !!}
                    </p>
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="my-6 btn btn-primary w-100">
                            {{ __('messages.verify_email.btn_resend') }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mb-5 btn btn-danger w-100">
                            <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                            {{ __('messages.verify_email.btn_logout') }}
                        </button>
                    </form>
                    {!! __('messages.verify_email.link_profile', ['profile' => route('profile.show')]) !!}
                </div>
            </div>
            <!-- / Verify email -->
        </div>
    </div>
@endsection
