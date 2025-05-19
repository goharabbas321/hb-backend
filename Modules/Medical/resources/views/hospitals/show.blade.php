@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('medical::messages.hospitals.heading.show') }}</h5>
                    <div>
                        <a href="{{ route('hospitals.index') }}" class="btn btn-secondary me-2">
                            <i class="ti ti-arrow-left me-sm-1"></i>
                            <span class="d-none d-sm-inline-block">{{ __('messages.button.back') }}</span>
                        </a>
                        @can('update_hospitals')
                            <a href="{{ route('hospitals.edit', $hospital->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">{{ __('messages.button.edit') }}</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Hospital Information -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.basic') }}</div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ $hospital->image ? Storage::url($hospital->image) : asset('assets/img/icons/hospital-default.png') }}"
                                            class="d-block rounded me-3" width="100" />
                                        <div>
                                            <h4 class="mb-1">{{ $hospital->name_en }}</h4>
                                            <h5 class="mb-1 text-muted">{{ $hospital->name_ar }}</h5>
                                        </div>
                                    </div>
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.table.city') }}</dt>
                                        <dd class="col-sm-8">{{ $hospital->city->name_en }}
                                            ({{ $hospital->city->name_ar }})</dd>

                                        <dt class="col-sm-4">
                                            {{ __('medical::messages.hospitals.field.label_hospital_user') }}</dt>
                                        <dd class="col-sm-8">
                                            @if ($hospital->user)
                                                {{ $hospital->user->name }} ({{ $hospital->user->email }})
                                            @else
                                                <span
                                                    class="text-muted">{{ __('medical::messages.hospitals.info.not_available') }}</span>
                                            @endif
                                        </dd>

                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.table.email') }}</dt>
                                        <dd class="col-sm-8"><a
                                                href="mailto:{{ $hospital->email }}">{{ $hospital->email }}</a></dd>

                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.table.website') }}</dt>
                                        <dd class="col-sm-8">
                                            @if ($hospital->website)
                                                <a href="{{ $hospital->website }}"
                                                    target="_blank">{{ $hospital->website }}</a>
                                            @else
                                                <span
                                                    class="text-muted">{{ __('medical::messages.hospitals.info.not_available') }}</span>
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.contact') }}</div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.field.label_contact_en') }}
                                        </dt>
                                        <dd class="col-sm-8">{{ $hospital->contact_en }}</dd>

                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.field.label_contact_ar') }}
                                        </dt>
                                        <dd class="col-sm-8">{{ $hospital->contact_ar }}</dd>

                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.field.label_address_en') }}
                                        </dt>
                                        <dd class="col-sm-8">{{ $hospital->address_en }}</dd>

                                        <dt class="col-sm-4">{{ __('medical::messages.hospitals.field.label_address_ar') }}
                                        </dt>
                                        <dd class="col-sm-8">{{ $hospital->address_ar }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.working_hours') }}</div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">
                                            {{ __('medical::messages.hospitals.field.label_working_hours_en') }}</dt>
                                        <dd class="col-sm-8">{{ $hospital->working_hours_en }}</dd>

                                        <dt class="col-sm-4">
                                            {{ __('medical::messages.hospitals.field.label_working_hours_ar') }}</dt>
                                        <dd class="col-sm-8">{{ $hospital->working_hours_ar }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.description') }}</div>
                                <div class="card-body">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">
                                            {{ __('medical::messages.hospitals.field.label_description_en') }}</dt>
                                        <dd class="col-sm-8">
                                            {{ $hospital->description_en ?? __('medical::messages.hospitals.info.not_available') }}
                                        </dd>

                                        <dt class="col-sm-4">
                                            {{ __('medical::messages.hospitals.field.label_description_ar') }}</dt>
                                        <dd class="col-sm-8">
                                            {{ $hospital->description_ar ?? __('medical::messages.hospitals.info.not_available') }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Specializations -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.specializations') }}</div>
                                <div class="card-body">
                                    @if ($hospital->specializations->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($hospital->specializations as $specialization)
                                                <span class="badge bg-label-primary">{{ $specialization->name_en }}
                                                    ({{ $specialization->name_ar }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted">
                                            {{ __('medical::messages.hospitals.info.no_specializations') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Facilities -->
                        <div class="col-md-6">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.facilities') }}</div>
                                <div class="card-body">
                                    @if ($hospital->facilities->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($hospital->facilities as $facility)
                                                <span class="badge bg-label-success">{{ $facility->name_en }}
                                                    ({{ $facility->name_ar }})
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted">
                                            {{ __('medical::messages.hospitals.info.no_facilities') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- System Info -->
                        <div class="col-12">
                            <div class="card shadow-none bg-light mb-3">
                                <div class="card-header">{{ __('medical::messages.hospitals.info.system') }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">{{ __('messages.table.created_date') }}</dt>
                                                <dd class="col-sm-8">{{ $hospital->created_at->format('Y-m-d') }}</dd>

                                                <dt class="col-sm-4">{{ __('messages.table.created_time') }}</dt>
                                                <dd class="col-sm-8">{{ $hospital->created_at->format('H:i:s') }}</dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">{{ __('messages.table.updated_date') }}</dt>
                                                <dd class="col-sm-8">{{ $hospital->updated_at->format('Y-m-d') }}</dd>

                                                <dt class="col-sm-4">{{ __('messages.table.updated_time') }}</dt>
                                                <dd class="col-sm-8">{{ $hospital->updated_at->format('H:i:s') }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
