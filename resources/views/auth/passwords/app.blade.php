<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('third_party_stylesheets')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-12 col-sm-12 col-md-12 d-flex pt-5 mt-5 justify-content-center">
            <img width="134px" height="74px" src="{{asset('images/tukon_icon.png')}}">
        </div>
        <div class="col-12 col-lg-12 col-sm-12 col-md-12 ">
            @yield('content')
        </div>
    </div>
</div>
@yield('third_party_scripts')
</body>
</html>
