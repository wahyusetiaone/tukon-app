@extends('auth.panel.layouts.app')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('header_title')
    Daftar Baru
@endsection

@section('padding_bottom')
    padding-bottom: 235px;
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 style="color: #4E4E4E !important;">Daftar Baru</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="form-group pt-5">
                    <input type="email"
                           class="form-control pt-4 pb-4 pl-3 shadow-sm @error('email') is-invalid @enderror" id="email"
                           name="nama_produk" placeholder="email...">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3 pt-3">
                    <input type="password"
                           class="form-control pt-4 pb-4 pl-3 shadow-sm @error('password') is-invalid @enderror" placeholder="password...">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="input-group-append ">
                        <span class="input-group-text shadow-sm"
                              style="color: #B0B0B0 !important; background-color:transparent !important;">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div><div class="input-group mb-3 pt-3">
                    <input type="c_password"
                           class="form-control pt-4 pb-4 pl-3 shadow-sm @error('c_password') is-invalid @enderror" placeholder="ulangi password...">
                    @error('c_password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="input-group-append ">
                        <span class="input-group-text shadow-sm"
                              style="color: #B0B0B0 !important; background-color:transparent !important;">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <div class="form-group pt-5">
                    <button type="submit" class="btn pt-2 pb-2 shadow-none btn-block rounded-0" style="background-color: #008CC6; color: #FFFFFF">DAFTAR</button>
                </div>
                <div class="d-flex pt-4">
                    <p class="ml-auto d-flex flex-column text-right">
                        <span style="color: #008CC6 !important;"> <span style="color: black!important;">Sudah punya akun ? </span>Masuk</span>
                    </p>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
@endsection
