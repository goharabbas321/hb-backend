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

        .card {
            transition: all 0.4s ease;
            /* Smooth animation */
        }

        #filter-card {
            overflow: scroll;
            /* Hide content during the transition */
            transition: all 0.4s ease;
            /* Smooth animation */
        }

        #filter-card.hidden {
            width: 0;
            /* Collapse the card */
            opacity: 0;
            /* Fade out */
            padding: 0;
            /* Remove padding for smooth collapse */
            margin: 0;
            /* Remove margin */
        }

        #datatable-card {
            transition: all 0.4s ease;
            /* Smooth width adjustment */
        }
    </style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/typeahead-js/typeahead.js', 'resources/assets/vendor/libs/tagify/tagify.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js', 'resources/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['Modules/Medical/resources/assets/js/specializations.js'])
    <script>
        window.BulkURL = "{{ route('specializations.bulk_action') }}";
        window.Token = "{{ csrf_token() }}";
        window.translations = @json(__('medical::messages'));
    </script>
@endsection

@section('content')
    @can('statics_specializations')
        @include('medical::specializations.partials.specializations_statics')
    @endcan

    <div class="row">
        <!-- Filter Card (Initially Hidden) -->
        <div id="filter-card" class="col-3 hidden">
            @include('medical::specializations.partials.specializations_search_filter')
        </div>
        <!-- DataTable Card -->
        <div id="datatable-card" class="col-12 card">
            @include('medical::specializations.partials.specializations_nav')
            <!-- DataTable with Buttons -->
            <div class="card-datatable dataTable_select text-nowrap">
                <table class="table gms-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('messages.table.id') }}</th>
                            <th>{{ __('medical::messages.specializations.table.name_en') }}</th>
                            <th>{{ __('medical::messages.specializations.table.name_ar') }}</th>
                            <th>{{ __('messages.table.created_date') }}</th>
                            <th>{{ __('messages.table.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!--/ DataTable with Buttons -->
        </div>
    </div>

    @include('layouts.sections.columSelector')

    @include('medical::specializations.partials.specialization_create')

@endsection

@push('script-page')
    @php
        $table_data = [
            'url' => route('specializations.data', 'null'),
        ];
        $bulk_actions = [];
        $filters = [
            'd.name' => '.searchName',
        ];
        $order = [
            'column' => 1,
            'direction' => 'asc',
        ];
        $columns = [
            1 => 'id',
            2 => 'name_en',
            3 => 'name_ar',
            4 => 'created_at',
            5 => 'action',
        ];
        $columnDefs = [
            0 => [
                'targets' => '5',
                'searchable' => '!1',
                'orderable' => '!1',
                'createdCell' => "function (td, cellData, rowData, row, col) {
                    // Prevent row selection when clicking anywhere in the action column
                    $(td).on('click', function (e) {
                    if(e.target.className != 'ti ti-trash')
                    e.stopPropagation(); // Prevent row selection
                    });
                    }",
            ],
        ];
        $exports = [
            'columns' => [1, 2, 3],
            'file' => 'specializations',
        ];
        $button = [
            'name' => __('medical::messages.specializations.button.create_specialization'),
            'permission' => 'create_specializations',
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
        'filter_active' => true,
        'bulk_action_active' => true,
        'delete_permission' => 'delete_specializations',
        'restore_permission' => 'restore_specializations',
        'nav_filter' => 'd.is_active',
        'nav_filter2' => 'd.id',
    ])
@endpush
