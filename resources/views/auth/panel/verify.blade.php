@extends('auth.panel.layouts.app')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('header_title')
    Verify Your Email Address
@endsection

@section('padding_bottom')
    padding-bottom: 150px;
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 class="box-title" style="padding: 2%; color: black;">Verify Your Email Address</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="box">
                    <div class="box-body text-muted">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">A fresh verification link has been sent to
                                your email address
                            </div>
                        @endif
                        <p>Before proceeding, please check your email for a verification link.If you did not receive
                            the email,</p>
                        <a class=btn-link onclick="event.preventDefault(); document.getElementById('email-form').submit();">{{ __('click here to request another') }}
                        </a>.

                        <form id="email-form" action="{{ route('verification.resend') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
@endsection
