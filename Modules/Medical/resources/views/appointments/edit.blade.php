@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['Modules/Medical/resources/assets/js/appointments.js'])
    <script>
        window.translations = @json(__('medical::messages'));
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('medical::messages.appointments.heading.edit') }}</h5>
                    <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i>{{ __('messages.button.back') }}
                    </a>
                </div>
                <div class="card-body">
                    <form id="appointment_edit_form" method="POST"
                        action="{{ route('appointments.update', $appointment->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="hospital_id">{{ __('medical::messages.appointments.form.hospital') }} <span
                                        class="text-danger">*</span></label>
                                <select id="hospital_id" name="hospital_id" class="form-select select2" required>
                                    <option value="">{{ __('messages.select.select') }}</option>
                                    @foreach ($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}"
                                            {{ $appointment->hospital_id == $hospital->id ? 'selected' : '' }}>
                                            {{ $hospital->name_en }} - {{ $hospital->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('hospital_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="specialization_id">{{ __('medical::messages.appointments.form.specialization') }}
                                    <span class="text-danger">*</span></label>
                                <select id="specialization_id" name="specialization_id" class="form-select select2"
                                    required>
                                    <option value="">{{ __('messages.select.select') }}</option>
                                    @foreach ($specializations as $specialization)
                                        <option value="{{ $specialization->id }}"
                                            {{ $appointment->specialization_id == $specialization->id ? 'selected' : '' }}>
                                            {{ $specialization->name_en }} - {{ $specialization->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('specialization_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="user_id">{{ __('medical::messages.appointments.form.patient') }} <span
                                        class="text-danger">*</span></label>
                                <select id="user_id" name="user_id" class="form-select select2" required>
                                    <option value="">{{ __('messages.select.select') }}</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ $appointment->user_id == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="appointment_date">{{ __('medical::messages.appointments.form.appointment_date') }}
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control flatpickr-input" id="appointment_date"
                                    name="appointment_date" value="{{ $appointment->appointment_date }}"
                                    placeholder="YYYY-MM-DD" required />
                                @error('appointment_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="appointment_number">{{ __('medical::messages.appointments.form.appointment_number') }}
                                    <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="appointment_number" name="appointment_number"
                                    value="{{ $appointment->appointment_number }}" min="1" required />
                                @error('appointment_number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label"
                                    for="status">{{ __('medical::messages.appointments.form.status') }} <span
                                        class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-select select2" required>
                                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>
                                        {{ __('medical::messages.appointments.status.scheduled') }}</option>
                                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>
                                        {{ __('medical::messages.appointments.status.confirmed') }}</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                                        {{ __('medical::messages.appointments.status.completed') }}</option>
                                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>
                                        {{ __('medical::messages.appointments.status.cancelled') }}</option>
                                    <option value="no_show" {{ $appointment->status == 'no_show' ? 'selected' : '' }}>
                                        {{ __('medical::messages.appointments.status.no_show') }}</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label"
                                    for="reason">{{ __('medical::messages.appointments.form.reason') }}</label>
                                <input type="text" class="form-control" id="reason" name="reason"
                                    value="{{ $appointment->reason }}" maxlength="255" />
                                @error('reason')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label"
                                    for="notes">{{ __('medical::messages.appointments.form.notes') }}</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ $appointment->notes }}</textarea>
                                @error('notes')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="submit"
                                    class="btn btn-primary me-sm-3 me-1">{{ __('messages.button.update') }}</button>
                                <a href="{{ route('appointments.index') }}"
                                    class="btn btn-label-secondary">{{ __('messages.button.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
