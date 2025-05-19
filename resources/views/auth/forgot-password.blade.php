@php
    $customizerHidden = 'customizer-hide';
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', ($current_language == 'ar') ? 'هل نسيت كلمة السر' : 'Forgot Password')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/auth/index.js'])
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="m-0 authentication-inner row">
            <!-- /Left Text -->
            <div class="p-0 d-none d-lg-flex col-lg-8">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-forgot-password-illustration-' . $configData['style'] . '.png') }}"
                        alt="auth-forgot-password-cover" class="my-5 auth-illustration d-lg-block d-none"
                        data-app-light-img="illustrations/auth-forgot-password-illustration-light.png"
                        data-app-dark-img="illustrations/auth-forgot-password-illustration-dark.png">

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-' . $configData['style'] . '.png') }}"
                        alt="auth-forgot-password-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Forgot Password -->
            <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="mx-auto mt-5 mt-12 w-px-400">
                    <h4 class="mb-1">{{ __('messages.forgot_password.heading') }} 🔒</h4>
                    <p class="mb-6">{{ __('messages.forgot_password.sub_heading') }} </p>
                    <form id="formAuthentication" class="mb-6" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="email" class="form-label">{{ __('messages.forgot_password.email') }}</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="{{ __('messages.forgot_password.email_placeholder') }}" required autofocus autocomplete="username">
                        </div>
                        <button class="btn btn-primary d-grid w-100">{{ __('messages.forgot_password.btn_submit') }}</button>
                    </form>
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                            <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                            {{ __('messages.forgot_password.link_login') }}
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
        </div>
    </div>
@endsection
