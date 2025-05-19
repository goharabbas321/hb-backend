<!-- Navigation -->
<div class="col-12 col-lg-4">
    <div class="d-flex justify-content-between flex-column mb-4 mb-md-0">
        <h5 class="mb-4">{{ __('setting::messages.settings.nav.heading') }}</h5>
        <ul class="nav nav-align-left nav-pills flex-column">
            @can('read_settings')
                <li class="nav-item mb-1">
                    <a class="nav-link {{ isActiveMenu('settings.index') }}" href="{{ route('settings.index') }}">
                        <i class="ti ti-settings ti-sm me-1_5"></i>
                        <span class="align-middle">{{ __('setting::messages.settings.nav.general_settings') }}</span>
                    </a>
                </li>
            @endcan

            <li class="nav-item mb-1 d-none">
                <a class="nav-link" href="#">
                    <i class="ti ti-language ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.language_management') }}</span>
                </a>
            </li>
            <li class="nav-item mb-1 d-none">
                <a class="nav-link" href="#">
                    <i class="ti ti-mail ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.email_configuration') }}</span>
                </a>
            </li>
            <li class="nav-item mb-1 d-none">
                <a class="nav-link" href="#">
                    <i class="ti ti-credit-card ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.payment_gateway') }}</span>
                </a>
            </li>
            <li class="nav-item mb-1 d-none">
                <a class="nav-link" href="#">
                    <i class="ti ti-api ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.apis') }}</span>
                </a>
            </li>
            <li class="nav-item d-none">
                <a class="nav-link" href="#">
                    <i class="ti ti-bell-ringing ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.notifications') }}</span>
                </a>
            </li>
            @can('read_logs')
                <li class="nav-item">
                    <a class="nav-link {{ isActiveMenu('settings.logs') }}" href="{{ route('settings.logs') }}">
                        <i class="ti ti-list ti-sm me-1_5"></i>
                        <span class="align-middle">{{ __('setting::messages.settings.nav.activity_logs') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_modules')
                <li class="nav-item">
                    <a class="nav-link {{ isActiveMenu('settings.modules.index') }}"
                        href="{{ route('settings.modules.index') }}">
                        <i class="ti ti-gauge ti-sm me-1_5"></i>
                        <span class="align-middle">{{ __('setting::messages.settings.nav.modules_management') }}</span>
                    </a>
                </li>
            @endcan

            @can('create_backups')
                <li class="nav-item">
                    <a class="nav-link" id="backups-link">
                        <i class="ti ti-database ti-sm me-1_5"></i>
                        <span class="align-middle">{{ __('setting::messages.settings.nav.backups') }}</span>
                    </a>
                </li>
            @endcan

            <li class="nav-item">
                <a class="nav-link d-none" href="#">
                    <i class="ti ti-chart-bar ti-sm me-1_5"></i>
                    <span class="align-middle">{{ __('setting::messages.settings.nav.analytics') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- /Navigation -->
