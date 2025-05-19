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
    <style>
        thead {
            background: #eaeaea;
        }

        th {
            font-weight: 600 !important;
            text-align: center !important;
        }

        td {
            text-align: center !important;
        }
    </style>
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
                <div class="tab-pane fade show active" id="modules">
                    <div class="card">
                        <h5 class="card-header">{{ __('setting::messages.settings.modules.heading') }}</h5>
                        <div class="p-4 table-responsive">
                            <table class="table dt-table">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">{{ __('messages.table.id') }}</th>
                                        <th class="text-truncate">{{ __('setting::messages.settings.modules.table.name') }}
                                        </th>
                                        <th class="text-truncate">
                                            {{ __('setting::messages.settings.modules.table.status') }}</th>
                                        <th class="text-truncate">
                                            {{ __('setting::messages.settings.modules.table.priority') }}
                                        </th>
                                        <th class="text-truncate">
                                            {{ __('setting::messages.settings.modules.table.description') }}
                                        </th>
                                        <th class="text-truncate">{{ __('messages.table.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($moduleInfo as $key => $module)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-truncate text-heading fw-medium">{{ $module['name'] }}</td>
                                            <td class="text-truncate">
                                                @if ($module['enabled'] == 'Enabled')
                                                    <span class="badge bg-success">{{ __($module['enabled']) }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ __($module['enabled']) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-truncate">{{ $module['priority'] }}</td>
                                            <td class="text-truncate">{{ $module['description'] }}</td>
                                            <td>
                                                @if ($module['name'] != 'Setting' && $module['name'] != 'Dashboard' && $module['name'] != 'User')
                                                    <form action="{{ route('settings.modules.update', $module['name']) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        @if ($module['enabled'] == 'Enabled')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                {{ __('setting::messages.settings.modules.disable') }}
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                {{ __('setting::messages.settings.modules.enable') }}
                                                            </button>
                                                        @endif
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Options-->
    </div>

@endsection
