<!-- Nav links for status filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="">{{ __('medical::messages.cities.nav.all_cities') }}</a>
    </li>
    @can('restore_cities')
        <li class="nav-item">
            <a class="nav-link" href="#"
                data-delete="deleted">{{ __('medical::messages.cities.nav.deleted_cities') }}</a>
        </li>
    @endcan
</ul>
