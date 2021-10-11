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

    <!-- Force to view web -->
    <meta name="viewport" content="width=1366">
    <!-- Tell the browser to be responsive to screen width -->
    {{--    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>--}}
    @stack('head_meta')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        html, body, .bg_main {
            min-height: 100% !important;
            overflow: scroll;
            overflow-x: hidden;
        }
        ::-webkit-scrollbar {
            width: 0;  /* Remove scrollbar space */
            background: transparent;  /* Optional: just make scrollbar invisible */
        }
        /* Optional: show position indicator in red */
        ::-webkit-scrollbar-thumb {
            background: #FF0000;
        }
        body{
            background: linear-gradient(90deg, rgba(0, 140, 198, 0.2) 60%, rgba(221, 240, 255, 0.85) 40%);
        }
        hr {
            border: 0;
            clear:both;
            display:block;
            width: 96%;
            background-color:#D8D8D8;
            height: 1px;
        }
    </style>
    <style type="text/css">
        /* Gaya tombol dropdown */
        .dropbtn {
            cursor: pointer;
        }

        /* The container <div> - posisi untuk konten dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Konten Dropdown (default = Disembunyikan) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 99;
        }

        /* Link di dalam dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /*  Merubah Warna link dropdown di hover */
        .dropdown-content a:hover {background-color: #f1f1f1}

        /* menampilkan menu dropdown di hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

    </style>
    <style type="text/css">
        .item-kw {
            position:relative;
            display:inline-block;
        }
        .item-kw-notify-badge{
            position: absolute;
            right:-10px;
            top:-15px;
            width:15px;
            height:15px;
            font-size: 8pt;
            background:red;
            text-align: center;
            border-radius: 50%;
            color:white;
        }
    </style>
    @yield('third_party_stylesheets')

    @stack('page_css')
</head>
<body>
<div class="container-fluid" id="konten">
    <div class="row pl-4 pt-2 pb-3">
        @include('layouts.v2.components.header')
    </div>
    <div class="row d-flex d-block">
        @yield('content')
    </div>
    <div class="row d-flex d-block bg-white" style="padding-left: 80px; padding-right: 80px; font-size: 12pt;">
        <hr>
        <br>
        <br>
        @include('layouts.v2.components.footer')
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('js/search.js') }}"></script>

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
