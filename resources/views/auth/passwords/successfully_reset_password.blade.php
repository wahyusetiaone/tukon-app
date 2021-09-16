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
                            <p class="text-muted">Password berhasil direset. Mohon untuk kembali ke aplikasi mobile atau masuk aplikasi web,</p>
                            <a href="{{ route('panel.login') }}">WEB APP TUKON</a>.
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
