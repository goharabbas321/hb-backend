<!-- Nav links for role filtering -->
<ul class="nav nav-tabs mt-3" id="navFilter2">
    <li class="nav-item">
        <a class="nav-link active" href="#" data-nav="">{{ __('user::messages.users.nav2.all') }}</a>
    </li>
    @foreach (Spatie\Permission\Models\Role::all() as $role)
        <li class="nav-item">
            <a class="nav-link" href="#" data-nav="{{ $role->name }}">{{ __($role->name) }}</a>
        </li>
    @endforeach
</ul>
