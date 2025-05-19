<!-- Specialization Statistics -->
<div class="row gy-4 mb-4">
    <!-- Specialization Stats -->
    <div class="col-lg-6 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <span>{{ __('medical::messages.specializations.statics.total') }}</span>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="my-2">{{ $totalSpecializations }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-label-primary rounded-pill p-2">
                        <i class='ti ti-certificate ti-md'></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Deleted Specializations -->
    <div class="col-lg-6 col-sm-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="content-left">
                        <span>{{ __('medical::messages.specializations.statics.deleted') }}</span>
                        <div class="d-flex align-items-center gap-3">
                            <h4 class="my-2">{{ $deletedSpecializations }}</h4>
                        </div>
                    </div>
                    <span class="badge bg-label-danger rounded-pill p-2">
                        <i class='ti ti-certificate ti-md'></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Specialization Statistics -->
