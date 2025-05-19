@isset($pageConfigs)
{!! updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = appClasses();

/* Display elements */
$customizerHidden = ($customizerHidden ?? '');

@endphp

@extends('layouts/commonMaster' )

@section('layoutContent')

<!-- Content -->
@yield('content')
<!--/ Content -->

@endsection
