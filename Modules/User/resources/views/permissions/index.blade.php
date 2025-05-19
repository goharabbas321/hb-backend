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
    @vite(['Modules/User/resources/assets/js/permissions.js'])
    <script>
        window.Token = "{{ csrf_token() }}";
        window.translations = @json(__('user::messages'));
    </script>
@endsection

@section('content')
    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable dataTable_select text-nowrap">
            <table class="table gms-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>{{ __('messages.table.id') }}</th>
                        <th>{{ __('user::messages.roles.table.name') }}</th>
                        <th>{{ __('user::messages.roles.table.guard_name') }}</th>
                        <th>{{ __('messages.table.created_date') }}</th>
                        <th>{{ __('messages.table.created_time') }}</th>
                        <th>{{ __('messages.table.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ DataTable with Buttons -->

    @include('layouts.sections.columSelector')

    @include('user::permissions.partials.create')

@endsection

@push('script-page')
    @php
        $table_data = [
            'url' => route('permissions.data', 'null'),
        ];
        $bulk_actions = [];
        $filters = [];
        $order = [
            'column' => 1,
            'direction' => 'asc',
        ];
        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'guard_name',
            4 => 'created_at',
            5 => 'record_time',
            6 => 'action',
        ];
        $columnDefs = [
            0 => [
                'targets' => '6',
                'searchable' => '!1',
                'orderable' => '!1',
                'createdCell' => "function (td, cellData, rowData, row, col) {
                    // Prevent row selection when clicking anywhere in the action column
                    $(td).on('click', function (e) {
                    if(e.target.className != 'ti ti-trash')
                    e.stopPropagation(); // Prevent row selection
                    //alert('Action clicked for: ' + rowData.name);
                    });
                    }",
            ],
            1 => [
                'targets' => '5',
                'searchable' => '!1',
                'orderable' => '!1',
            ],
        ];
        $exports = [
            'columns' => [1, 2, 3, 4],
            'file' => 'permissions',
        ];
        $button = [
            'name' => __('user::messages.permissions.button.create_permission'),
            'permission' => 'create_permissions',
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
        'nav_filter2' => 'd.status',
    ])
@endpush
