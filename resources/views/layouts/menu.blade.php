{{--Dashboard--}}
<li class="nav-item side-menus {{ Request::is('dashboard*') ? 'active' : '' }}">
    <a class="nav-link menu-text-wrap" href="{{ route('dashboard') }}" data-toggle="tooltip" data-placement="bottom"
        title="{{ __('messages.dashboard.dashboard') }}" data-delay='{"show":"500", "hide":"50"}'>
        <i class="nav-icon fas fa-chart-pie"></i>
        <span>{{ __('messages.dashboard.dashboard') }}</span>
    </a>
</li>

{{-- Users  --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="Pengguna" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-file"></i>
        Pengguna
    </a>
    <ul class="nav-dropdown-items">
        @module('Pengguna')
        <li class="nav-item side-menus {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('users.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Pengguna" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-file"></i>
                <span>Pengguna</span>
            </a>
        </li>
        @endmodule
        @module('Role')
        <li class="nav-item side-menus {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('roles.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Jabatan" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-folder"></i>
                <span>Jabatan</span>
            </a>
        </li>
        @endmodule
    </ul>
</li>
{{-- Users  --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="Registrasi" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-file"></i>
        Registrasi
    </a>
    <ul class="nav-dropdown-items">
        @module('Pasien')
        <li class="nav-item side-menus {{ Request::is('patients*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('patients.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Pengguna" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-file"></i>
                <span>Pasien</span>
            </a>
        </li>
        @endmodule
        @module('Dokter')
        <li class="nav-item side-menus {{ Request::is('medics*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('medics.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Jabatan" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-folder"></i>
                <span>Dokter</span>
            </a>
        </li>
        @endmodule
    </ul>
</li>


{{-- Settings --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="{{ __('messages.settings') }}" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon  fa fa-cogs"></i>
        {{ __('messages.settings') }}
    </a>
    <ul class="nav-dropdown-items">

        @module('Testimonial')
        <li class="nav-item side-menus {{ Request::is('testimonials*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('testimonials.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="{{ __('messages.testimonials') }}"
                data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fab fa-alipay"></i>
                <span>{{ __('messages.testimonials') }}</span>
            </a>
        </li>
        @endmodule
        <li class="nav-item side-menus {{ Request::is('settings*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('settings.edit') }}" data-toggle="tooltip"
                data-placement="bottom" title="{{ __('messages.settings') }}" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fa fa-cogs"></i>
                <span>{{ __('messages.settings') }}</span>
            </a>
        </li>
    </ul>
</li>
