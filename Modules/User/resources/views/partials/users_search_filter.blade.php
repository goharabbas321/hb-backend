<div class="card">
    <div class="card-header flex-column flex-md-row">
        <div class="text-center">
            <h5 class="mb-0 card-title">{{ __('messages.datatable.filters.heading') }}</h5>
        </div>
    </div>
    <!--Search Form -->
    <div class="card-body">
        <div class="row" id="dt-search" class="collapse">
            <div class="col-12">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ __('user::messages.users.field.full_name') }}</label>
                        <input type="text" class="form-control dt-input dt-full-name searchName"
                            placeholder="Gohar Abbas" data-column-index="0">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('user::messages.users.field.email') }}</label>
                        <input type="text" class="form-control dt-input searchEmail" placeholder="demo@example.com"
                            data-column-index="1">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('user::messages.users.field.username') }}</label>
                        <input type="text" class="form-control dt-input searchUsername" placeholder="goharabbas"
                            data-column-index="2">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ __('messages.table.created_date') }}</label>
                        <input type="text" id="date-filter" class="form-control dt-input searchDate"
                            placeholder="{{ __('messages.table.created_date') }}" data-column-index="4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
