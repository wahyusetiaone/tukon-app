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
            <div class="card-body pt-0">
                <form method="post" action="{{ url('/login') }}">
                    @csrf
                    <div class="form-group pt-5">
                        <input type="email" required
                               class="form-control pt-4 pb-4 pl-3 shadow-sm @error('email') is-invalid @enderror"
                               id="email"
                               name="email" placeholder="email...">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3 pt-3">
                        <input type="password" name="password" id="password" required
                               class="form-control pt-4 pb-4 pl-3 shadow-sm @error('password') is-invalid @enderror"
                               placeholder="password...">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="input-group-append ">
                        <span class="input-group-text shadow-sm"
                              style="color: #B0B0B0 !important; background-color:transparent !important;">
                            <i class="fas fa-eye-slash" id="togglePassword"></i>
                        </span>
                        </div>
                    </div>
                    <div class="form-group pt-5">
                        <button type="submit" class="btn pt-2 pb-2 shadow-none btn-block rounded-0"
                                style="background-color: #008CC6; color: #FFFFFF">MASUK
                        </button>
                    </div>
                </form>
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
    <script type="text/javascript">
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            $(this).toggleClass('fa-eye').toggleClass('fa-eye-slash');
            // toggle the eye slash icon
            // if (type === 'text'){
            //     this.toggleClass('fa-eye');
            // }else {
            //     this.toggleClass('fa-eye-slash');
            // }
        });
    </script>
@endsection
