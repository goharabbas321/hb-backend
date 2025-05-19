<!-- Nav links for status filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link active" href="#"
            data-nav="">{{ __('medical::messages.hospitals.nav.all_hospitals') }}</a>
    </li>
    @can('restore_hospitals')
        <li class="nav-item">
            <a class="nav-link" href="#"
                data-delete="deleted">{{ __('medical::messages.hospitals.nav.deleted_hospitals') }}</a>
        </li>
    @endcan
</ul>
