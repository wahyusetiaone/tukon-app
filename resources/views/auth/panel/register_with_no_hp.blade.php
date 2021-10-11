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
    <div class="col-12 d-flex justify-content-center pt-2">
        <div class="card shadow-none" style="width: 24rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 style="color: #4E4E4E !important;">Daftar Baru</h3>
                </div>
            </div>
            <div class="card-body pt-0">
                <form method="post" action="{{ route('register.check.nohp') }}" id="fcm-register">
                    @csrf
                    <input type='text' hidden name="typeof" value="{{Request::segment(2)}}">
                    <div class="form-group pt-2">
                        <input type="number"
                               class="form-control pt-4 pb-4 pl-3 shadow-sm @error('no_hp') is-invalid @enderror"
                               id="no_hp"
                               name="no_hp" placeholder="089x xxxx xxxx">
                        @error('no_hp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <a href="{{route('panel.register.as', request()->segment(2))}}" class="float-right text-sm text-info"> Gunakan Email ?</a>
                    <div class="form-group pt-5">
                        <button type="submit" class="btn pt-2 pb-2 shadow-none btn-block rounded-0"
                                style="background-color: #008CC6; color: #FFFFFF">DAFTAR
                        </button>
                    </div>
                </form>

                <div class="form-group pt-1">
                    <p style="color: darkgrey" class="text-center">Atau</p>
                    <a href="{{ route('google',request()->segment(2))}}"
                       class="btn pt-2 pb-2 shadow-none btn-block rounded-0"
                       style="background-color: #008CC6; color: #FFFFFF"> <i class="fab fa-google"></i> GOOGLE
                    </a>
                </div>
                <div class="d-flex pt-4">
                    <p class="ml-auto d-flex flex-column text-right">
                        <span style="color: #008CC6 !important;"> <span style="color: black!important;">Sudah punya akun ? </span><a
                                href="{{route('panel.login')}}">&nbsp;Masuk</a></span>
                    </p>
                </div>
                <!-- /.d-flex -->
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript">

        var isEmail = true;

        function nomor() {
            if (isEmail) {
                $("#inp-nomor").show();
                $("#inp-email").hide();
                $('a#btn_chng').text('Gunakan Email ?')
            } else {
                $("#inp-nomor").hide();
                $("#inp-email").show();
                $('a#btn_chng').text('Gunakan nomor Handphone ?')
            }
            isEmail = !isEmail;
        }
    </script>
@endsection
