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
    @yield('third_party_stylesheets')

    @stack('page_css')
</head>
<body>
<div class="container-fluid" id="konten">
    <div class="row bg-white pl-4 pt-2 pb-3">
        <div class="col-12">
            <div class="row d-flex align-items-center">
                <div class="col-2 pl-4">
                    <img width="134px" height="74px" src="{{asset('images/tukon_icon.png')}}">
                </div>
                <div class="col-10 pl-0 pt-2 m-0">
                    <h1>Daftar Baru</h1>
                </div>
            </div>
        </div>    </div>
    <div class="row d-flex d-block">
        @yield('content')
    </div>
    <div class="row d-flex d-block bg-white" style="padding-left: 80px; padding-right: 80px; font-size: 12pt;">
        <hr>
        <br>
        <br>
        @include('layouts.v2.components.footer')

        @isset($message)
            {{var_dump($message)}}
        @endisset
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('js/search.js') }}" defer></script>

@yield('third_party_scripts')
@stack('page_scripts')
@include('sweetalert::alert')
</body>
</html>
