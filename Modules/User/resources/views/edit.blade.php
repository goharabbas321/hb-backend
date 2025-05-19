@extends('layouts/layoutMaster')

@section('title', __($page_title))

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss',
        'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
        'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
        'resources/assets/vendor/libs/tagify/tagify.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss',
        'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.scss',
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['Modules/User/resources/assets/js/app.js'])
    <script>
        window.BulkURL = "{{ route('users.bulk_action') }}";
        window.Token = "{{ csrf_token() }}";
        window.translations = @json(__('user::messages'));
    </script>
@endsection

@section('content')
    <div class="card" id="add-new-record">
        <div class="card-header border-bottom">
            <h5 class="card-title" id="exampleModalLabel">{{ __('user::messages.users.heading.edit') }}</h5>
        </div>
        <div class="card-body">
            <form id="user_form" class="row g-6 confirm-form mt-4" method="POST" action="{{ route('users.update', $user) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="col-md-6 gap-6 d-flex align-items-start align-items-sm-center mb-4">
                    <img src="{{ $user->profile_photo_url ? $user->profile_photo_url : asset('assets/img/avatars/1.png') }}"
                        alt="user-avatar" class="rounded d-block w-px-100 h-px-100" id="uploadedAvatar" />
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

                @role('super_admin')
                    <!-- Account Details -->

                    <div class="col-12 mt-4">
                        <h6>{{ __('user::messages.users.section.account_details') }}</h6>
                        <hr class="mt-0" />
                    </div>


                    <div class="col-md-6">
                        <label class="form-label" for="username">{{ __('user::messages.users.field.username') }}</label>
                        <input type="text" id="username" class="form-control" placeholder="goharabbas" name="username"
                            value="{{ $user->username }}" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">{{ __('user::messages.users.field.email') }}</label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="gohar@gmail.com"
                            value="{{ $user->email }}" />
                    </div>

                    <div class="col-md-6">
                        <div class="form-password-toggle">
                            <label class="form-label" for="password">{{ __('user::messages.users.field.password') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" id="password" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-password2" />
                                <span class="cursor-pointer input-group-text" id="multicol-password2"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-password-toggle">
                            <label class="form-label"
                                for="password_confirmation">{{ __('user::messages.users.field.confirm_password') }}</label>
                            <div class="input-group input-group-merge">
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="multicol-confirm-password2" />
                                <span class="cursor-pointer input-group-text" id="multicol-confirm-password2"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                    </div>
                @endrole

                <!-- Personal Info -->

                <div class="col-12">
                    <h6 class="mt-2">{{ __('user::messages.users.section.personal_info') }}</h6>
                    <hr class="mt-0" />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="name">{{ __('user::messages.users.field.full_name') }}</label>
                    <input type="text" id="name" class="form-control" placeholder="Gohar Abbas" name="name"
                        value="{{ $user->name }}" />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="phone">{{ __('user::messages.users.field.phone_number') }}</label>
                    <div class="input-group">
                        <input type="text" id="phone" class="form-control phone" placeholder="07754732678"
                            name="phone" maxlength="11" value="{{ $user->phone }}" />
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="country">{{ __('user::messages.users.field.country') }}</label>
                    <select id="country" name="country" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        @foreach (getCountries() as $country)
                            <option value="{{ $country }}"
                                {{ getUserInformation($user, 'country') == $country ? 'selected' : '' }}>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="address">{{ __('user::messages.users.field.address') }}</label>
                    <input type="text" id="address" class="form-control" placeholder="Street No 01, House 34"
                        name="address" value="{{ getUserInformation($user, 'address') }}" />
                </div>

                <!-- Patient specific fields - will be shown conditionally when patient role is selected -->
                <div class="col-md-6 patient-field" style="{{ $user->hasRole('patient') ? '' : 'display: none;' }}">
                    <label class="form-label" for="city">{{ __('City') }}</label>
                    <input type="text" id="city" class="form-control" placeholder="Karbala" name="city"
                        value="{{ getUserInformation($user, 'city') }}" />
                </div>

                <div class="col-md-6 patient-field" style="{{ $user->hasRole('patient') ? '' : 'display: none;' }}">
                    <label class="form-label" for="age">{{ __('Age') }}</label>
                    <input type="number" id="age" class="form-control" placeholder="30" name="age"
                        value="{{ getUserInformation($user, 'age') }}" min="1" max="120" />
                </div>

                <div class="col-md-6 patient-field" style="{{ $user->hasRole('patient') ? '' : 'display: none;' }}">
                    <label class="form-label" for="gender">{{ __('Gender') }}</label>
                    <select id="gender" name="gender" class="form-select select2" data-allow-clear="true">
                        <option value="">Select</option>
                        <option value="Male" {{ getUserInformation($user, 'gender') == 'Male' ? 'selected' : '' }}>Male
                        </option>
                        <option value="Female" {{ getUserInformation($user, 'gender') == 'Female' ? 'selected' : '' }}>
                            Female</option>
                        <option value="Other" {{ getUserInformation($user, 'gender') == 'Other' ? 'selected' : '' }}>
                            Other</option>
                    </select>
                </div>

                <div class="col-md-6 patient-field" style="{{ $user->hasRole('patient') ? '' : 'display: none;' }}">
                    <label class="form-label" for="emergency_contact">{{ __('Emergency Contact') }}</label>
                    <input type="text" id="emergency_contact" class="form-control" placeholder="07754732678"
                        name="emergency_contact" maxlength="11"
                        value="{{ getUserInformation($user, 'emergency_contact') }}" />
                </div>

                @role('super_admin')
                    <div class="col-md-6">
                        <label class="form-label" for="language">{{ __('user::messages.users.field.language') }}</label>
                        <select id="language" name="language" class="select2 form-select">
                            <option value="">Select</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->code }}"
                                    {{ $user->language == $language->code ? 'selected' : '' }}>{{ __($language->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">{{ __('user::messages.users.field.role') }}</label>
                        <select id="role" name="role" class="select2 form-select">
                            <option value="">Select Role</option>
                            @foreach (Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->roles->pluck('name')[0] == $role->name ? 'selected' : '' }}>
                                    {{ __($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endrole

                <div class="col-12">
                    <button type="submit" id="submitButton" name="submitButton"
                        class="btn btn-primary me-4">{{ __('messages.button.submit') }}</button>
                    <button type="button" class="btn btn-outline-secondary"
                        onclick="window.history.back();">{{ __('messages.button.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add JavaScript to show/hide patient fields based on role selection -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const patientFields = document.querySelectorAll('.patient-field');

            // Listen for changes on the role dropdown
            roleSelect.addEventListener('change', togglePatientFields);

            function togglePatientFields() {
                // Check if the selected role is 'patient'
                const isPatient = roleSelect.value === 'patient';

                // Show or hide patient-specific fields
                patientFields.forEach(field => {
                    field.style.display = isPatient ? 'block' : 'none';
                });
            }
        });
    </script>
@endsection
