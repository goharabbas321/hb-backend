<!-- Nav links for status filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="">{{ __('medical::messages.facilities.nav.all_facilities') }}</a>
    </li>
    @can('restore_facilities')
        <li class="nav-item">
            <a class="nav-link" href="#"
                data-delete="deleted">{{ __('medical::messages.facilities.nav.deleted_facilities') }}</a>
        </li>
    @endcan
</ul>
