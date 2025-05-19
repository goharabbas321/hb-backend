<!-- Nav links for status filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="">{{ __('medical::messages.specializations.nav.all_specializations') }}</a>
    </li>
    @can('restore_specializations')
        <li class="nav-item">
            <a class="nav-link" href="#"
                data-delete="deleted">{{ __('medical::messages.specializations.nav.deleted_specializations') }}</a>
        </li>
    @endcan
</ul>
