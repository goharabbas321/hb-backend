@php
$customizerHidden = 'customizer-hide';
$configData = appClasses();
$current_language = app()->getLocale();
@endphp

@extends('layouts/blankLayout')

@section('title', ($current_language == 'ar') ? 'غير مصرح به' : 'Not Authorized')

@section('page-style')
<!-- Page -->
@vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection


@section('content')
<!-- Not Authorized -->
<div class="container-xxl container-p-y">
  <div class="misc-wrapper">
    <h1 class="mx-2 mb-2" style="line-height: 6rem;font-size: 6rem;">403</h1>
    <h4 class="mx-2 mb-2">{{ __('messages.error.403.heading') }} 🔐</h4>
    <p class="mx-2 mb-6">{{ __('messages.error.403.sub_heading') }}</p>
    <a href="{{url('/')}}" class="btn btn-primary">{{ __('messages.error.403.btn_home') }}</a>
    <div class="mt-12">
      <img src="{{ asset('assets/img/illustrations/page-misc-you-are-not-authorized.png') }}" alt="page-misc-not-authorized" width="170" class="img-fluid">
    </div>
  </div>
</div>
<div class="container-fluid misc-bg-wrapper">
  <img src="{{ asset('assets/img/illustrations/bg-shape-image-'.$configData['style'].'.png') }}" height="355" alt="page-misc-not-authorized" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
</div>
<!-- /Not Authorized -->
@endsection
