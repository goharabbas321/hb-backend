<div class="mb-6 row g-6">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">{{ __('user::messages.users.statics.users') }}</span>
                        <div class="my-1 d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ $totalUser }}</h4>
                        </div>
                        <small class="mb-0"></small>
                    </div>
                    <div class="avatar">
                        <span class="rounded avatar-initial bg-label-primary">
                            <i class="ti ti-user ti-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">{{ __('user::messages.users.statics.verified_users') }}</span>
                        <div class="my-1 d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ $verified }}</h4>
                        </div>
                        <small class="mb-0"></small>
                    </div>
                    <div class="avatar">
                        <span class="rounded avatar-initial bg-label-success">
                            <i class="ti ti-user-check ti-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">{{ __('user::messages.users.statics.blocked_users') }}</span>
                        <div class="my-1 d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ $userBlocked }}</h4>
                        </div>
                        <small class="mb-0"></small>
                    </div>
                    <div class="avatar">
                        <span class="rounded avatar-initial bg-label-danger">
                            <i class="ti ti-users ti-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span class="text-heading">{{ __('user::messages.users.statics.pending_verification') }}</span>
                        <div class="my-1 d-flex align-items-center">
                            <h4 class="mb-0 me-2">{{ $notVerified }}</h4>
                        </div>
                        <small class="mb-0"></small>
                    </div>
                    <div class="avatar">
                        <span class="rounded avatar-initial bg-label-warning">
                            <i class="ti ti-user-search ti-26px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
