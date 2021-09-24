<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Force to view web -->
    <meta name="viewport" content="width=1366">
    <!-- Tell the browser to be responsive to screen width -->
{{--    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        @font-face {
            font-family: OptimusPrinceps;
            src: url('{{ asset('fonts/Montserrat-Medium.ttf') }}');
        }

        h1 {
            font-family: 'OptimusPrinceps';
            font-weight: normal;
            font-style: normal;
        }

        .bg-primary {
            background-color: rgba(0, 140, 198, 0.2) !important;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: 10;
        }

        .bg-secondary {
            background-color: rgba(221, 240, 255, 1) !important;
            width: 100%;
        }
    </style>
    @yield('third_party_stylesheets')
</head>
<body>
<div class="container-fluid">
    <div class="row pl-4 pt-2 pb-3">
        @include('auth.panel.layouts.header')
    </div>
    <div class="row d-flex d-block">
        <div class="col-8 bg-primary" style="padding-left: 140px; padding-top: 150px; @yield('padding_bottom') height: 100%;">
            <div class="row">
                @include('auth.panel.layouts.left_content')
            </div>
        </div>
        <div class="col-4 bg-secondary">
            <div class="row" style="padding-top: 70px;">
                @yield('content')
            </div>
        </div>
    </div>
    <div style="padding-left: 80px; padding-right: 80px; font-size: 12pt;">
        @include('auth.panel.layouts.footer')
    </div>
</div>
<script src="{{ asset('js/app.js') }}" defer></script>
@yield('third_party_scripts')
</body>
</html>
