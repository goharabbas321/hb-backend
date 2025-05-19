<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" role="tablist">
        @can('read_appointments')
            <li class="nav-item filter-item" data-value="">
                <button class="nav-link active filter-link" data-bs-toggle="tab" data-bs-target="#navs-tab-segments"
                    role="tab" aria-selected="true">
                    {{ __('medical::messages.appointments.tabs.all_appointments') }}
                    <span class="badge rounded-pill bg-primary ms-1 clinic_count">0</span>
                </button>
            </li>
        @endcan
        @can('delete_appointments')
            <li class="nav-item filter-item" data-value="1">
                <button class="nav-link filter-link" data-bs-toggle="tab" data-bs-target="#navs-tab-deleted" role="tab"
                    aria-selected="false">
                    {{ __('medical::messages.appointments.tabs.deleted_appointments') }}
                    <span class="badge rounded-pill bg-danger ms-1 deleted_count">0</span>
                </button>
            </li>
        @endcan
    </ul>
</div>
