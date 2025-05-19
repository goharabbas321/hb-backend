<!-- Modal to add new record -->
<div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('medical::messages.specializations.heading.create') }}</h5>
        <button type="button" class="btn-close text-reset"
            @if (app()->getLocale() == 'ar') style="margin-left: 0; margin-right: auto;" @endif
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <!-- Add specialization form -->
        <form id="specialization_form" class="row g-3" method="POST" action="{{ route('specializations.store') }}">
            @csrf
            <div class="col-md-6">
                <label class="form-label"
                    for="name_en">{{ __('medical::messages.specializations.field.label_name_en') }}</label>
                <input type="text" id="name_en" class="form-control" name="name_en"
                    placeholder="{{ __('medical::messages.specializations.field.placeholder_name_en') }}" />
            </div>

            <div class="col-md-6">
                <label class="form-label"
                    for="name_ar">{{ __('medical::messages.specializations.field.label_name_ar') }}</label>
                <input type="text" id="name_ar" class="form-control" name="name_ar"
                    placeholder="{{ __('medical::messages.specializations.field.placeholder_name_ar') }}" />
            </div>

            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">
                    {{ __('messages.button.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary">{{ __('messages.button.submit') }}</button>
            </div>
        </form>
    </div>
</div>
