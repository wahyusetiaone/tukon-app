<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <!-- Force to view web -->
    <meta name="viewport" content="width=1366">
    <!-- Tell the browser to be responsive to screen width -->
    {{--    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">--}}
    @stack('head_meta')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/costume_app.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto">

    @yield('third_party_stylesheets')

    @stack('page_css')
    <style type="text/css">
        .item-kw {
            padding-top: 5px;
            position: relative;
            display: inline-block;
        }

        .item-kw-notify-badge {
            position: absolute;
            right: -8px;
            top: -5px;
            width: 20px;
            height: 20px;
            font-size: 10pt;
            background: red;
            text-align: center;
            border-radius: 50%;
            color: white;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link icon" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item user-menu">
                <div class="item-kw">
                    <a href="{{route('notification')}}">
                        <span id="notif_klunting" class="item-kw-notify-badge" style="display: none">0</span>
                        <img width="25px" height="25px" src="{{asset('images/icons/icon_notif.svg')}}" alt=""/>
                    </a>
                </div>
            </li>
            <li class="nav-item user-menu">
                @if(Auth::guard('web')->user()->kode_role == 2)
                    <a href="{{route('show.user.ptofile', \Illuminate\Support\Facades\Auth::id())}}" class="nav-link">
                        @php
                            $user = auth()->user()->load('tukang');
                        @endphp
                        @if(isset($client->path_icon))
                            <img src="{{asset($user->tukang->path_icon)}}"
                                 class="user-image img-circle" alt="User Image">
                        @else
                            <img src="{{asset('images/profile.png')}}"
                                 class="user-image img-circle" alt="User Image">
                        @endif
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                @else
                    <a href="#" class="btn btn-default btn-flat float-right ml-4" --}}
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sign out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
            @endif
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

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
<script src="{{ asset('js/app.js') }}"></script>
@if(\Illuminate\Support\Facades\Auth::check())
    <script>
        var unix_id = {!! \Illuminate\Support\Facades\Auth::id() !!};
    </script>
    <script src="{{ asset('js/app_root.js') }}"></script>
@endif

@yield('third_party_scripts')

@stack('page_scripts')

@include('sweetalert::alert')
</body>
</html>
