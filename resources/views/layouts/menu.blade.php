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
        title="Registrasi" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-hospital-user"></i>
        Registrasi
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item side-menus {{ Request::is('patients*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('patients.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Pengguna" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-user-injured"></i>
                <span>Pasien</span>
            </a>
        </li>
        <li class="nav-item side-menus {{ Request::is('medics*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('medics.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Jabatan" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-user-md"></i>
                <span>Dokter</span>
            </a>
        </li>
    </ul>
</li>

{{-- layanan --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="Layanan" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-list"></i>
        Layanan
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item side-menus {{ Request::is('services.generals*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('services.generals.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Umum" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-bookmark"></i>
                <span>Umum</span>
            </a>
        </li>
        <li class="nav-item side-menus {{ Request::is('services.family_plannings*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('services.family_plannings.index') }}"
                data-toggle="tooltip" data-placement="bottom" title="KB" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-bookmark"></i>
                <span>KB</span>
            </a>
        </li>
        <li class="nav-item side-menus {{ Request::is('services.pregnancies*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('services.pregnancies.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Kehamilan" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-bookmark"></i>
                <span>Kehamilan</span>
            </a>
        </li>
        <li class="nav-item side-menus {{ Request::is('services.laboratories*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('services.laboratories.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Laboratorium" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-bookmark"></i>
                <span>Laboratorium</span>
            </a>
        </li>
    </ul>
</li>





{{-- Produk  --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="Produk" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-list"></i>
        Produk
    </a>
    <ul class="nav-dropdown-items">
        @module('Kategori')
        <li class="nav-item side-menus {{ Request::is('categories*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('categories.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Kategori" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-bookmark"></i>
                <span>Daftar Kategori</span>
            </a>
        </li>
        @endmodule
        @module('Supplier')
        <li class="nav-item side-menus {{ Request::is('suppliers*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('suppliers.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Supplier" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-truck"></i>
                <span>Daftar Supplier</span>
            </a>
        </li>
        @endmodule
        @module('Merek')
        <li class="nav-item side-menus {{ Request::is('brands*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('brands.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Merek" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-tags"></i>
                <span>Daftar Merek</span>
            </a>
        </li>
        @endmodule
        @module('Obat')
        <li class="nav-item side-menus {{ Request::is('products*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('products.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Produk" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-box-open"></i>
                <span>Daftar Produk</span>
            </a>
        </li>
        @endmodule
    </ul>
</li>

{{-- Users  --}}
<li class="nav-item side-menus nav-dropdown">
    <a class="nav-link nav-dropdown-toggle menu-text-wrap" href="#" data-toggle="tooltip" data-placement="bottom"
        title="Pengguna" data-delay='{"show":"500", "hide":"50"}' data-trigger="hover">
        <i class="nav-icon fas fa-user"></i>
        Pengguna
    </a>
    <ul class="nav-dropdown-items">
        @module('Pengguna')
        <li class="nav-item side-menus {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link menu-text-wrap" href="{{ route('users.index') }}" data-toggle="tooltip"
                data-placement="bottom" title="Pengguna" data-delay='{"show":"500", "hide":"50"}'>
                <i class="nav-icon fas fa-users"></i>
                <span>Pengguna</span>
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
