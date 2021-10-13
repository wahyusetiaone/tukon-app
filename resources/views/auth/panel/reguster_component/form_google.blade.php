@extends('auth.panel.reguster_component.app_layout')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
    <style type="text/css">
        /* Set the size of the div element that contains the map */
        #map {
            height: 200px;
            /* The height is 270 pixels */
            width: 407px;
            /* The width is the width of the web page */
        }
    </style>
@endsection

@section('content')
    <div class="col-12 d-flex justify-content-center pt-5">
        <div class="card shadow-none" style="width: 28rem;">
            <div class="card-header border-0">
                <div class="pt-5">
                    @if($registerAs == 'client')
                        <h3 style="color: #4E4E4E !important;">Daftar Baru Sebagai Klient</h3>
                        <p style="color: #4E4E4E !important;">Mohon melengkapi data anda</p>
                    @endif
                    @if($registerAs == 'tukang')
                        <h3 style="color: #4E4E4E !important;">Daftar Baru Sebagai Penyedia Jasa</h3>
                        <p style="color: #4E4E4E !important;">Mohon melengkapi data anda</p>
                    @endif
                </div>
            </div>
            <div class="card-body register-card-body">
                <form id="form-regis" method="post" action="{{ route('register.need.more.store', (int) request()->segments()[1]) }}" enctype="multipart/form-data">
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
                            <input type="number" name="role" hidden value="3">
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
                                <select class="form-control-lg rounded-sm w-100 border-secondary"
                                        style="border-color:#E0E0E0;  font-size: 12pt; background-color: white;"
                                        id="provinsi_t">
                                    <option value="all">Pilih Provinsi</option>
                                    @foreach($provinsi->provinsi as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                <input type="text" id="provinsi" name="provinsi" hidden>
                                @error('provinsi')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <select disabled class="form-control-lg rounded-sm w-100"
                                        style="border-color:#E0E0E0;font-size: 12pt; background-color: white;"
                                        id="kota" name="kota">
                                    <option>Pilih Kota</option>
                                </select>
                                @error('kota')
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

                        <div class="row mb-3">
                            <div class="col-12">
                                <!--The div element for the map -->
                                <div id="map"></div>
                                <input type="text" id="kode_lokasi" name="kode_lokasi" hidden>
                                <p class="text-sm text-info">Pastikan lokasi diatas adalah kantor anda. Anda dapat memindah lokasi dengan mengeser petanya.</p>
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
                                <select class="form-control-lg rounded-sm w-100 border-secondary"
                                        style="border-color:#E0E0E0;  font-size: 12pt; background-color: white;"
                                        id="provinsi_t">
                                    <option value="all">Pilih Provinsi</option>
                                    @foreach($provinsi->provinsi as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                                <input type="text" id="provinsi" name="provinsi" hidden>
                                @error('provinsi')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <select disabled class="form-control-lg rounded-sm w-100"
                                        style="border-color:#E0E0E0;font-size: 12pt; background-color: white;"
                                        id="kota" name="kota">
                                    <option>Pilih Kota</option>
                                </select>
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

                        <div class="row">
                            <div class="col-8">
                                <img width="270px" height="200px" id="preview" src="{{asset('images/img_kantor.svg')}}"/>
                            </div>
                            <div class="col-4">
                                <button type="button" onclick="event.preventDefault(); document.getElementById('t_image').click();" style="margin-top: 127px;background-color: #008CC6; color: white;" class="btn rounded-0" id="btn_img">Pilih Foto Kantor</button>
                                <input type="file" accept="image/*" id="t_image" name="image" hidden>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <!--The div element for the map -->
                                <div id="map"></div>
                                <input type="text" id="kode_lokasi" name="kode_lokasi" hidden>
                                <p class="text-sm text-info">Pastikan lokasi diatas adalah kantor anda. Anda dapat memindah lokasi dengan mengeser petanya.</p>
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
    <script src="{{ asset('js/registrasi.js') }}" defer></script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQsm8Oczc3DfX8Khl2Ah0cL-qQhA_fUEA"
    ></script>
    <script src="https://unpkg.com/location-picker/dist/location-picker.min.js"></script>

    <script>
        // // Initialize and add the map
        // function initMap() {
        //     // The location of Kantor -7.597306516133232, 110.74012611887392
        //     const kantor = { lat: -7.597306516133232, lng: 110.74012611887392 };
        //     // The map, centered at Uluru
        //     const map = new google.maps.Map(document.getElementById("map"), {
        //         zoom: 16,
        //         center: kantor,
        //         disableDefaultUI: true,
        //         draggable: false,
        //         zoomControl: false,
        //         scrollwheel: false,
        //         disableDoubleClickZoom: true
        //     });
        //
        //     // The marker, positioned at Uluru
        //     const marker = new google.maps.Marker({
        //         position: kantor,
        //         map: map,
        //     });
        // }

        const kantor = {lat: -7.597306516133232, lng: 110.74012611887392};
        var locationPicker = new locationPicker('map', {
            setCurrentPosition: true, // You can omit this, defaults to true
        }, {
            zoom: 15, // You can set any google map options here, zoom defaults to 15
            center: kantor,
            streetViewControl: false,

        });

        google.maps.event.addListener(locationPicker.map, 'idle', function (event) {
            // Get current location and show it in HTML
            var location = locationPicker.getMarkerPosition();
            document.getElementById('kode_lokasi').value = '{"latitude":' + location.lat + ',"longitude":'+location.lng+'}';
        });

    </script>
@endsection
