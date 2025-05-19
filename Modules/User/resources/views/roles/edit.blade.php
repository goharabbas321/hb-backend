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
    @vite(['Modules/User/resources/assets/js/roles.js'])
    <script>
        window.Token = "{{ csrf_token() }}";
        window.translations = @json(__('user::messages'));
    </script>
@endsection

@section('content')
    <div class="card" id="edit-record">
        <div class="card-header border-bottom">
            <h5 class="card-title" id="exampleModalLabel">{{ __('user::messages.roles.heading.edit') }}</h5>
        </div>
        <div class="card-body">
            <!-- Add role form -->
            <form id="addRoleForm" class="row g-6 p-6" method="POST" action="{{ route('roles.update', $role) }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label" for="roleName">{{ __('user::messages.roles.field.label_role_name') }}</label>
                    <input type="text" id="roleName" name="roleName" class="form-control"
                        placeholder="{{ __('user::messages.roles.field.placeholder_role_name') }}"
                        value="{{ $role->name }}" tabindex="-1" />
                </div>
                <div class="col-12">
                    <h5 class="mb-6">{{ __('user::messages.roles.info.role_permissions') }}</h5>
                    <!-- Permission table -->
                    <div class="table-responsive">
                        <table class="table table-flush-spacing">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap fw-medium text-heading">
                                        {{ __('user::messages.roles.info.admin_access') }} <i class="ti ti-info-circle"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ __('user::messages.roles.info.admin_access_info') }}"></i></td>
                                    <td>
                                        <div class="d-flex justify-content-end">
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="checkbox" id="selectAll" />
                                                <label class="form-check-label" for="selectAll">
                                                    {{ __('user::messages.roles.info.select_all') }}
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($types as $type)
                                    <tr>
                                        <td class="text-nowrap fw-medium text-heading">
                                            {{ __($type->type) }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                @foreach (getPermissionWithType($type->type) as $type_permission)
                                                    <div class="form-check mb-0 me-4 me-lg-12">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="{{ $type->type }}{{ $type_permission->name }}"
                                                            name="permissions[]" value="{{ $type_permission->name }}"
                                                            @if ($role->hasPermissionTo($type_permission->name)) checked @endif />
                                                        <label class="form-check-label"
                                                            for="{{ $type->type }}{{ $type_permission->name }}">
                                                            {{ $type_permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Permission table -->
                </div>
                <div class="col-12">
                    <button type="submit" id="submitButton" name="submitButton"
                        class="btn btn-primary me-4">{{ __('messages.button.submit') }}</button>
                    <button type="button" class="btn btn-outline-secondary"
                        onclick="window.history.back();">{{ __('messages.button.cancel') }}</button>
                </div>
            </form>
            <!--/ Add role form -->
        </div>
    </div>
@endsection
