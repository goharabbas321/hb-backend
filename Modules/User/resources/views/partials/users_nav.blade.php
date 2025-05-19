<!-- Nav links for role filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link" href="#" data-nav="">{{ __('user::messages.users.nav.all_users') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="1">{{ __('user::messages.users.nav.active_users') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-nav="0">{{ __('user::messages.users.nav.blocked_users') }}</a>
    </li>
    @can('restore_users')
        <li class="nav-item">
            <a class="nav-link" href="#" data-delete="deleted">{{ __('user::messages.users.nav.deleted_users') }}</a>
        </li>
    @endcan
</ul>
