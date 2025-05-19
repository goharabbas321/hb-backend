<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('user::messages.permissions.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <!-- Add role form -->
        <form id="addForm" class="row g-6 p-6" method="POST" action="{{ route('permissions.store') }}">
            @csrf
            <div class="col-12">
                <label class="form-label"
                    for="permissionName">{{ __('user::messages.permissions.field.label_permission_name') }}</label>
                <input type="text" id="permissionName" name="permissionName" class="form-control"
                    placeholder="{{ __('user::messages.permissions.field.placeholder_permission_name') }}"
                    tabindex="-1" />
            </div>
            <div class="col-12">
                <label for="type" class="form-label">{{ __('user::messages.permissions.field.type') }}</label>
                <select name="type" id="type" class="form-control select2">
                    <option value="">{{ __('user::messages.permissions.field.type_select') }}</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->type }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label for="roles"
                    class="form-label">{{ __('user::messages.permissions.field.assign_role') }}</label>
                <select name="roles[]" id="roles" class="form-control select2" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
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
