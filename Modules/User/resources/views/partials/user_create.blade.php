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

            <!-- Account Details -->

            <div class="col-12 mt-4">
                <h6>{{ __('user::messages.users.section.account_details') }}</h6>
                <hr class="mt-0" />
            </div>


            <div class="col-md-6">
                <label class="form-label" for="username">{{ __('user::messages.users.field.username') }}</label>
                <input type="text" id="username" class="form-control" placeholder="goharabbas" name="username"
                    value="{{ old('username') }}" />
            </div>
            <div class="col-md-6">
                <label class="form-label" for="email">{{ __('user::messages.users.field.email') }}</label>
                <input class="form-control" type="email" id="email" name="email" placeholder="gohar@gmail.com"
                    value="{{ old('email') }}" />
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

            <div class="col-md-6">
                <label class="form-label" for="language">{{ __('user::messages.users.field.language') }}</label>
                <select id="language" name="language" class="select2 form-select">
                    <option value="">Select</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->code }}"
                            {{ old('language') == $language->code ? 'selected' : '' }}>{{ __($language->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label">{{ __('user::messages.users.field.role') }}</label>
                <select id="role" name="role" class="select2 form-select">
                    <option value="">Select Role</option>
                    @foreach (Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ __($role->name) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
