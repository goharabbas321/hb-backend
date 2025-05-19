<div class="card">
    <h5 class="card-header">{{ __('messages.datatable.filters.heading') }}</h5>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.cities.table.name') }}</label>
                <input type="text" class="form-control searchName"
                    placeholder="{{ __('medical::messages.cities.field.placeholder_name_en') }}">
            </div>
            <div class="col-12">
                <label class="form-label">{{ __('messages.table.created_date') }}</label>
                <input type="text" id="date-filter" class="form-control dt-input searchDate"
                    placeholder="{{ __('messages.table.created_date') }}" data-column-index="4">
            </div>
        </div>
    </div>
</div>
