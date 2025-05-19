<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('medical::messages.doctors.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <!-- Add doctor form -->
        <form id="doctor_form" class="row g-3" method="POST" action="{{ route('doctors.store') }}"
            enctype="multipart/form-data">
            @csrf
            <!-- Doctor Profile Picture -->
            <div class="col-12">
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="doctor-avatar"
                        class="d-block w-px-100 h-px-100 rounded" id="uploadedImage" />
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                            <span
                                class="d-none d-sm-block">{{ __('medical::messages.doctors.field.upload_image') }}</span>
                            <i class="ti ti-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="profile_picture" class="doctor-file-input d-none"
                                accept="image/png, image/jpeg" />
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
                    placeholder="{{ __('medical::messages.doctors.field.placeholder_name_en') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="name_ar">{{ __('medical::messages.doctors.field.label_name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="{{ __('medical::messages.doctors.field.placeholder_name_ar') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="hospital_id">{{ __('medical::messages.doctors.field.label_hospital') }}</label>
                <select id="hospital_id" class="select2 form-select" name="hospital_id" data-allow-clear="true">
                    <option value="">{{ __('medical::messages.doctors.field.placeholder_hospital') }}</option>
                    @foreach (\Modules\Medical\Models\Hospital::all() as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name_en }} - {{ $hospital->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="specialization_id">{{ __('medical::messages.doctors.field.label_specialization') }}</label>
                <select id="specialization_id" class="select2 form-select" name="specialization_id"
                    data-allow-clear="true">
                    <option value="">{{ __('medical::messages.doctors.field.placeholder_specialization') }}
                    </option>
                    @foreach (\Modules\Medical\Models\Specialization::all() as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name_en }} -
                            {{ $specialization->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="bio_en">{{ __('medical::messages.doctors.field.label_bio_en') }}</label>
                <textarea id="bio_en" class="form-control" name="bio_en"
                    placeholder="{{ __('medical::messages.doctors.field.placeholder_bio_en') }}"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="bio_ar">{{ __('medical::messages.doctors.field.label_bio_ar') }}</label>
                <textarea id="bio_ar" class="form-control" name="bio_ar"
                    placeholder="{{ __('medical::messages.doctors.field.placeholder_bio_ar') }}"></textarea>
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
