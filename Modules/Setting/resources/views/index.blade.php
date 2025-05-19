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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['Modules/Setting/resources/assets/js/app.js'])
    <script>
        window.translations = @json(__('setting::messages'));
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            // Load bootstrap-toggle script dynamically after the page loads
            var toggleScript = document.createElement('script');
            toggleScript.src = "https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js";
            toggleScript.onload = function() {
                console.log('Bootstrap Toggle loaded successfully!');
            };
            document.body.appendChild(toggleScript);
        });
    </script>
    <script>
        window.StoreURL = "{{ route('settings.backups.index') }}";
        window.Token = "{{ csrf_token() }}";
    </script>
@endsection

@section('content')
    <div class="row g-6">
        @include('setting::partials.nav')

        <!-- Options -->
        <div class="col-12 col-lg-8 pt-6 pt-lg-0">

            <div class="tab-content p-0">
                <!-- Store Details Tab -->
                <div class="tab-pane fade show active" id="general_settings">
                    <form id="settingsForm" method="POST" action="{{ route('settings.update') }}"
                        enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="card mb-6">
                            <div class="card-header">
                                <h5 class="card-title m-0">{{ __($page_title) }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-6 g-6">
                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="name">{{ __('setting::messages.settings.general_settings.name') }}</label>
                                        <input type="text" class="form-control" id="name" placeholder="GMS"
                                            name="name" value="{{ $general_settings->name }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="name_ar">{{ __('setting::messages.settings.general_settings.name_ar') }}</label>
                                        <input type="text" class="form-control" id="name_ar"
                                            placeholder="نظام إدارة جوهر" name="name_ar"
                                            value="{{ $general_settings->name_ar }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="title">{{ __('setting::messages.settings.general_settings.title') }}</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="{{ __('setting::messages.settings.general_settings.title') }}"
                                            name="title" value="{{ $general_settings->title }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="title_ar">{{ __('setting::messages.settings.general_settings.title_ar') }}</label>
                                        <input type="text" class="form-control" id="title_ar"
                                            placeholder="{{ __('setting::messages.settings.general_settings.title_ar') }}"
                                            name="title_ar" value="{{ $general_settings->title_ar }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="description">{{ __('setting::messages.settings.general_settings.description') }}</label>
                                        <textarea class="form-control" id="description"
                                            placeholder="{{ __('setting::messages.settings.general_settings.description') }}" name="description"
                                            rows="3">{{ $general_settings->description }}</textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="description_ar">{{ __('setting::messages.settings.general_settings.description_ar') }}</label>
                                        <textarea class="form-control" id="description_ar"
                                            placeholder="{{ __('setting::messages.settings.general_settings.description_ar') }}" name="description_ar"
                                            rows="3">{{ $general_settings->description_ar }}</textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="keywords">{{ __('setting::messages.settings.general_settings.keywords') }}</label>
                                        <textarea class="form-control" id="keywords"
                                            placeholder="{{ __('setting::messages.settings.general_settings.keywords') }}" name="keywords" rows="3">{{ $general_settings->keywords }}</textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="keywords_ar">{{ __('setting::messages.settings.general_settings.keywords_ar') }}</label>
                                        <textarea class="form-control" id="keywords_ar"
                                            placeholder="{{ __('setting::messages.settings.general_settings.keywords_ar') }}" name="keywords_ar"
                                            rows="3">{{ $general_settings->keywords_ar }}</textarea>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="address">{{ __('setting::messages.settings.general_settings.address') }}</label>
                                        <input type="text" class="form-control" id="address"
                                            placeholder="Karbala, Iraq" name="address"
                                            value="{{ $general_settings->address }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="address_ar">{{ __('setting::messages.settings.general_settings.address_ar') }}</label>
                                        <input type="text" class="form-control" id="address_ar"
                                            placeholder="كربلاء، العراق" name="address_ar"
                                            value="{{ $general_settings->address_ar }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label"
                                            for="country">{{ __('setting::messages.settings.general_settings.country') }}</label>
                                        <select id="country" name="country" class="form-select select2">
                                            <option value="" selected disabled>
                                                {{ __('setting::messages.settings.general_settings.country_select') }}
                                            </option>
                                            @foreach (getCountries() as $country)
                                                <option value="{{ $country }}"
                                                    {{ $general_settings->country == $country ? 'selected' : '' }}>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label"
                                            for="time_zone">{{ __('setting::messages.settings.general_settings.timezone') }}</label>
                                        <select id="time_zone" name="time_zone" class="select2 form-select">
                                            <option value="" selected disabled>
                                                {{ __('setting::messages.settings.general_settings.timezone_select') }}
                                            </option>
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
                                                    {{ $general_settings->time_zone == $timezone ? 'selected' : '' }}>
                                                    {{ $timezone }} ({{ $formattedOffset }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label class="form-label"
                                            for="date_format">{{ __('setting::messages.settings.general_settings.date_format') }}</label>
                                        <select id="date_format" name="date_format" class="form-select select2">
                                            <option value="" disabled
                                                {{ empty($general_settings->date_format) ? 'selected' : '' }}>
                                                {{ __('setting::messages.settings.general_settings.date_format_select') }}
                                            </option>
                                            @foreach (getDateFormats() as $format => $formatted)
                                                <option value="{{ $format }}"
                                                    {{ $general_settings->date_format == $format ? 'selected' : '' }}>
                                                    {{ $format }} - {{ $formatted }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label"
                                            for="time_format">{{ __('setting::messages.settings.general_settings.time_format') }}</label>
                                        <select id="time_format" name="time_format" class="form-select select2">
                                            <option value="" disabled
                                                {{ empty($general_settings->time_format) ? 'selected' : '' }}>
                                                {{ __('setting::messages.settings.general_settings.time_format') }}
                                            </option>
                                            @foreach (getTimeFormats() as $format => $formatted)
                                                <option value="{{ $format }}"
                                                    {{ $general_settings->time_format == $format ? 'selected' : '' }}>
                                                    {{ $format }} - {{ $formatted }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="email">{{ __('setting::messages.settings.general_settings.email') }}</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="admin@system.com" name="email"
                                            value="{{ $general_settings->email }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label mb-1"
                                            for="phone">{{ __('setting::messages.settings.general_settings.phone_number') }}</label>
                                        <input type="text" class="form-control" id="phone"
                                            placeholder="07751345643" name="phone"
                                            value="{{ $general_settings->phone }}" />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label"
                                            for="language">{{ __('setting::messages.settings.general_settings.language') }}</label>
                                        <select id="language" name="language" class="select2 form-select">
                                            <option value="" disabled>
                                                {{ __('setting::messages.settings.general_settings.language') }}
                                            </option>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->code }}"
                                                    {{ $general_settings->language == $language->code ? 'selected' : '' }}>
                                                    {{ __($language->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label"
                                            for="currency">{{ __('setting::messages.settings.general_settings.currency') }}</label>
                                        <select id="currency" name="currency" class="select2 form-select">
                                            <option value="" disabled>
                                                {{ __('setting::messages.settings.general_settings.currency') }}
                                            </option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->code }}"
                                                    {{ $general_settings->currency == $currency->code ? 'selected' : '' }}>
                                                    {{ __($currency->name) }}
                                                    ({{ $currency->symbol }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="form-label mb-1"
                                            for="favicon">{{ __('setting::messages.settings.general_settings.favicon') }}</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="favicon" name="favicon" />
                                            <a class="btn btn-outline-primary waves-effect"><img
                                                    src="{{ asset('/storage/' . $general_settings->favicon) }}"
                                                    alt="Favicon" width="20px" /></a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="form-label mb-1"
                                            for="logo">{{ __('setting::messages.settings.general_settings.logo_light') }}</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="logo_light"
                                                name="logo_light" />
                                            <a class="btn btn-outline-primary waves-effect"><img
                                                    src="{{ asset('/storage/' . $general_settings->logo_light) }}"
                                                    alt="logo_light" width="20px" height="20px" /></a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-4">
                                        <label class="form-label mb-1"
                                            for="logo">{{ __('setting::messages.settings.general_settings.logo_dark') }}</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="logo_dark"
                                                name="logo_dark" />
                                            <a class="btn btn-outline-primary waves-effect"><img
                                                    src="{{ asset('/storage/' . $general_settings->logo_dark) }}"
                                                    alt="logo_dark" width="20px" height="20px" /></a>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label
                                            class="form-label mb-2">{{ __('setting::messages.settings.general_settings.front_page') }}</label>
                                        <div class="form-group">
                                            <input type="checkbox" class="toggle-button" data-toggle="toggle"
                                                data-on="{{ __('setting::messages.settings.general_settings.enable') }}"
                                                data-off="{{ __('setting::messages.settings.general_settings.disable') }}"
                                                data-onstyle="success" data-offstyle="danger" data-size="medium"
                                                data-width="100%" name="frontend_view"
                                                @if ($general_settings->frontend_view) checked @endif />
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label
                                            class="form-label mb-2">{{ __('setting::messages.settings.general_settings.registration_page') }}</label>
                                        <div class="form-group">
                                            <input type="checkbox" class="toggle-button" data-toggle="toggle"
                                                data-on="{{ __('setting::messages.settings.general_settings.enable') }}"
                                                data-off="{{ __('setting::messages.settings.general_settings.disable') }}"
                                                data-onstyle="success" data-offstyle="danger" data-size="medium"
                                                data-width="100%" name="registration"
                                                @if ($general_settings->registration) checked @endif />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-4">
                            <a class="btn btn-label-secondary"
                                href="{{ route('dashboard') }}">{{ __('setting::messages.settings.general_settings.btn_cancel') }}</a>
                            <button type="submit"
                                class="btn btn-primary">{{ __('setting::messages.settings.general_settings.btn_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /Options-->
    </div>

@endsection
