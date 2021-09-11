@extends('layouts.app_client')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Invoice</li>
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Pembayaran</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-8">
                    @if($offline)
                        @include('client.pembayaran.invoice.invoice_o')
                    @else
                        @include('client.pembayaran.invoice.invoice')
                    @endif
                    <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pembayaran_client.js') }}" defer></script>
@endsection
