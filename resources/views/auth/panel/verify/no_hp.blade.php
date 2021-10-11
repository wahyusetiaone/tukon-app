@extends('auth.panel.layouts.app')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('header_title')
    Verify Your Number Phone
@endsection

@section('padding_bottom')
    padding-bottom: 150px;
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 class="box-title" style="padding: 2%; color: black;">Verifikasi Nomor Handphonemu </h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="box">
                    <div class="box-body text-muted">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">A fresh verification code has been sent to
                                your number phone
                            </div>
                        @endif
                        @if ($message = session('error'))
                            <div class="alert alert-error" role="alert">
                                {{$message}}
                            </div>
                        @endif
                        <form method="post" action="{{route('verification.no_hp')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="code"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm pt-4 pb-4 pl-3 shadow-sm @error('code') is-invalid @enderror"
                                       placeholder="T-XXXXXX">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-key"></span></div>
                                </div>
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info mb-4 rounded-0">Verifikasi</button>
                        </form>
{{--                        <a class=btn-link--}}
{{--                           onclick="event.preventDefault(); document.getElementById('email-form').submit();">{{ __('klik di sini untuk meminta yang lain') }}--}}
{{--                        </a>.--}}

{{--                        <form id="email-form" action="{{ route('verification.resend') }}" method="POST"--}}
{{--                              style="display: none;">--}}
{{--                            @csrf--}}
{{--                        </form>--}}
                        @if (\Illuminate\Support\Facades\Auth::check())
                            <p>
                                atau jika sudah melakukan verifikasi
                                @if(auth()->user()->kode_role == 3)
                                <a href="{{route('homeclient')}}" class=btn-link>{{ __('klik disini untuk masuk beranda') }}</a>.
                                @else
                                    <a href="{{route('home')}}" class=btn-link>{{ __('klik disini untuk masuk dashboard') }}</a>.
                                @endif
                            </p>
                        @else
                            atau jika sudah melakukan verifikasi
                            <a href="{{route('panel.login')}}" class=btn-link>{{ __('klik disini untuk login') }}
                            </a>.
                        @endif
                    </div>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
@endsection
