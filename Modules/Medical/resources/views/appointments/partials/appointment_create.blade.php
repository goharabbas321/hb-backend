<!-- Add New Appointment Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="add-new-record" aria-labelledby="add-new-record-label">
    <div class="offcanvas-header border-bottom">
        <h5 id="add-new-record-label" class="offcanvas-title">
            {{ __('medical::messages.appointments.button.create_appointment') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form class="add-new-record pt-0 row g-3" method="POST" action="{{ route('appointments.store') }}">
            @csrf
            <div class="col-sm-12">
                <label class="form-label" for="hospital_id">{{ __('medical::messages.appointments.form.hospital') }}
                    <span class="text-danger">*</span></label>
                <select id="hospital_id" name="hospital_id" class="form-select" required>
                    <option value="">{{ __('messages.select.select') }}</option>
                    @foreach ($hospitals ?? [] as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name_en }} - {{ $hospital->name_ar }}</option>
                    @endforeach
                </select>
                @error('hospital_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12">
                <label class="form-label"
                    for="specialization_id">{{ __('medical::messages.appointments.form.specialization') }} <span
                        class="text-danger">*</span></label>
                <select id="specialization_id" name="specialization_id" class="form-select" required>
                    <option value="">{{ __('messages.select.select') }}</option>
                    @foreach ($specializations ?? [] as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name_en }} -
                            {{ $specialization->name_ar }}</option>
                    @endforeach
                </select>
                @error('specialization_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="user_id">{{ __('medical::messages.appointments.form.patient') }} <span
                        class="text-danger">*</span></label>
                <select id="user_id" name="user_id" class="form-select" required>
                    <option value="">{{ __('messages.select.select') }}</option>
                    @foreach ($patients ?? [] as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label class="form-label"
                    for="appointment_date">{{ __('medical::messages.appointments.form.appointment_date') }} <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control flatpickr-input" id="appointment_date" name="appointment_date"
                    placeholder="YYYY-MM-DD" required />
                @error('appointment_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label class="form-label"
                    for="appointment_number">{{ __('medical::messages.appointments.form.appointment_number') }} <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" id="appointment_number" name="appointment_number"
                    min="1" required />
                @error('appointment_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="status">{{ __('medical::messages.appointments.form.status') }} <span
                        class="text-danger">*</span></label>
                <select id="status" name="status" class="form-select" required>
                    <option value="scheduled">{{ __('medical::messages.appointments.status.scheduled') }}</option>
                    <option value="confirmed">{{ __('medical::messages.appointments.status.confirmed') }}</option>
                    <option value="completed">{{ __('medical::messages.appointments.status.completed') }}</option>
                    <option value="cancelled">{{ __('medical::messages.appointments.status.cancelled') }}</option>
                    <option value="no_show">{{ __('medical::messages.appointments.status.no_show') }}</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="reason">{{ __('medical::messages.appointments.form.reason') }}</label>
                <input type="text" class="form-control" id="reason" name="reason" maxlength="255" />
                @error('reason')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12">
                <label class="form-label" for="notes">{{ __('medical::messages.appointments.form.notes') }}</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                @error('notes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-12 text-center mt-4">
                <button type="submit"
                    class="btn btn-primary me-sm-3 me-1 data-submit">{{ __('messages.button.submit') }}</button>
                <button type="reset" class="btn btn-label-secondary"
                    data-bs-dismiss="offcanvas">{{ __('messages.button.cancel') }}</button>
            </div>
        </form>
    </div>
</div>
<!-- /Add New Appointment Offcanvas -->
