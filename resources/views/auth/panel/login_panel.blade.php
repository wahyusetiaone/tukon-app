@extends('auth.panel.layouts.app')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('header_title')
    Log in
@endsection

@section('padding_bottom')
    padding-bottom: 150px;
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 style="color: #4E4E4E !important;">Log In</h3>
                </div>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-danger">{{ session('message') }}</div>
                @endif
                <center>
                    <a href="{{route('panel.login.as', 'client')}}">
                        <div class="card" style="width: 20rem;">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <p class="pt-2">
                                    <h4 style="color: #4E4E4E !important;"><strong>KLIEN</strong></h4>
                                    </p>
                                </div>
                                <!-- /.d-flex -->
                            </div>
                        </div>
                    </a>
                    <a href="{{route('panel.login.as', 'tukang')}}">
                        <div class="card" style="width: 20rem;">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <p class="pt-2">
                                    <h4 style="color: #4E4E4E !important;"><strong>PENYEDIA JASA</strong></h4>
                                    </p>
                                </div>
                                <!-- /.d-flex -->
                            </div>
                        </div>
                    </a>
                </center>
                <div class="d-flex pt-4">
                    <p class="d-flex flex-column">
                        <a href="{{ route('password.request') }}">
                            <span style="color: #008CC6 !important;">Lupa Password</span>
                        </a>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                        <a href="{{route('panel.register')}}">
                            <span style="color: #008CC6 !important;">Daftar Baru</span>
                        </a>
                    </p>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
@endsection
