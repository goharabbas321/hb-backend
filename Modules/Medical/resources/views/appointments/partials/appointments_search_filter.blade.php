<div class="card mb-4">
    <h5 class="card-header">{{ __('messages.search_filters') }}</h5>
    <form class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label"
                        for="searchHospital">{{ __('medical::messages.appointments.table.hospital') }}</label>
                    <select class="form-select select2 searchHospital" name="hospital">
                        <option value="">{{ __('messages.select.all') }}</option>
                        @foreach (\Modules\Medical\Models\Hospital::all() as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label"
                        for="searchSpecialization">{{ __('medical::messages.appointments.table.specialization') }}</label>
                    <select class="form-select select2 searchSpecialization" name="specialization">
                        <option value="">{{ __('messages.select.all') }}</option>
                        @foreach (\Modules\Medical\Models\Specialization::all() as $specialization)
                            <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label"
                        for="searchPatient">{{ __('medical::messages.appointments.table.patient') }}</label>
                    <select class="form-select select2 searchPatient" name="patient">
                        <option value="">{{ __('messages.select.all') }}</option>
                        @foreach (\App\Models\User::role('patient')->get() as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label"
                        for="searchDate">{{ __('medical::messages.appointments.table.appointment_date') }}</label>
                    <input type="text" class="form-control flatpickr-input searchDate" name="appointment_date"
                        placeholder="YYYY-MM-DD">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label"
                        for="searchStatus">{{ __('medical::messages.appointments.table.status') }}</label>
                    <select class="form-select searchStatus" name="status">
                        <option value="">{{ __('messages.select.all') }}</option>
                        <option value="scheduled">{{ __('medical::messages.appointments.status.scheduled') }}</option>
                        <option value="confirmed">{{ __('medical::messages.appointments.status.confirmed') }}</option>
                        <option value="completed">{{ __('medical::messages.appointments.status.completed') }}</option>
                        <option value="cancelled">{{ __('medical::messages.appointments.status.cancelled') }}</option>
                        <option value="no_show">{{ __('medical::messages.appointments.status.no_show') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.table.date_range') }}</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="text" id="startDate" name="startDate" class="form-control flatpickr-input"
                                placeholder="Start Date" />
                        </div>
                        <div class="col-6">
                            <input type="text" id="endDate" name="endDate" class="form-control flatpickr-input"
                                placeholder="End Date" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button type="reset" class="btn btn-label-secondary">{{ __('messages.button.clear') }}</button>
            <button type="submit" class="btn btn-primary search_btn">{{ __('messages.button.search') }}</button>
        </div>
    </form>
</div>
