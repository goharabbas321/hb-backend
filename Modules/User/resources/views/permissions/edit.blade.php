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
    @vite(['Modules/User/resources/assets/js/permissions.js'])
    <script>
        window.Token = "{{ csrf_token() }}";
        window.translations = @json(__('user::messages'));
    </script>
@endsection

@section('content')
    <div class="card" id="edit-record">
        <div class="card-header border-bottom">
            <h5 class="card-title" id="exampleModalLabel">{{ __('user::messages.permissions.heading.edit') }}</h5>
        </div>
        <div class="card-body">
            <!-- Add role form -->
            <form id="addForm" class="row g-6 p-6" method="POST" action="{{ route('permissions.update', $permission) }}">
                @method('PUT')
                @csrf
                <div class="col-12">
                    <label class="form-label"
                        for="permissionName">{{ __('user::messages.permissions.field.label_permission_name') }}</label>
                    <input type="text" id="permissionName" name="permissionName" class="form-control"
                        placeholder="{{ __('user::messages.permissions.field.placeholder_permission_name') }}"
                        value="{{ $permission->name }}" tabindex="-1" />
                </div>

                <div class="col-12">
                    <label for="type" class="form-label">{{ __('user::messages.permissions.field.type') }}</label>
                    <select name="type" id="type" class="form-control select2">
                        @foreach ($types as $type)
                            <option value="{{ $type->type }}" @if ($permission->type == $type->type) selected @endif>
                                {{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="roles"
                        class="form-label">{{ __('user::messages.permissions.field.assign_role') }}</label>
                    <select name="roles[]" id="roles" class="form-control select2" multiple>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if (in_array($role->id, $assignedRoles)) selected @endif>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
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
