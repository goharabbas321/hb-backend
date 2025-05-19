@extends('layouts/layoutMaster')

@section('title', __($page_title))

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

@section('page-script')
    @vite(['Modules/Medical/resources/assets/js/doctors.js'])
    <script>
        window.translations = @json(__('medical::messages'));
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __($page_title) }}</h4>
                </div>
                <div class="card-body">
                    <form id="doctor_form" class="row g-3" method="POST" action="{{ route('doctors.update', $doctor->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Doctor Profile Picture -->
                        <div class="col-12">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                @if ($doctor->profile_picture)
                                    <img src="{{ asset('storage/' . $doctor->profile_picture) }}" alt="doctor-avatar"
                                        class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                                @else
                                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="doctor-avatar"
                                        class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                                @endif
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span
                                            class="d-none d-sm-block">{{ __('medical::messages.doctors.field.upload_image') }}</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="profile_picture"
                                            class="doctor-file-input d-none" accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary doctor-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('messages.button.reset') }}</span>
                                    </button>
                                    <div class="text-muted">{{ __('medical::messages.doctors.info.upload_image') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_en">{{ __('medical::messages.doctors.field.label_name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                value="{{ $doctor->name_en }}"
                                placeholder="{{ __('medical::messages.doctors.field.placeholder_name_en') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_ar">{{ __('medical::messages.doctors.field.label_name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                value="{{ $doctor->name_ar }}"
                                placeholder="{{ __('medical::messages.doctors.field.placeholder_name_ar') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="hospital_id">{{ __('medical::messages.doctors.field.label_hospital') }}</label>
                            <select id="hospital_id" class="select2 form-select" name="hospital_id" data-allow-clear="true">
                                <option value="">{{ __('medical::messages.doctors.field.placeholder_hospital') }}
                                </option>
                                @foreach (\Modules\Medical\Models\Hospital::all() as $hospital)
                                    <option value="{{ $hospital->id }}"
                                        {{ $doctor->hospital_id == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->name_en }} - {{ $hospital->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="specialization_id">{{ __('medical::messages.doctors.field.label_specialization') }}</label>
                            <select id="specialization_id" class="select2 form-select" name="specialization_id"
                                data-allow-clear="true">
                                <option value="">
                                    {{ __('medical::messages.doctors.field.placeholder_specialization') }}</option>
                                @foreach (\Modules\Medical\Models\Specialization::all() as $specialization)
                                    <option value="{{ $specialization->id }}"
                                        {{ $doctor->specialization_id == $specialization->id ? 'selected' : '' }}>
                                        {{ $specialization->name_en }} - {{ $specialization->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="bio_en">{{ __('medical::messages.doctors.field.label_bio_en') }}</label>
                            <textarea id="bio_en" class="form-control" name="bio_en"
                                placeholder="{{ __('medical::messages.doctors.field.placeholder_bio_en') }}">{{ $doctor->bio_en }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="bio_ar">{{ __('medical::messages.doctors.field.label_bio_ar') }}</label>
                            <textarea id="bio_ar" class="form-control" name="bio_ar"
                                placeholder="{{ __('medical::messages.doctors.field.placeholder_bio_ar') }}">{{ $doctor->bio_ar }}</textarea>
                        </div>

                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-label-secondary" onclick="window.history.back()">
                                {{ __('messages.button.back') }}
                            </button>
                            <button type="submit" class="btn btn-primary">{{ __('messages.button.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
