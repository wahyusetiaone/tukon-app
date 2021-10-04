@extends('layouts.app')

@push('page_css')
    <style type="text/css">
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
    <script>
        @php
            $locationRegister = json_decode($data->tukang->kode_lokasi, false);
            $locationVerification = json_decode($data->koordinat, false);
        @endphp
        // Initialize and add the map
        function initMap() {

            //Details
            var pinColorRegister = "#2196F3";
            var pinLabelRegister = "Tempat Mendaftar";
            var pinColorVerification = "#673AB7";
            var pinLabelVerification = "Tempat Verifikasi";


            // Pick your pin (hole or no hole)
            var pinSVGHole = "M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z";
            var labelOriginHole = new google.maps.Point(12,-2);


            var markerImageRegister = {  // https://developers.google.com/maps/documentation/javascript/reference/marker#MarkerLabel
                path: pinSVGHole,
                anchor: new google.maps.Point(12,17),
                fillOpacity: 1,
                fillColor: pinColorRegister,
                strokeWeight: 2,
                strokeColor: "white",
                scale: 2,
                labelOrigin: labelOriginHole
            };
            var labelRegister = {
                text: pinLabelRegister,
                color: "black",
                fontSize: "12px"
            };
            var markerImageVerification = {  // https://developers.google.com/maps/documentation/javascript/reference/marker#MarkerLabel
                path: pinSVGHole,
                anchor: new google.maps.Point(12,17),
                fillOpacity: 1,
                fillColor: pinColorVerification,
                strokeWeight: 2,
                strokeColor: "white",
                scale: 2,
                labelOrigin: labelOriginHole
            };
            var labelVerification = {
                text: pinLabelVerification,
                color: "black",
                fontSize: "12px"
            };

            // The location of Uluru
            const register = { lat: {{$locationRegister->latitude}}, lng: {{$locationRegister->longitude}} };
            const verification = { lat: {{$locationVerification->latitude}}, lng: {{$locationVerification->longitude}} };

            //center in two point
            var bounds = new google.maps.LatLngBounds();
            bounds.extend(register);
            bounds.extend(verification);
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 10,
            });
            map.fitBounds(bounds);

            // The marker, positioned at Uluru
            const markerRegister = new google.maps.Marker({
                position: register,
                map: map,
                icon: markerImageRegister,
                label:labelRegister
            });
            // The marker, positioned at Uluru
            const markerVerification = new google.maps.Marker({
                position: verification,
                map: map,
                icon: markerImageVerification,
                label:labelVerification
            });
            // Add circle overlay and bind to marker
            var circle = new google.maps.Circle({
                map: map,
                radius: 100,    // 10 miles in metres
                fillColor: '#CDDC39',
                strokeColor: '#EEFF41'
            });

            circle.bindTo('center', markerVerification, 'position');

            //count distance
            var rad = function(x) {
                return x * Math.PI / 180;
            };

            var getDistance = function(p1, p2) {
                var R = 6378137; // Earth’s mean radius in meter
                var dLat = rad(p2.lat - p1.lat);
                var dLong = rad(p2.lng - p1.lng);
                var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat)) *
                    Math.sin(dLong / 2) * Math.sin(dLong / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                var d = R * c;
                return d.toFixed(2); // returns the distance in meter
            };

            $('#jarak').text(getDistance(register, verification)+' Meter')
        }
    </script>
@endpush

@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if($data->status == "V01")
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            Mohon segera melakukan verikasi data dibawah ini.
                        </div>
                    @elseif($data->status == "V02")
                        <div class="callout callout-success">
                            <h5><i class="fas fa-check"></i> Telah Terverifikasi</h5>
                        </div>
                    @elseif($data->status == "V03")
                        <div class="callout callout-danger">
                            <h5><i class="fas fa-check"></i> Telah ditolak</h5>
                        </div>
                    @endif

                </div><!-- /.col -->

                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-white">Data Registrasi</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fas fa-minus text-white"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Nama</h6>
                                        <h6 class="text-muted">{{$data->tukang->user->name}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Alamat</h6>
                                        <h6 class="text-muted">{{$data->tukang->alamat}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Provinsi</h6>
                                        <h6 class="text-muted">{{$data->tukang->provinsi ?? '-'}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Kota</h6>
                                        <h6 class="text-muted">{{$data->tukang->kota}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Nomor Hp</h6>
                                        <h6 class="text-muted">{{$data->tukang->nomor_telepon}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Email</h6>
                                        <h6 class="text-muted">{{$data->tukang->user->email ?? '-'}}</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Foto</h6>
                                        <img src="{{asset($data->tukang->path_icon)}}" class="w-100">
                                    </div>
                                </div>
                            </div>
                            <!-- /.content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-12">
                    <div class="card card-primary-dx">
                        <div class="card-header">
                            <h3 class="card-title text-white">Data</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fas fa-minus text-white"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Nama</h6>
                                        <h6 class="text-muted">{{$data->nama_tukang}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Alamat</h6>
                                        <h6 class="text-muted">{{$data->alamat ?? '-'}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Nomor Hp</h6>
                                        <h6 class="text-muted">{{$data->no_hp}}</h6>
                                    </div>
                                    <div class="pb-1">
                                        <h6 class="d-block text-bold">Email</h6>
                                        <h6 class="text-muted">{{$data->email ?? '-'}}</h6>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        @foreach($data->berkas as $item)
                                            @if(strpos($item->original_name, 'foto_ktp') !== false)
                                                <div class="col-4">
                                                    <h6 class="d-block text-bold">KTP</h6>
                                                    <img src="{{asset($item->path)}}" class="w-100">
                                                </div>
                                            @elseif(strpos($item->original_name, 'foto_personal') !== false)
                                                <div class="col-4">
                                                    <h6 class="d-block text-bold">Personal</h6>
                                                    <img src="{{asset($item->path)}}" class="w-100">
                                                </div>
                                            @elseif(strpos($item->original_name, 'foto_kantor') !== false)
                                                <div class="col-4">
                                                    <h6 class="d-block text-bold">Kantor</h6>
                                                    <img src="{{asset($item->path)}}" class="w-100">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- /.content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-12">
                    <div class="card card-primary-dx">
                        <div class="card-header">
                            <h3 class="card-title text-white">Koordinat</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fas fa-minus text-white"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <!--The div element for the map -->
                                    <div id="map"></div>
                                </div>
                                <div class="col-12">
                                    <h4 class="text-center pt-2"> Perbedaan jarak sekitar : <b id="jarak"></b></h4>
                                </div>
                            </div>
                            <!-- /.content -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12">
                    <div class="float-right">
                        <button class="btn btn-primary-cs mb-3" id="verifikasi_">Verifikasi</button>
                        <button class="btn btn-danger mb-3" id="tolak_">Tolak</button>
                        <form id="verifikasi-form" action="{{ route('terima.verification-tukang.admin', $data->id) }}" method="GET" class="d-none">
                            @csrf
                        </form>
                        <form id="tolak-form" action="{{ route('tolak.verification-tukang.admin', $data->id) }}" method="POST" class="d-none">
                            @csrf
                            <input type="text" name="catatan" id="catatan" hidden>
                        </form>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_verification_admin.js') }}" defer></script>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQsm8Oczc3DfX8Khl2Ah0cL-qQhA_fUEA&callback=initMap&libraries=&v=weekly"
        async
    ></script>
@endpush
