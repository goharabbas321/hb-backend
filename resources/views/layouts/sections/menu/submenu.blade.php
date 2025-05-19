@php
    use Illuminate\Support\Facades\Route;
@endphp

<ul class="menu-sub">
    @if (isset($menu))
        @foreach (collect($menu)->map(fn($item) => (object) $item) as $submenu)
            {{-- active menu method --}}
            @php
                $active = $configData['layout'] === 'vertical' ? 'active open' : 'active';
            @endphp

            @if (checkUserPermission(isset($submenu->permission) ? $submenu->permission : ''))
                <li class="menu-item {{ isActiveMenu($submenu->slug) }}">
                    <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                        class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($submenu->target) and !empty($submenu->target)) target="_blank" @endif>
                        @if (isset($submenu->icon))
                            <i class="{{ $submenu->icon }}"></i>
                        @endif
                        <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                        @isset($submenu->badge)
                            <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}
                            </div>
                        @endisset
                    </a>

                    {{-- submenu --}}
                    @if (isset($submenu->submenu))
                        @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
