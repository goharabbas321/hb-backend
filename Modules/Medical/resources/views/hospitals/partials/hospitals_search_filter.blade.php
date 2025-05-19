<div class="card">
    <h5 class="card-header">{{ __('messages.datatable.filters.heading') }}</h5>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.hospitals.table.name_en') }}</label>
                <input type="text" class="form-control searchName"
                    placeholder="{{ __('medical::messages.hospitals.table.name_en') }}">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.hospitals.table.city') }}</label>
                <select class="form-select">
                    <option value="" selected disabled>{{ __('medical::messages.hospitals.table.city') }}</option>
                    @foreach (Modules\Medical\Models\City::all() as $city)
                        <option name=".searchCity" value="{{ $city->id }}">{{ $city->name_en }} -
                            {{ $city->name_ar }}</option>
                    @endforeach
                </select>
                <input type="hidden" class="searchCity" />
            </div>
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.hospitals.table.email') }}</label>
                <input type="text" class="form-control searchEmail"
                    placeholder="{{ __('medical::messages.hospitals.field.placeholder_email') }}">
            </div>
            <div class="col-12">
                <label class="form-label">{{ __('messages.table.created_date') }}</label>
                <input type="text" id="date-filter" class="form-control dt-input searchDate"
                    placeholder="{{ __('messages.table.created_date') }}" data-column-index="4">
            </div>
        </div>
    </div>
</div>
