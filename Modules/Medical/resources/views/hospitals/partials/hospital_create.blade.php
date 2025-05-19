<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('medical::messages.hospitals.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <!-- Add hospital form -->
        <form id="hospital_form" class="row g-3" method="POST" action="{{ route('hospitals.store') }}"
            enctype="multipart/form-data">
            @csrf
            <!-- Hospital Image -->
            <div class="col-12">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="hospital-avatar"
                        class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span
                                class="d-none d-sm-block">{{ __('medical::messages.hospitals.field.upload_image') }}</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="image" class="hospital-file-input d-none"
                                accept="image/png, image/jpeg" />
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
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_name_en') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="name_ar">{{ __('medical::messages.hospitals.field.label_name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_name_ar') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="email">{{ __('medical::messages.hospitals.field.label_email') }}</label>
                <input type="email" id="email" class="form-control" name="email"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_email') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="website">{{ __('medical::messages.hospitals.field.label_website') }}</label>
                <input type="url" id="website" class="form-control" name="website"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_website') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="city_id">{{ __('medical::messages.hospitals.field.label_city') }}</label>
                <select id="city_id" class="select2 form-select" name="city_id" data-allow-clear="true">
                    <option value="">{{ __('medical::messages.hospitals.field.placeholder_city') }}</option>
                    @foreach (\Modules\Medical\Models\City::all() as $city)
                        <option value="{{ $city->id }}">{{ $city->name_en }} - {{ $city->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="user_id">{{ __('medical::messages.hospitals.field.label_hospital_user') }}</label>
                <select id="user_id" class="select2 form-select" name="user_id" data-allow-clear="true">
                    <option value="">{{ __('medical::messages.hospitals.field.placeholder_hospital_user') }}
                    </option>
                    @foreach (\App\Models\User::role('hospital')->get() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="address_en">{{ __('medical::messages.hospitals.field.label_address_en') }}</label>
                <textarea id="address_en" class="form-control" name="address_en"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_address_en') }}"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="address_ar">{{ __('medical::messages.hospitals.field.label_address_ar') }}</label>
                <textarea id="address_ar" class="form-control" name="address_ar"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_address_ar') }}"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="contact_en">{{ __('medical::messages.hospitals.field.label_contact_en') }}</label>
                <input type="text" id="contact_en" class="form-control" name="contact_en"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_contact_en') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="contact_ar">{{ __('medical::messages.hospitals.field.label_contact_ar') }}</label>
                <input type="text" id="contact_ar" class="form-control" name="contact_ar"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_contact_ar') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="working_hours_en">{{ __('medical::messages.hospitals.field.label_working_hours_en') }}</label>
                <input type="text" id="working_hours_en" class="form-control" name="working_hours_en"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_working_hours_en') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="working_hours_ar">{{ __('medical::messages.hospitals.field.label_working_hours_ar') }}</label>
                <input type="text" id="working_hours_ar" class="form-control" name="working_hours_ar"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_working_hours_ar') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="description_en">{{ __('medical::messages.hospitals.field.label_description_en') }}</label>
                <textarea id="description_en" class="form-control" name="description_en"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_description_en') }}"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="description_ar">{{ __('medical::messages.hospitals.field.label_description_ar') }}</label>
                <textarea id="description_ar" class="form-control" name="description_ar"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_description_ar') }}"></textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label"
                    for="specializations">{{ __('medical::messages.hospitals.field.label_specializations') }}</label>
                <div class="specializations-container">
                    <select id="specializations" class="select2 form-select" name="specializations[]" multiple
                        data-allow-clear="true">
                        @foreach (\Modules\Medical\Models\Specialization::all() as $specialization)
                            <option value="{{ $specialization->id }}" data-booking-limit="40">
                                {{ $specialization->name_en }} -
                                {{ $specialization->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3" id="booking-limits-container">
                    <!-- Booking limit fields will be added here dynamically -->
                </div>
                <div class="mt-3" id="working-days-container">
                    <!-- Working days fields will be added here dynamically -->
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label"
                    for="facilities">{{ __('medical::messages.hospitals.field.label_facilities') }}</label>
                <select id="facilities" class="select2 form-select" name="facilities[]" multiple
                    data-allow-clear="true">
                    @foreach (\Modules\Medical\Models\Facility::all() as $facility)
                        <option value="{{ $facility->id }}">{{ $facility->name_en }} - {{ $facility->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12">
                <div class="form-check form-switch mb-2">
                    <input type="hidden" name="auto_booking" value="0">
                    <input class="form-check-input" type="checkbox" id="auto_booking" name="auto_booking"
                        value="1" checked>
                    <label class="form-check-label"
                        for="auto_booking">{{ __('medical::messages.hospitals.field.label_auto_booking') }}</label>
                </div>
                <small class="text-muted">{{ __('medical::messages.hospitals.info.auto_booking') }}</small>
            </div>

            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
                    {{ __('messages.button.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary">{{ __('messages.button.submit') }}</button>
            </div>
        </form>
    </div>
</div>
