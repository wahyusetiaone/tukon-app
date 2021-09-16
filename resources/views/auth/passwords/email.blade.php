@extends('auth.passwords.app')

@section('third_party_stylesheets')
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
                    <h3 class="box-title text-center" style="padding: 2%; color: black;">Password Reset</h3>
                </div>
            </div>
            <div class="card-body pt-0">

                <div class="row justify-content-center">
                    <div class="box">
                        <div class="box-body p-4    ">
                            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form action="{{ route('password.email') }}" method="post">
                                @csrf

                                <div class="input-group mb-3">
                                    <input type="email"
                                           name="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           placeholder="Email">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                            <p class="mt-3 mb-1">
                                <a href="{{ route("login") }}">Login</a>
                            </p>
                            <p class="mb-0">
                                <a href="{{ route("register") }}" class="text-center">Register a new membership</a>
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
