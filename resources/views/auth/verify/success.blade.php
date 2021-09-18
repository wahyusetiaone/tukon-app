@extends('auth.verify.app')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('header_title')
    Verifikasi Email
@endsection

@section('padding_bottom')
    padding-bottom: 235px;
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 class="box-title" style="padding: 2%; color: black;">Verify Email Successfully</h3>
                </div>
            </div>
            <div class="card-body pt-0">

                <div class="row justify-content-center">
                    <div class="box">
                        <div class="box-body p-4    ">
                            @if (session('resent'))
                                <div class="alert alert-success text-muted" role="alert">A fresh verification link has
                                    been sent to
                                    your email address
                                </div>
                            @endif
                            <p class="text-muted">Verifikasi email berhasil. Mohon untuk kembali ke aplikasi mobile atau
                                masuk aplikasi web,
                                @if (\Illuminate\Support\Facades\Auth::check())
                                    @if(auth()->user()->kode_role == 3)
                                        <a href="{{ route('homeclient') }}">di sini</a>.
                                    @else
                                        <a href="{{ route('home') }}">di sini</a>.
                                    @endif
                                @else
                                    <a href="{{ route('panel.login') }}">di sini</a>.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
@endsection
