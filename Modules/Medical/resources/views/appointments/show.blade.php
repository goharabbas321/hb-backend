@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('medical::messages.appointments.heading.show') }}</h5>
                    <div>
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary me-2">
                            <i class="ti ti-edit me-1"></i>{{ __('messages.button.edit') }}
                        </a>
                        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <!-- Appointment Information Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary">
                                    {{ __('medical::messages.appointments.sections.appointment_info') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.table.appointment_date') }}:</label>
                                        <p>{{ $appointment->appointment_date }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.table.appointment_number') }}:</label>
                                        <p>{{ $appointment->appointment_number }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.table.status') }}:</label>
                                        <p>
                                            @php
                                                $statusClass =
                                                    [
                                                        'scheduled' => 'bg-label-primary',
                                                        'confirmed' => 'bg-label-success',
                                                        'completed' => 'bg-label-info',
                                                        'cancelled' => 'bg-label-danger',
                                                        'no_show' => 'bg-label-warning',
                                                    ][$appointment->status] ?? 'bg-label-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ __('medical::messages.appointments.status.' . $appointment->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.form.reason') }}:</label>
                                        <p>{{ $appointment->reason ?: '-' }}</p>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.form.notes') }}:</label>
                                        <p>{{ $appointment->notes ?: '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Hospital & Specialization Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary">
                                    {{ __('medical::messages.appointments.sections.medical_info') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.table.hospital') }}:</label>
                                        <p>{{ $appointment->hospital->name_en }}</p>
                                        <p>{{ $appointment->hospital->name_ar }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.table.specialization') }}:</label>
                                        <p>{{ $appointment->specialization->name_en }}</p>
                                        <p>{{ $appointment->specialization->name_ar }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Patient Information Section -->
                            <div class="mb-4">
                                <h5 class="mb-3 text-primary">
                                    {{ __('medical::messages.appointments.sections.patient_info') }}</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.name') }}:</label>
                                        <p>{{ $appointment->patient->name }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.email') }}:</label>
                                        <p>{{ $appointment->patient->email }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.phone') }}:</label>
                                        <p>{{ $appointment->patient->phone ?: '-' }}</p>
                                    </div>
                                    @php
                                        $patientInfo = json_decode($appointment->patient->user_information, true) ?? [];
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.age') }}:</label>
                                        <p>{{ $patientInfo['age'] ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.gender') }}:</label>
                                        <p>{{ $patientInfo['gender'] ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.city') }}:</label>
                                        <p>{{ $patientInfo['city'] ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.address') }}:</label>
                                        <p>{{ $patientInfo['address'] ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label
                                            class="fw-bold">{{ __('medical::messages.appointments.patient.emergency_contact') }}:</label>
                                        <p>{{ $patientInfo['emergency_contact'] ?? '-' }}</p>
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
