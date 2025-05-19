@php
$customizerHidden = 'customizer-hide';
$configData = appClasses();
$current_language = app()->getLocale();
@endphp

@extends('layouts/blankLayout')

@section('title', ($current_language == 'ar') ? 'خطأ في السيرفر' : 'Server Error')

@section('page-style')
<!-- Page -->
@vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection


@section('content')
<!-- Error -->
<div class="container-xxl container-p-y">
  <div class="misc-wrapper">
    <h1 class="mx-2 mb-2 fs-xxlarge" style="line-height: 6rem;font-size: 6rem;">500</h1>
    <h4 class="mx-2 mb-2">{{ __('messages.error.500.heading') }} ⚠️</h4>
    <p class="mx-2 mb-6">{{ __('messages.error.500.sub_heading') }}</p>
    <a href="{{url('/')}}" class="mb-10 btn btn-primary">{{ __('messages.error.500.btn_home') }}</a>
    <div class="mt-4">
      <img src="{{ asset('assets/img/illustrations/page-misc-error.png') }}" alt="page-misc-error" width="225" class="img-fluid">
    </div>
  </div>
</div>
<div class="container-fluid misc-bg-wrapper">
  <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" height="355" alt="page-misc-error" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
</div>
<!-- /Error -->
@endsection
