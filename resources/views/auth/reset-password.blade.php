@php
$customizerHidden = 'customizer-hide';
$configData = appClasses();
$current_language = app()->getLocale();
@endphp

@extends('layouts/authLayout')

@section('title', ($current_language == 'ar') ? 'إعادة تعيين كلمة المرور' : 'Reset Password')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/auth/index.js'
])
@endsection

@section('content')
<div class="authentication-wrapper authentication-cover">
  <div class="m-0 authentication-inner row">
    <!-- /Left Text -->
    <div class="p-0 d-none d-lg-flex col-lg-8">
      <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
        <img src="{{ asset('assets/img/illustrations/auth-reset-password-illustration-'.$configData['style'].'.png') }}" alt="auth-reset-password-cover" class="my-5 auth-illustration" data-app-light-img="illustrations/auth-reset-password-illustration-light.png" data-app-dark-img="illustrations/auth-reset-password-illustration-dark.png">

        <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" alt="auth-reset-password-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Reset Password -->
    <div class="p-6 d-flex col-12 col-lg-4 align-items-center authentication-bg p-sm-12">
      <div class="pt-5 mx-auto mt-12 w-px-400">
        <h4 class="mb-1">{{ __('messages.reset_password.heading') }} 🔒</h4>
        <p class="mb-6"><span class="fw-medium">{{ __('messages.reset_password.sub_heading') }}</span></p>
        <form id="formAuthentication" class="mb-6" action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">
          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">{{ __('messages.reset_password.new_password') }}</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
              <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>
          <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password_confirmation">{{ __('messages.reset_password.confirm_password') }}</label>
            <div class="input-group input-group-merge">
              <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
              <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>
          <button class="mb-6 btn btn-primary d-grid w-100">
            {{ __('messages.reset_password.btn_submit') }}
          </button>
          <div class="text-center">
            <a href="{{route('login')}}">
              <i class="ti ti-chevron-left scaleX-n1-rtl me-1_5"></i>
              {{ __('messages.reset_password.link_login') }}
            </a>
          </div>
        </form>
      </div>
    </div>
    <!-- /Reset Password -->
  </div>
</div>
@endsection
