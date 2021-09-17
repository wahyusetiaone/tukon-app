<aside class="main-sidebar sidebar-dark-white costume-color">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{asset('images/logo.png')}}"
             alt="AdminLTE Logo"
             class="brand-image-cs">
        <span class="brand-text font-weight-bold brand-text-cs">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>

</aside>
