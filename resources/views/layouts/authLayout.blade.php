@isset($pageConfigs)
    {!! updatePageConfig($pageConfigs) !!}
@endisset
@php
    $configData = appClasses();

    /* Display elements */
    $customizerHidden = $customizerHidden ?? '';
    $current_language = app()->getLocale();

@endphp

@extends('layouts/commonMaster')

@section('layoutContent')
    <!-- Logo -->
    <a href="{{ url('/') }}" class="app-brand auth-cover-brand">
        <span class="app-brand-logo demo"><img src="{{ asset('/storage/' . $systemSettings['logo_dark']) }}" alt="Logo"
                style="width:36px; height: 52px;"></span>
        @if (getSetting('arabic_name'))
            @if ($current_language == 'ar')
                <span class="app-brand-text demo text-heading fw-bold">{{ $systemSettings['name_ar'] }}</span>
            @else
                <span class="app-brand-text demo text-heading fw-bold">{{ $systemSettings['name'] }}</span>
            @endif
        @else
            <span class="app-brand-text demo text-heading fw-bold">{{ $systemSettings['name'] }}</span>
        @endif
    </a>
    <!-- /Logo -->
    <!-- Content -->
    @yield('content')
    <!--/ Content -->

@endsection
