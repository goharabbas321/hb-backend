<div class="row">
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                    <h5 class="mb-0 me-2">{{ $totalAppointments }}</h5>
                    <small>{{ __('medical::messages.appointments.statics.total_appointments') }}</small>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-primary">
                        <i class="ti ti-calendar-time ti-md"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="card-title mb-0">
                    <h5 class="mb-0 me-2">{{ $deletedAppointments }}</h5>
                    <small>{{ __('medical::messages.appointments.statics.deleted_appointments') }}</small>
                </div>
                <div class="avatar">
                    <span class="avatar-initial rounded bg-label-danger">
                        <i class="ti ti-trash ti-md"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
