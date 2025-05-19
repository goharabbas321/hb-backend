@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                    @can('update_facilities')
                        <a href="{{ route('facilities.edit', $facility->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i>{{ __('messages.button.edit') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Facility Basic Info -->
                        <div class="col-md-12">
                            <h4>{{ __('medical::messages.facilities.info.basic') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.facilities.field.label_name_en') }}:</strong>
                                    <p>{{ $facility->name_en }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.facilities.field.label_name_ar') }}:</strong>
                                    <p>{{ $facility->name_ar }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="row">
                        <div class="col-12">
                            <h4>{{ __('medical::messages.facilities.info.system') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.created_date') }}:</strong>
                                    <p>{{ $facility->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.updated_date') }}:</strong>
                                    <p>{{ $facility->updated_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.id') }}:</strong>
                                    <p>{{ $facility->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('facilities.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
