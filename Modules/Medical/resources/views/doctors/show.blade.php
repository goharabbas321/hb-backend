@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                    @can('update_doctors')
                        <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-primary">
                            <i class="ti ti-edit me-1"></i>{{ __('messages.button.edit') }}
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <!-- Doctor Image -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            @if ($doctor->profile_picture)
                                <img src="{{ asset('storage/' . $doctor->profile_picture) }}" alt="{{ $doctor->name_en }}"
                                    class="rounded mb-3" style="max-width: 200px;">
                            @else
                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="{{ $doctor->name_en }}"
                                    class="rounded mb-3" style="max-width: 200px;">
                            @endif
                        </div>
                        <!-- Doctor Basic Info -->
                        <div class="col-md-8">
                            <h4>{{ __('medical::messages.doctors.info.basic') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_name_en') }}:</strong>
                                    <p>{{ $doctor->name_en }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_name_ar') }}:</strong>
                                    <p>{{ $doctor->name_ar }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_hospital') }}:</strong>
                                    <p>
                                        @if ($doctor->hospital)
                                            <a href="{{ route('hospitals.show', $doctor->hospital->id) }}">
                                                {{ $doctor->hospital->name_en }} - {{ $doctor->hospital->name_ar }}
                                            </a>
                                        @else
                                            {{ __('medical::messages.doctors.info.not_available') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_specialization') }}:</strong>
                                    <p>
                                        @if ($doctor->specialization)
                                            {{ $doctor->specialization->name_en }} -
                                            {{ $doctor->specialization->name_ar }}
                                        @else
                                            {{ __('medical::messages.doctors.info.not_available') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4>{{ __('medical::messages.doctors.info.contact') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_email') }}:</strong>
                                    <p>{{ $doctor->email ?? __('medical::messages.doctors.info.not_available') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_phone') }}:</strong>
                                    <p>{{ $doctor->phone ?? __('medical::messages.doctors.info.not_available') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4>{{ __('medical::messages.doctors.info.bio') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_bio_en') }}:</strong>
                                    <p>{{ $doctor->bio_en ?? __('medical::messages.doctors.info.not_available') }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>{{ __('medical::messages.doctors.field.label_bio_ar') }}:</strong>
                                    <p>{{ $doctor->bio_ar ?? __('medical::messages.doctors.info.not_available') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="row">
                        <div class="col-12">
                            <h4>{{ __('medical::messages.doctors.info.system') }}</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.created_date') }}:</strong>
                                    <p>{{ $doctor->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.updated_date') }}:</strong>
                                    <p>{{ $doctor->updated_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>{{ __('messages.table.id') }}:</strong>
                                    <p>{{ $doctor->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
