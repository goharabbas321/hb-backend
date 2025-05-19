@php
    $customizerHidden = 'customizer-hide';
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', ($current_language == 'ar') ? 'التحقق بخطوتين' : 'Two Steps Verification')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/auth/index.js', 'resources/assets/js/auth/two-steps.js'])
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="m-0 authentication-inner row">
            <!-- /Left Text -->
            <div class="p-0 d-none d-lg-flex col-lg-8">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-two-step-illustration-' . $configData['style'] . '.png') }}"
                        alt="auth-two-steps-cover" class="my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-two-step-illustration-light.png"
                        data-app-dark-img="illustrations/auth-two-step-illustration-dark.png">

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-' . $configData['style'] . '.png') }}"
                        alt="auth-two-steps-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Two Steps Verification -->
            <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="mx-auto mt-5 mt-12 w-px-400">
                    <h4 class="mb-1">{{ __('messages.2fa.heading') }} 💬</h4>
                    <!-- Dropdown to select verification method -->
                    <label for="verificationMethod" class="form-label">{{ __('messages.2fa.label_method') }}</label>
                    <select id="verificationMethod" class="mb-4 form-select">
                        <option value="code" selected>{{ __('messages.2fa.select_method1') }}</option>
                        <option value="recovery">{{ __('messages.2fa.select_method2') }}</option>
                    </select>
                    <div id="codeForm">
                        <p class="mb-6 text-start">
                            {{ __('messages.2fa.sub_heading') }}
                        </p>
                        <p class="mb-0">{{ __('messages.2fa.p_method1') }}</p>
                        <form id="twoStepsForm" action="{{ route('two-factor.login') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <div
                                    class="auth-input-wrapper d-flex align-items-center justify-content-between numeral-mask-wrapper">
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1" autofocus>
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1">
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1">
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1">
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1">
                                    <input type="tel"
                                        class="my-2 text-center form-control auth-input h-px-50 numeral-mask mx-sm-1"
                                        maxlength="1">
                                </div>
                                <!-- Create a hidden field which is combined by 3 fields above -->
                                <input type="hidden" name="code" />
                            </div>
                            <button class="mb-6 btn btn-primary d-grid w-100">
                                {{ __('messages.2fa.btn_submit') }}
                            </button>
                            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                                {{ __('messages.2fa.link_login') }}
                            </a>
                        </form>
                    </div>
                    <div id="recoveryForm">
                        <p class="mb-6 text-start">
                            {{ __('messages.2fa.sub_heading2') }}
                        </p>
                        <form id="recoveryCodeForm" action="{{ route('two-factor.login') }}" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label for="recovery_code" class="form-label">{{ __('messages.2fa.label_method2') }}</label>
                                <input type="text" name="recovery_code" id="recovery_code" class="form-control"
                                    placeholder="{{ __('messages.2fa.placeholder_method2') }}">
                            </div>
                            <button class="mb-6 btn btn-primary d-grid w-100">{{ __('messages.2fa.btn_submit') }}</button>
                            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
                                {{ __('messages.2fa.link_login') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Two Steps Verification -->
        </div>
    </div>

    <script>
        // Toggle between forms based on the selected verification method
        document.getElementById('recoveryForm').style.display = 'none';
        document.getElementById('verificationMethod').addEventListener('change', function() {
            if (this.value === 'recovery') {
                document.getElementById('codeForm').style.display = 'none';
                document.getElementById('recoveryForm').style.display = 'block';
            } else {
                document.getElementById('codeForm').style.display = 'block';
                document.getElementById('recoveryForm').style.display = 'none';
            }
        });
    </script>

@endsection
