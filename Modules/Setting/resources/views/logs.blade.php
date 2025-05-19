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
                <div class="tab-pane fade show active" id="logs">
                    <!-- DataTable with Buttons -->
                    <div class="card">
                        <div class="card-datatable dataTable_select">
                            <table class="table gms-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('messages.table.id') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.log_name') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.description') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.subject_type') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.event') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.subject_id') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.causer_name') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.causer_id') }}</th>
                                        <th>{{ __('setting::messages.settings.logs.table.properties') }}</th>
                                        <th>{{ __('messages.table.created_date') }}</th>
                                        <th>{{ __('messages.table.created_time') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--/ DataTable with Buttons -->
                </div>
            </div>

        </div>
        <!-- /Options-->
    </div>

    @include('layouts.sections.columSelector')

@endsection

@push('script-page')
    @php
        $table_data = [
            'url' => route('settings.logs.data', 'null'),
        ];
        $bulk_actions = [];
        $filters = [];
        $order = [
            'column' => 1,
            'direction' => 'desc',
        ];
        $columns = [
            1 => 'id',
            2 => 'log_name',
            3 => 'description',
            4 => 'subject_type',
            5 => 'event',
            6 => 'subject_id',
            7 => 'causer_name',
            8 => 'causer_id',
            9 => 'properties',
            10 => 'created_at',
            11 => 'record_time',
        ];
        $columnDefs = [
            0 => [
                'targets' => '11',
                'searchable' => '!1',
                'orderable' => '!1',
            ],
        ];
        $exports = [
            'columns' => [1, 2, 3, 4, 5, 6, 7, 8, 10, 11],
            'file' => 'logs',
        ];
        $button = [
            'name' => __('messages'),
            'permission' => 'create',
            'icon' => 'ti-plus',
            'class' => '',
            'attr' => [
                'data-bs-toggle' => 'offcanvas',
                'data-bs-target' => '#add-new-record',
            ],
            'url' => '',
        ];
    @endphp
    @include('layouts.sections.datatable', [
        'title' => $page_title,
        'table_data' => $table_data,
        'filters' => $filters,
        'bulk_actions' => $bulk_actions,
        'order' => $order,
        'columns' => $columns,
        'columnDefs' => $columnDefs,
        'exports' => $exports,
        'button' => $button,
        'filter_active' => false,
        'bulk_action_active' => false,
        'nav_filter' => 'd.status',
        'nav_filter2' => 'd.id',
    ])
    @endpushß
