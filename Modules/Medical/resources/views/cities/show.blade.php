@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                    @can('update_cities')
                        <a href="{{ route('cities.edit', $city->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i>{{ __('messages.button.edit') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- City Basic Info -->
                        <div class="col-md-12">
                            <h4>{{ __('medical::messages.cities.info.basic') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.cities.field.label_name_en') }}:</strong>
                                    <p>{{ $city->name_en }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.cities.field.label_name_ar') }}:</strong>
                                    <p>{{ $city->name_ar }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('cities.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
