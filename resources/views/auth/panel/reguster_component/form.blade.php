@extends('auth.panel.reguster_component.app_layout')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 28rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    <h3 style="color: #4E4E4E !important;">Daftar Baru Sebagai Klien</h3>
                    <p style="color: #4E4E4E !important;">Mohon melengkapi data anda</p>
                </div>
            </div>
            <div class="card-body register-card-body">
                <form id="form-regis" method="post" action="{{ route('register') }}">
                    @csrf
                    @if($registerAs == 'client')
                        <div class="input-group mb-3">
                            <input type="text"
                                   name="name" readonly
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm pt-4 pb-4 pl-3 shadow-sm @error('name') is-invalid @enderror"
                                   value="{{ $name }}"
                                   placeholder="Full name">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="email"
                                   name="email" readonly
                                   value="{{ $email }}"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('email') is-invalid @enderror"
                                   placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" name="role"  hidden value="3">
                            <input type="text"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('role') is-invalid @enderror"
                                   value="{{ucfirst($registerAs)}}" readonly
                                   placeholder="Role">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-key"></span></div>
                            </div>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div id="hidden_cl">
                            <div class="input-group mb-3">
                                <input type="number"
                                       name="nomor_telepon_cl"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('nomor_telepon') is-invalid @enderror"
                                       value="{{ old('nomor_telepon_cl') }}"
                                       placeholder="0878xxxx">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                </div>
                                @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="text"
                                       name="kota_cl"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('kota_cl') is-invalid @enderror"
                                       value="{{ old('kota_cl') }}"
                                       placeholder="Surakarta">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-address-book"></span></div>
                                </div>
                                @error('kota_cl')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="text"
                                       name="alamat_cl"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('alamat') is-invalid @enderror"
                                       value="{{ old('alamat_cl') }}"
                                       placeholder="Jebres, Surakarta">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-city"></span></div>
                                </div>
                                @error('alamat')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                   name="password"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('password') is-invalid @enderror"
                                   placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm"
                                   placeholder="Retype password">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="icheck-primary">
                                    <div class="row">
                                        <div class="col-1">
                                            <input type="checkbox" class="ml-2 mt-3" style="width: 20px; height: 20px;"
                                                   id="agreeTerms" name="terms" value="agree">
                                        </div>
                                        <div class="col-11">
                                            <label for="agreeTerms" style="color: #756F86;">
                                                Dengan mendaftar, saya setuju dengan syarat
                                                dan ketentuan dari tukon & kebijakan privasi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row pb-3">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn rounded-0 btn-block pt-2 pb-2"
                                        style="background-color: #008CC6; color: white;">DAFTAR
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    @elseif($registerAs == 'tukang')
                        <div class="input-group mb-3">
                            <input type="text"
                                   name="name" readonly
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm pt-4 pb-4 pl-3 shadow-sm @error('name') is-invalid @enderror"
                                   value="{{ $name }}"
                                   placeholder="Full name">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="email"
                                   name="email" readonly
                                   value="{{ $email }}"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('email') is-invalid @enderror"
                                   placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" name="role" hidden value="2">
                            <input type="text"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('role') is-invalid @enderror"
                                   value="{{ucfirst($registerAs)}}" readonly
                                   placeholder="Role">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-key"></span></div>
                            </div>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div id="hidden_tk">
                            <div class="input-group mb-3">
                                <input type="number"
                                       name="nomor_telepon_tk"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('nomor_telepon') is-invalid @enderror"
                                       value="{{ old('nomor_telepon_tk') }}"
                                       placeholder="0878xxxx">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-phone"></span></div>
                                </div>
                                @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="text"
                                       name="kota_tk"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('kota') is-invalid @enderror"
                                       value="{{ old('kota_tk') }}"
                                       placeholder="Surakarta">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-address-book"></span></div>
                                </div>
                                @error('kota')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <input type="text"
                                       name="alamat_tk"
                                       class="form-control pt-4 pb-4 pl-3 shadow-sm @error('alamat') is-invalid @enderror"
                                       value="{{ old('alamat_tk') }}"
                                       placeholder="Jebres, Surakarta">
                                <div class="input-group-append">
                                    <div class="input-group-text"><span class="fas fa-city"></span></div>
                                </div>
                                @error('alamat')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                   name="password"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm @error('password') is-invalid @enderror"
                                   placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="input-group mb-3">
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control pt-4 pb-4 pl-3 shadow-sm"
                                   placeholder="Retype password">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fas fa-lock"></span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="icheck-primary">
                                    <div class="row">
                                        <div class="col-1">
                                            <input type="checkbox" class="ml-2 mt-3" style="width: 20px; height: 20px;"
                                                   id="agreeTerms" name="terms" value="agree">
                                        </div>
                                        <div class="col-11">
                                            <label for="agreeTerms" style="color: #756F86;">
                                                Dengan mendaftar, saya setuju dengan syarat
                                                dan ketentuan dari tukon & kebijakan privasi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row pb-3">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn rounded-0 btn-block pt-2 pb-2"
                                        style="background-color: #008CC6; color: white;">DAFTAR
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>

@endsection
