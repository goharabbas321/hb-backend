<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('user::messages.users.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form id="user_form" class="row g-6 confirm-form" method="POST" action="{{ route('users.store') }}"
            enctype="multipart/form-data">
            @csrf

            <div class="col-md-6 gap-6 d-flex align-items-start align-items-sm-center mb-4">
                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                    class="rounded d-block w-px-100 h-px-100" id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="upload" class="mb-4 btn btn-primary me-3" tabindex="0">
                        <span class="d-none d-sm-block">{{ __('messages.button.upload_photo') }}</span>
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" class="account-file-input" name="profile_image" hidden
                            accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" class="mb-4 btn btn-label-secondary account-image-reset">
                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">{{ __('messages.button.reset') }}</span>
                    </button>

                    <div>{{ __('user::messages.users.info.upload_image') }}</div>
                </div>
            </div>


            <!-- Personal Info -->

            <div class="col-12">
                <h6 class="mt-2">{{ __('user::messages.users.section.personal_info') }}</h6>
                <hr class="mt-0" />
            </div>

            <div class="col-md-6">
                <label class="form-label" for="name">{{ __('user::messages.users.field.full_name') }}</label>
                <input type="text" id="name" class="form-control" placeholder="Gohar Abbas" name="name"
                    value="{{ old('name') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label" for="phone">{{ __('user::messages.users.field.phone_number') }}</label>
                <div class="input-group">
                    <input type="text" id="phone" class="form-control phone" placeholder="07754732678"
                        name="phone" maxlength="11" value="{{ old('phone') }}" />
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="country">{{ __('user::messages.users.field.country') }}</label>
                <select id="country" name="country" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                    @foreach (getCountries() as $country)
                        <option value="{{ $country }}" {{ old('country') == $country ? 'selected' : '' }}>
                            {{ $country }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label" for="address">{{ __('user::messages.users.field.address') }}</label>
                <input type="text" id="address" class="form-control" placeholder="Street No 01, House 34"
                    name="address" value="{{ old('address') }}" />
            </div>

            <!-- Patient specific fields - will be shown conditionally when patient role is selected -->
            <div class="col-md-6 patient-field">
                <label class="form-label" for="city">{{ __('City') }}</label>
                <input type="text" id="city" class="form-control" placeholder="Karbala" name="city"
                    value="{{ old('city') }}" />
            </div>

            <div class="col-md-6 patient-field">
                <label class="form-label" for="age">{{ __('Age') }}</label>
                <input type="number" id="age" class="form-control" placeholder="30" name="age"
                    value="{{ old('age') }}" min="1" max="120" />
            </div>

            <div class="col-md-6 patient-field">
                <label class="form-label" for="gender">{{ __('Gender') }}</label>
                <select id="gender" name="gender" class="form-select select2" data-allow-clear="true">
                    <option value="">Select</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="col-md-6 patient-field">
                <label class="form-label" for="emergency_contact">{{ __('Emergency Contact') }}</label>
                <input type="text" id="emergency_contact" class="form-control" placeholder="07754732678"
                    name="emergency_contact" maxlength="11" value="{{ old('emergency_contact') }}" />
            </div>

            <div class="col-12">
                <button type="submit" id="submitButton" name="submitButton"
                    class="btn btn-primary me-4">{{ __('messages.button.submit') }}</button>
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="offcanvas">{{ __('messages.button.cancel') }}</button>
            </div>
        </form>
    </div>
</div>
