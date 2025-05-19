@extends('layouts/layoutMaster')

@section('title', __($page_title))

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/typeahead-js/typeahead.scss', 'resources/assets/vendor/libs/tagify/tagify.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['Modules/Medical/resources/assets/js/hospitals.js'])
    <script>
        window.translations = @json(__('medical::messages'));
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('medical::messages.hospitals.heading.edit') }}</h5>
                    <a href="{{ route('hospitals.index') }}" class="btn btn-secondary">{{ __('messages.button.back') }}</a>
                </div>
                <div class="card-body">
                    <form id="hospital_form" class="row g-3" method="POST"
                        action="{{ route('hospitals.update', $hospital->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hospital Image -->
                        <div class="col-12">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ $hospital->image ? Storage::url($hospital->image) : asset('assets/img/icons/hospital-default.png') }}"
                                    alt="hospital-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span
                                            class="d-none d-sm-block">{{ __('medical::messages.hospitals.field.upload_image') }}</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" name="image"
                                            class="hospital-file-input d-none" accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary hospital-image-reset mb-3">
                                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">{{ __('messages.button.reset') }}</span>
                                    </button>
                                    <div class="text-muted">{{ __('medical::messages.hospitals.info.upload_image') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_en">{{ __('medical::messages.hospitals.field.label_name_en') }}</label>
                            <input type="text" id="name_en" class="form-control" name="name_en"
                                value="{{ $hospital->name_en }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_name_en') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name_ar">{{ __('medical::messages.hospitals.field.label_name_ar') }}</label>
                            <input type="text" id="name_ar" class="form-control" name="name_ar"
                                value="{{ $hospital->name_ar }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_name_ar') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="email">{{ __('medical::messages.hospitals.field.label_email') }}</label>
                            <input type="email" id="email" class="form-control" name="email"
                                value="{{ $hospital->email }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_email') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="website">{{ __('medical::messages.hospitals.field.label_website') }}</label>
                            <input type="url" id="website" class="form-control" name="website"
                                value="{{ $hospital->website }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_website') }}" />
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"
                                for="city_id">{{ __('medical::messages.hospitals.field.label_city') }}</label>
                            <select id="city_id" class="select2 form-select" name="city_id" data-allow-clear="true">
                                <option value="">{{ __('medical::messages.hospitals.field.placeholder_city') }}
                                </option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $hospital->city_id == $city->id ? 'selected' : '' }}>
                                        {{ $city->name_en }} - {{ $city->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"
                                for="user_id">{{ __('medical::messages.hospitals.field.label_hospital_user') }}</label>
                            <select id="user_id" class="select2 form-select" name="user_id" data-allow-clear="true">
                                <option value="">
                                    {{ __('medical::messages.hospitals.field.placeholder_hospital_user') }}</option>
                                @foreach ($hospitalUsers as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $hospital->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="address_en">{{ __('medical::messages.hospitals.field.label_address_en') }}</label>
                            <textarea id="address_en" class="form-control" name="address_en"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_address_en') }}">{{ $hospital->address_en }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="address_ar">{{ __('medical::messages.hospitals.field.label_address_ar') }}</label>
                            <textarea id="address_ar" class="form-control" name="address_ar"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_address_ar') }}">{{ $hospital->address_ar }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="contact_en">{{ __('medical::messages.hospitals.field.label_contact_en') }}</label>
                            <input type="text" id="contact_en" class="form-control" name="contact_en"
                                value="{{ $hospital->contact_en }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_contact_en') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="contact_ar">{{ __('medical::messages.hospitals.field.label_contact_ar') }}</label>
                            <input type="text" id="contact_ar" class="form-control" name="contact_ar"
                                value="{{ $hospital->contact_ar }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_contact_ar') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="working_hours_en">{{ __('medical::messages.hospitals.field.label_working_hours_en') }}</label>
                            <input type="text" id="working_hours_en" class="form-control" name="working_hours_en"
                                value="{{ $hospital->working_hours_en }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_working_hours_en') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="working_hours_ar">{{ __('medical::messages.hospitals.field.label_working_hours_ar') }}</label>
                            <input type="text" id="working_hours_ar" class="form-control" name="working_hours_ar"
                                value="{{ $hospital->working_hours_ar }}"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_working_hours_ar') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="description_en">{{ __('medical::messages.hospitals.field.label_description_en') }}</label>
                            <textarea id="description_en" class="form-control" name="description_en"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_description_en') }}">{{ $hospital->description_en }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="description_ar">{{ __('medical::messages.hospitals.field.label_description_ar') }}</label>
                            <textarea id="description_ar" class="form-control" name="description_ar"
                                placeholder="{{ __('medical::messages.hospitals.field.placeholder_description_ar') }}">{{ $hospital->description_ar }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"
                                for="specializations">{{ __('medical::messages.hospitals.field.label_specializations') }}</label>
                            <div class="specializations-container">
                                <select id="specializations" class="select2 form-select" name="specializations[]"
                                    multiple data-allow-clear="true">
                                    @foreach (\Modules\Medical\Models\Specialization::all() as $specialization)
                                        <option value="{{ $specialization->id }}"
                                            {{ $hospital->specializations->contains('id', $specialization->id) ? 'selected' : '' }}
                                            data-booking-limit="{{ $hospital->specializations->where('id', $specialization->id)->first() ? $hospital->specializations->where('id', $specialization->id)->first()->pivot->booking_limit : 40 }}">
                                            {{ $specialization->name_en }} - {{ $specialization->name_ar }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3" id="booking-limits-container">
                                @foreach ($hospital->specializations as $specialization)
                                    <div class="mb-2 booking-limit-item"
                                        data-specialization-id="{{ $specialization->id }}">
                                        <label class="form-label">{{ $specialization->name_en }} -
                                            {{ $specialization->name_ar }}
                                            {{ __('medical::messages.hospitals.field.label_booking_limit') }}</label>
                                        <input type="number" class="form-control"
                                            name="booking_limit[{{ $specialization->id }}]"
                                            value="{{ $specialization->pivot->booking_limit }}" min="1"
                                            placeholder="40">
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3" id="working-days-container">
                                @foreach ($hospital->specializations as $specialization)
                                    <div class="mb-3 working-days-item"
                                        data-specialization-id="{{ $specialization->id }}">
                                        <label class="form-label">{{ $specialization->name_en }} -
                                            {{ $specialization->name_ar }}
                                            Working Days - أيام العمل</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            @php
                                                // Store the working days data in a data attribute for JavaScript to use
                                                $workingDaysRaw = $specialization->pivot->working_days ?? '[]';
                                                $workingDays = json_decode($workingDaysRaw);
                                                $workingDays = is_array($workingDays) ? $workingDays : [];
                                            @endphp
                                            <div class="working-days-data"
                                                data-specialization-id="{{ $specialization->id }}"
                                                data-working-days="{{ json_encode($workingDays) }}"></div>
                                            @foreach (\Modules\Medical\Enums\Day::options() as $value => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="day_{{ $specialization->id }}_{{ $value }}"
                                                        name="working_days[{{ $specialization->id }}][]"
                                                        value="{{ $value }}"
                                                        {{ in_array($value, $workingDays) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="day_{{ $specialization->id }}_{{ $value }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label"
                                for="facilities">{{ __('medical::messages.hospitals.field.label_facilities') }}</label>
                            <select id="facilities" class="select2 form-select" name="facilities[]" multiple
                                data-allow-clear="true">
                                @foreach (\Modules\Medical\Models\Facility::all() as $facility)
                                    <option value="{{ $facility->id }}"
                                        {{ $hospital->facilities->contains('id', $facility->id) ? 'selected' : '' }}>
                                        {{ $facility->name_en }} - {{ $facility->name_ar }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch mb-2">
                                <input type="hidden" name="auto_booking" value="0">
                                <input class="form-check-input" type="checkbox" id="auto_booking" name="auto_booking"
                                    value="1" {{ $hospital->auto_booking ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="auto_booking">{{ __('medical::messages.hospitals.field.label_auto_booking') }}</label>
                            </div>
                            <small class="text-muted">{{ __('medical::messages.hospitals.info.auto_booking') }}</small>
                        </div>

                        <div class="col-12 d-flex justify-content-between">
                            <a href="{{ route('hospitals.index') }}" class="btn btn-label-secondary">
                                {{ __('messages.button.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">{{ __('messages.button.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
