@extends('layouts/layoutMaster')

@section('title', app()->getLocale() == 'ar' ? 'ملفي الشخصي' : 'My Profile')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-select-bs5/select.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/assets/js/profile/index.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#btnVerifyEmail').on('click', function() {
                $('#submitVerification').submit(); // Trigger form submission
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Account -->
            <div class="mb-6 card">
                <h5 class="card-header">{{ __('messages.profile.information.heading') }}</h5>
                <div class="pt-4 card-body">
                    <form id="submitVerification" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                    <form id="user_form" class="row g-6 confirm-form" method="POST"
                        action="{{ route('profile.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="gap-6 d-flex align-items-start align-items-sm-center">
                            <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
                                alt="user-avatar" class="rounded d-block w-px-100 h-px-100" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="upload" class="mb-4 btn btn-primary me-3" tabindex="0">
                                    <span
                                        class="d-none d-sm-block">{{ __('messages.profile.information.btn_upload') }}</span>
                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" class="account-file-input" name="profile_image"
                                        hidden accept="image/png, image/jpeg" />
                                </label>
                                <button type="button" class="mb-4 btn btn-label-secondary account-image-reset">
                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                    <span
                                        class="d-none d-sm-block">{{ __('messages.profile.information.btn_reset') }}</span>
                                </button>

                                <div>{{ __('messages.profile.information.image_info') }}</div>
                            </div>
                        </div>

                        <!-- Account Details -->

                        <div class="col-md-6">
                            <label class="form-label"
                                for="username">{{ __('messages.profile.information.username') }}</label>
                            <input type="text" id="username" class="form-control" placeholder="goharabbas"
                                name="username" value="{{ $user->username }}" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">{{ __('messages.profile.information.email') }}</label>
                            <input class="form-control" type="email" id="email" name="email"
                                placeholder="gohar@gmail.com" value="{{ $user->email }}" />
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !$user->hasVerifiedEmail())
                                <p class="mt-2 text-sm">
                                    {{ __('messages.profile.information.email_verify') }}

                                    <button id="btnVerifyEmail" type="button" class="btn btn-primary btn-sm">
                                        {{ __('messages.profile.information.email_verify_btn') }}
                                    </button>
                                </p>

                                @if ($user->verificationLinkSent)
                                    <p class="mt-2 text-sm font-medium text-green-600">
                                        {{ __('messages.profile.information.email_verify_success') }}
                                    </p>
                                @endif
                            @endif
                        </div>

                        <!-- Personal Info -->

                        <div class="col-md-6">
                            <label class="form-label"
                                for="name">{{ __('messages.profile.information.full_name') }}</label>
                            <input type="text" id="name" class="form-control" placeholder="Gohar Abbas"
                                name="name" value="{{ $user->name }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="phone">{{ __('messages.profile.information.phone_number') }}</label>
                            <div class="input-group">
                                <input type="text" id="phone" class="form-control phone" placeholder="07754732678"
                                    name="phone" maxlength="11" value="{{ $user->phone }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="country">{{ __('messages.profile.information.country') }}</label>
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
                            <label class="form-label"
                                for="address">{{ __('messages.profile.information.address') }}</label>
                            <input type="text" id="address" class="form-control" placeholder="Street No 01, House 34"
                                name="address" value="{{ getUserInformation($user, 'address') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="language">{{ __('messages.profile.information.language') }}</label>
                            <select id="language" name="language" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->code }}"
                                        {{ $user->language == $language->code ? 'selected' : '' }}>
                                        {{ __($language->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="currency">{{ __('messages.profile.information.currency') }}</label>
                            <select id="currency" name="currency" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->code }}"
                                        {{ $user->currency == $currency->code ? 'selected' : '' }}>
                                        {{ __($currency->name) }}
                                        ({{ $currency->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label"
                                for="time_zone">{{ __('messages.profile.information.time_zone') }}</label>
                            <select id="time_zone" name="time_zone" class="select2 form-select">
                                <option value="">Select</option>
                                @foreach (timezone_identifiers_list() as $timezone)
                                    @php
                                        $timezoneOffset = (new DateTimeZone($timezone))->getOffset(
                                            new DateTime('now', new DateTimeZone('UTC')),
                                        );
                                        $hours = intdiv($timezoneOffset, 3600);
                                        $minutes = ($timezoneOffset % 3600) / 60;
                                        $formattedOffset = sprintf(
                                            'UTC %s%02d:%02d',
                                            $timezoneOffset >= 0 ? '+' : '-',
                                            abs($hours),
                                            abs($minutes),
                                        );
                                    @endphp
                                    <option value="{{ $timezone }}"
                                        {{ $user->time_zone == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }} ({{ $formattedOffset }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <button type="submit" id="submitButton" name="submitButton"
                                class="btn btn-primary me-4">{{ __('messages.profile.information.btn_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Account -->

            <!-- Change Password -->
            <div class="mb-6 card">
                <h5 class="card-header">{{ __('messages.profile.change_password.heading') }}</h5>
                <div class="pt-1 card-body">
                    <form id="formAccountSettings" method="POST"
                        action="{{ route('profile.change_password', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-6 col-md-6 form-password-toggle">
                                <label class="form-label"
                                    for="currentPassword">{{ __('messages.profile.change_password.current_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="currentPassword"
                                        id="currentPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-6 col-md-6 form-password-toggle">
                                <label class="form-label"
                                    for="newPassword">{{ __('messages.profile.change_password.new_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" id="newPassword" name="newPassword"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-6 col-md-6 form-password-toggle">
                                <label class="form-label"
                                    for="newPassword_confirmation">{{ __('messages.profile.change_password.confirm_password') }}</label>
                                <div class="input-group input-group-merge">
                                    <input class="form-control" type="password" name="newPassword_confirmation"
                                        id="newPassword_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="cursor-pointer input-group-text"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-body">{{ __('messages.profile.change_password.requirements.title') }}</h6>
                        <ul class="mb-0 ps-4">
                            <li class="mb-4">{{ __('messages.profile.change_password.requirements.step1') }}</li>
                            <li class="mb-4">{{ __('messages.profile.change_password.requirements.step2') }}</li>
                            <li>{{ __('messages.profile.change_password.requirements.step3') }}</li>
                        </ul>
                        <div class="mt-6">
                            <button type="submit"
                                class="btn btn-primary me-3">{{ __('messages.profile.change_password.btn_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ Change Password -->

            <!-- Two-steps verification -->
            <div class="mb-6 card">
                <div class="card-body">
                    <h5 class="mb-6">{{ __('messages.profile.2fa.heading') }}</h5>
                    @if (!$user->two_factor_confirmed_at)
                        <h5 class="mb-4 text-muted">{{ __('messages.profile.2fa.status_enable') }}</h5>
                        <p class="mb-4 w-75">
                            {{ __('messages.profile.2fa.sub_heading') }}
                        </p>
                        <div class="mb-4">
                            <p>{{ __('messages.profile.2fa.qr_enable') }}</p>
                            <div class="d-flex justify-content-center">
                                {!! $qrCode !!}
                            </div>
                        </div>
                        <form id="otp_enable" method="POST" action="{{ route('two-factor.enable') }}">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="otp"
                                    class="form-label">{{ __('messages.profile.2fa.label_otp') }}</label>
                                <input type="text" id="otp" name="otp" class="form-control" maxlength="6"
                                    required placeholder="{{ __('messages.profile.2fa.placeholder_otp') }}">
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-100">{{ __('messages.profile.2fa.btn_enable') }}</button>
                        </form>
                    @else
                        <h5 class="mb-4 text-muted">{{ __('messages.profile.2fa.status_disable') }}</h5>
                        <h5 class="mb-4 text-body">{{ __('messages.profile.2fa.recovery_codes') }}</h5>
                        <ul>
                            @foreach (json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                                <li>{{ $code }}</li>
                            @endforeach
                        </ul>

                        <form id="otp_disable" method="POST" action="{{ route('two-factor.disable') }}">
                            @csrf
                            <div class="col-md-12 mb-3">
                                <label for="password"
                                    class="form-label">{{ __('messages.profile.2fa.label_confirm_password') }}</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="{{ __('messages.profile.2fa.placeholder_confirm_password') }}" required>
                            </div>
                            <button type="submit"
                                class="btn btn-danger w-100">{{ __('messages.profile.2fa.btn_disable') }}</button>
                        </form>
                    @endif
                </div>
            </div>
            <!--/ Two-steps verification -->

            <!-- Recent Devices -->
            <div class="mb-6 card">
                <h5 class="card-header">{{ __('messages.profile.recent_devices.heading') }}</h5>
                <div class="p-4 table-responsive">
                    <table class="table dt-table">
                        <thead>
                            <tr>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.device') }}</th>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.platform') }}</th>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.browser') }}</th>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.ip_address') }}
                                </th>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.location') }}</th>
                                <th class="text-truncate">{{ __('messages.profile.recent_devices.table.is_robot') }}</th>
                                <th class="text-truncate">
                                    {{ __('messages.profile.recent_devices.table.recent_activities') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                                <tr class="{{ $session->id === $currentSessionId ? 'table-primary' : '' }}">
                                    <td class="text-truncate text-heading fw-medium">{{ $session->device }}</td>
                                    <td class="text-truncate">{{ $session->platform }} - {{ $session->platform_version }}
                                    </td>
                                    <td class="text-truncate">{{ $session->browser }} - {{ $session->browser_version }}
                                    </td>
                                    <td class="text-truncate">{{ $session->ip_address }}</td>
                                    <td class="text-truncate">{{ $session->location }}</td>
                                    <td class="text-truncate">{{ $session->is_robot ? 'Yes' : 'No' }}</td>
                                    <td class="text-truncate">{{ $session->last_active }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Recent Devices -->

            <!-- Logout Other Browser Sessions -->
            <div class="mb-6 card">
                <div class="card-body">
                    <h5 class="mb-6">{{ __('messages.profile.sessions.heading') }}</h5>
                    <p class="mb-4 w-75">
                        {{ __('messages.profile.sessions.sub_heading') }}
                    </p>
                    <form id="session_form" method="POST" action="{{ route('profile.logout-other-sessions') }}">
                        @csrf
                        @method('DELETE')
                        <div class="col-md-12 mb-3">
                            <label for="password"
                                class="form-label">{{ __('messages.profile.sessions.label_confirm_password') }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="{{ __('messages.profile.sessions.placeholder_confirm_password') }}" required>
                        </div>
                        <button type="submit"
                            class="btn btn-danger w-100">{{ __('messages.profile.sessions.btn_submit') }}</button>
                    </form>
                </div>
            </div>
            <!--/ Logout Other Browser Sessions -->
        </div>
    </div>

@endsection
