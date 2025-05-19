<!-- Doctor Statistics -->
<div class="row gy-4 mb-4">
    <!-- Doctor Stats -->
    <div class="col-lg-6 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <span>{{ __('medical::messages.doctors.statics.total') }}</span>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="my-2">{{ $totalDoctors }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-label-primary rounded-pill p-2">
                        <i class='ti ti-stethoscope ti-md'></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Deleted Doctors -->
    <div class="col-lg-6 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <span>{{ __('medical::messages.doctors.statics.deleted') }}</span>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="my-2">{{ $deletedDoctors }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-label-danger rounded-pill p-2">
                        <i class='ti ti-stethoscope ti-md'></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Doctor Statistics -->
