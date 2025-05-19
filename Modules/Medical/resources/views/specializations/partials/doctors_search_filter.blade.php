<div class="card">
    <h5 class="card-header">{{ __('messages.datatable.filters.heading') }}</h5>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.doctors.table.name') }}</label>
                <input type="text" class="form-control searchName"
                    placeholder="{{ __('medical::messages.doctors.field.placeholder_name_en') }}">
            </div>
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.doctors.table.hospital') }}</label>
                <select class="form-select">
                    <option value="" selected disabled>
                        {{ __('medical::messages.doctors.field.placeholder_hospital') }}</option>
                    @foreach (Modules\Medical\Models\Hospital::all() as $hospital)
                        <option name=".searchHospital" value="{{ $hospital->id }}">{{ $hospital->name_en }} -
                            {{ $hospital->name_ar }}</option>
                    @endforeach
                </select>
                <input type="hidden" class="searchHospital" />
            </div>
            <div class="col-md-12">
                <label class="form-label">{{ __('medical::messages.doctors.table.specialization') }}</label>
                <select class="form-select">
                    <option value="" selected disabled>
                        {{ __('medical::messages.doctors.field.placeholder_specialization') }}</option>
                    @foreach (Modules\Medical\Models\Specialization::all() as $specialization)
                        <option name=".searchSpecialization" value="{{ $specialization->id }}">
                            {{ $specialization->name_en }} - {{ $specialization->name_ar }}</option>
                    @endforeach
                </select>
                <input type="hidden" class="searchSpecialization" />
            </div>
            <div class="col-12">
                <label class="form-label">{{ __('messages.table.created_date') }}</label>
                <input type="text" id="date-filter" class="form-control dt-input searchDate"
                    placeholder="{{ __('messages.table.created_date') }}" data-column-index="4">
            </div>
        </div>
    </div>
</div>
