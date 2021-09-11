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

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-top-nav ">
<div class="wrapper">

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content">
            @if($offline)
                @include('client.pembayaran.invoice.invoice_o')
            @else
                @include('client.pembayaran.invoice.invoice')
            @endif
        </section>
    </div>
</div>

<script src="{{ asset('js/pdf_mobile.js') }}" ></script>

@yield('third_party_scripts')
@stack('page_scripts')

</body>
</html>
