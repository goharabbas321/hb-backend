<!-- Nav links for status filtering -->
<ul class="nav nav-tabs mb-3 mt-3" id="navFilter">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="">{{ __('medical::messages.doctors.nav.all_doctors') }}</a>
    </li>
    @can('restore_doctors')
        <li class="nav-item">
            <a class="nav-link" href="#"
                data-delete="deleted">{{ __('medical::messages.doctors.nav.deleted_doctors') }}</a>
        </li>
    @endcan
</ul>
