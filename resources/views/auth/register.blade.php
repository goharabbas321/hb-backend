@php
    $customizerHidden = 'customizer-hide';
    $configData = appClasses();
    $current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', $current_language == 'ar' ? 'يسجل' : 'Register')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/auth/register.js'])
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover">
        <div class="m-0 authentication-inner row">
            <!-- /Left Text -->
            <div class="p-0 d-none d-lg-flex col-lg-8">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-register-illustration-' . $configData['style'] . '.png') }}"
                        alt="auth-register-cover" class="my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-register-illustration-light.png"
                        data-app-dark-img="illustrations/auth-register-illustration-dark.png">

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-' . $configData['style'] . '.png') }}"
                        alt="auth-register-cover" class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <!-- /Left Text -->
            <!-- Register -->
            <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
                <div class="pt-5 mx-auto mt-12 w-px-400">
                    <h4 class="mb-1">{{ __('messages.registration.heading') }} 🚀</h4>
                    <p class="mb-6">{{ __('messages.registration.sub_heading') }}</p>

                    <form id="user_form" class="mb-4 row g-6 confirm-form" method="POST" action="{{ route('register') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-6">
                            <label class="form-label" for="username">{{ __('messages.registration.username') }}</label>
                            <input type="text" id="username" class="form-control" placeholder="goharabbas"
                                name="username" value="{{ old('username') }}" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">{{ __('messages.registration.email') }}</label>
                            <input class="form-control" type="email" id="email" name="email"
                                placeholder="gohar@gmail.com" value="{{ old('email') }}" />
                        </div>

                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <label class="form-label" for="password">{{ __('messages.registration.password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="password" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-password2" />
                                    <span class="cursor-pointer input-group-text" id="multicol-password2"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-password-toggle">
                                <label class="form-label"
                                    for="password_confirmation">{{ __('messages.registration.confirm_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="multicol-confirm-password2" />
                                    <span class="cursor-pointer input-group-text" id="multicol-confirm-password2"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="name">{{ __('messages.registration.full_name') }}</label>
                            <input type="text" id="name" class="form-control" placeholder="Gohar Abbas"
                                name="name" value="{{ old('name') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="phone">{{ __('messages.registration.phone_number') }}</label>
                            <div class="input-group">
                                <input type="text" id="phone" class="form-control phone" placeholder="07754732678"
                                    name="phone" maxlength="11" value="{{ old('phone') }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="country">{{ __('messages.registration.country') }}</label>
                            <select id="country" name="country" class="form-select select2" data-allow-clear="true">
                                <option value="">Select</option>
                                @foreach (getCountries() as $country)
                                    <option value="{{ $country }}"
                                        {{ old('country') == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="address">{{ __('messages.registration.address') }}</label>
                            <input type="text" id="address" class="form-control"
                                placeholder="Street No 01, House 34" name="address" value="{{ old('address') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="language">{{ __('messages.registration.language') }}</label>
                            <select id="language" name="language" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->code }}"
                                        {{ old('language') == $language->code ? 'selected' : '' }}>{{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="currency">{{ __('messages.registration.currency') }}</label>
                            <select id="currency" name="currency" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->code }}"
                                        {{ old('currency') == $currency->code ? 'selected' : '' }}>{{ $currency->name }}
                                        ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="time_zone">{{ __('messages.registration.time_zone') }}</label>
                            <select id="time_zone" name="time_zone" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach (timezone_identifiers_list() as $timezone)
                                    @php
                                        $timezoneOffset = (new DateTimeZone($timezone))->getOffset(
                                            new DateTime('now', new DateTimeZone('UTC')),
                                        );
                                        $hours = intdiv($timezoneOffset, 3600);
                                        $minutes = ($timezoneOffset % 3600) / 60;
                                        $formattedOffset = sprintf(
                                            'UTC %s%02d:%02d',
                                            $timezoneOffset >= 0 ? '+' : '-',
                                            abs($hours),
                                            abs($minutes),
                                        );
                                    @endphp
                                    <option value="{{ $timezone }}"
                                        {{ old('time_zone') == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }} ({{ $formattedOffset }})</option>
                                @endforeach
                            </select>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-8 ">
                                <div class="form-check ms-2">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions"
                                        name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        {!! __('messages.registration.agree_terms', [
                                            'terms_link' => route('terms.show'),
                                            'privacy_link' => route('policy.show'),
                                        ]) !!}
                                    </label>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary d-grid w-100">
                            {{ __('messages.registration.btn_submit') }}
                        </button>
                    </form>

                    <p class="text-center">
                        {!! __('messages.registration.link_login', ['login' => route('login')]) !!}
                    </p>

                    <div class="my-6 divider">
                        <div class="divider-text">{{ __('messages.registration.or') }}</div>
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
            <!-- /Register -->
        </div>
    </div>
@endsection
