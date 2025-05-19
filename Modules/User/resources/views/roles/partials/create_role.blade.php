<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('user::messages.roles.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <!-- Add role form -->
        <form id="addRoleForm" class="row g-6 p-6" method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="col-12">
                <label class="form-label" for="roleName">{{ __('user::messages.roles.field.label_role_name') }}</label>
                <input type="text" id="roleName" name="roleName" class="form-control"
                    placeholder="{{ __('user::messages.roles.field.placeholder_role_name') }}" tabindex="-1" />
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
                                                        name="permissions[]" value="{{ $type_permission->name }}" />
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
                <button type="reset" class="btn btn-outline-secondary"
                    data-bs-dismiss="offcanvas">{{ __('messages.button.cancel') }}</button>
            </div>
        </form>
        <!--/ Add role form -->
    </div>
</div>
