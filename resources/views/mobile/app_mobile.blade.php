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
{{--    <meta name="viewport" content="width=1366">--}}
<!-- Tell the browser to be responsive to screen width -->
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
            width: 0; /* Remove scrollbar space */
            background: transparent; /* Optional: just make scrollbar invisible */
        }

        /* Optional: show position indicator in red */
        ::-webkit-scrollbar-thumb {
            background: #FF0000;
        }

        body {
            background: linear-gradient(90deg, rgba(0, 140, 198, 0.2) 60%, rgba(221, 240, 255, 0.85) 40%);
        }
    </style>
    @yield('third_party_stylesheets')

    @stack('page_css')
</head>
<body>
<div class="container-fluid">
    <div class="row pt-4 pb-3 d-flex justify-content-center">
        <div class="col-12 col-sm-12 col-lg-12">
            <img class="w-50" style="margin: auto; display: block; padding-top: 100px;"
                 src="{{asset('images/tukon_icon.png')}}">
            <h4 class="text-center pt-5 p-3">
                Demi keamanan dan kenyamanan bertransaksi di Mobile, silahkan download aplikasi kami di Play Store
            </h4>
            <img class="w-50" style="margin: auto; display: block; padding-top: 100px;"
                 src="{{asset('images/google-play.png')}}">
        </div>
    </div>
</div>

@yield('third_party_scripts')
@stack('page_scripts')
</body>
</html>
