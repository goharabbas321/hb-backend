@php
    $customizerHidden = 'customizer-hide';
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', $current_language == 'ar' ? 'تسجيل الدخول' : 'Login')

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
                    <img src="{{ asset('assets/img/illustrations/auth-login-illustration-light.png') }}"
                        alt="auth-login-cover" class="my-5 auth-illustration">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="pt-5 mx-auto mt-12 w-px-400">
                    <h4 class="mb-1">
                        {{ __('messages.login.heading', ['system_name' => config('variables.templateName')]) }} 👋</h4>
                    <p class="mb-6">{{ __('messages.login.sub_heading') }}</p>

                    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-6">
                            <label for="username" class="form-label">{{ __('messages.login.username') }}</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" autofocus autocomplete="username"
                                placeholder="{{ __('messages.login.username_placeholder') }}" />
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">{{ __('messages.login.password') }}</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" autocomplete="current-password" />
                                <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="my-8">
                            <div class="d-flex justify-content-between">
                                <div class="mb-0 form-check ms-2">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                    <label class="form-check-label" for="remember-me">
                                        {{ __('messages.login.remember') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <p class="mb-0">{{ __('messages.login.forgot') }}</p>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100">
                            {{ __('messages.login.sign_in') }}
                        </button>
                    </form>
                    @if ($systemSettings['registration'])
                        <p class="text-center">
                            <span>{{ __('messages.login.new') }}</span>
                            <a href="{{ route('register') }}">
                                <span>{{ __('messages.login.register') }}</span>
                            </a>
                        </p>
                    @endif

                    <div class="my-6 divider">
                        <div class="divider-text">{{ __('messages.login.or') }}</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                            <i class="tf-icons ti ti-brand-facebook-filled"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-twitter me-1_5">
                            <i class="tf-icons ti ti-brand-twitter-filled"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-github me-1_5">
                            <i class="tf-icons ti ti-brand-github-filled"></i>
                        </a>

                        <a href="javascript:;" class="btn btn-sm btn-icon rounded-pill btn-text-google-plus">
                            <i class="tf-icons ti ti-brand-google-filled"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
@endsection
