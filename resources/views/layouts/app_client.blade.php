<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @if(config('app.name') != null)
            {{config('app.name')}}
        @else
            Tukang Online
        @endif

    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-top-nav ">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('homeclient')}}" class="nav-link">Home</a>
            </li>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto w-25 nav-justified">
            <div class="input-group">
                <select class="form-control w-25  border border-secondary text-secondary" type="search" id="filter-search">
                    <option class="select2-results__option">Tukang</option>
                    <option class="select2-results__option">Produk</option>
                    <option class="select2-results__option" disabled>Lokasi</option>
                </select>
                    <input class="form-control text-primary border border-primary w-75" type="search" placeholder="Tukang Lemari" id="search-input">
            </div>
        </ul>

        <ul class="navbar-nav ml-auto">
            @if(!Auth::guest())
                <li class="nav-item">
                    <a href="{{ route('wishlist') }}" class="nav-link active">
                        <i class="nav-icon fas fa-cart-plus"></i>
                    </a>
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{url('images/profile.png')}}"
                             class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{url('images/profile.png')}}"
                                 class="img-circle elevation-2"
                                 alt="User Image">
                            <p>
                                {{ Auth::user()->name }}
                                <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                            <a href="#" class="btn btn-default btn-flat float-right"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

            @else
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-key"></i>
                        </a>
                        @if (Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-registered"></i>
                            </a>
                        @endif
                    @endauth
                @endif
            @endif
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
{{--@include('layouts.sidebar')--}}

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Under Develop</b>
        </div>
        <strong>Copyright &copy; </strong>2021 All rights
        reserved.
    </footer>
</div>

<script src="{{ asset('js/app.js') }}" defer></script>

@yield('third_party_scripts')

@stack('page_scripts')

@include('sweetalert::alert')
</body>
</html>
