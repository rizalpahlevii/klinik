<link href="{{ mix('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
<div class="sidebar bg-white shadow-sm">

    <nav class="sidebar-nav">
        <ul class="nav">
            @include('layouts.menu')
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebar_menu_search/sidebar_menu_search.js') }}"></script>