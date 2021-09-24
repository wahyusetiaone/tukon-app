@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
    <style type="text/css">
        .img-cropped {
            object-fit: cover;
            object-position: center center;
            width: 268px;
            height: 288px;
        }

        /*---------- star rating ----------*/
        .star-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            font-size: 14pt;
        }

        .back-stars {
            display: flex;
            color: #9E9E9E;
            position: relative;
        }

        .front-stars {
            display: flex;
            color: #FFBC0B;
            overflow: hidden;
            position: absolute;
            top: 0;
        }

        .overlay {
            padding-top: 50%;
            padding-left: 8%;
            padding-right: 8%;
            color: white !important;
            background-color: rgba(68, 68, 68, 0.25) !important;
            z-index: 1000;
            display: none !important;
        }

        .card.rounded-0.border-0.shadow-none.prod-adv:hover .overlay {
            display: block !important;
        }

    </style>
@endsection

@section('content')
    <div class="col-3 pl-4 pr-4 pt-5">
        <div class="card bg-white rounded-0 p-3">
            <div class="text-center pt-3">
                @if(isset($ptr->path_icon))
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{asset($ptr->path_icon)}}"
                         alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                         alt="User profile picture">
                @endif
            </div>

            <h3 class="profile-username text-center" style="color: #7A7A7A;">{{$tukang->user->name}}</h3>

            <p class="text-muted text-center" style="color: #7A7A7A;">{{$tukang->kota}}</p>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b style="color: #7A7A7A;">Produk</b> <a class="float-right" style="color: #7A7A7A;">{{$tukang->produk_count}}</a>
                </li>
                <li class="list-group-item">
                    <b style="color: #7A7A7A;">Proyek Dikerjakan</b> <a class="float-right" style="color: #7A7A7A;">{{$proyek}}</a>
                </li>
            </ul>
            <span  class="text-muted text-center text-bold" style="color: #7A7A7A;"><span style="font-size: 24pt;">4,9</span> /5</span>
            {!!  bringMeAStar(($tukang->rate*100)/5)  !!}
            <p class="text-muted text-center pt-2" style="color: #7A7A7A;">{{$tukang->voterate_count}} rating</p>
        </div>

        <div class="card bg-white rounded-0 p-3">
            <div class="card card-header border-0 " style="background-color: #008CC6; color: white;"> Tentang</div>
            <div class="card-body">
                <strong><i class="fas fa-building mr-1"></i> Kota</strong>

                <p class="text-muted">{{$tukang->kota}}</p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                <p class="text-muted">{{$tukang->alamat}}</p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> Nomor Telepon</strong>

                <p class="text-muted">
                    {{$tukang->nomor_telepon}}
                </p>

                <hr>

                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                <p class="text-muted">
                    {{$tukang->user->email}}
                </p>

                <hr>
            </div>
        </div>
    </div>
    <div class="col-9 pl-4 pr-4 pt-5">
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 pl-3 pr-3 pt-1 pb-1">
            <span class="text-muted" style="display: inline-block">
                Produk yang dimiliki
            </span>
        </div>
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 p-3 mb-5">
            <div class="row d-flex align-items-stretch">
                @if($produk->total() != 0)
                    @foreach($produk as $ptr)
                        <div class="col-4 p-2">
                            <div class="card rounded-0 border-0 shadow-none prod-adv">
                                <div class="overlay">
                                    <div class="row align-middle">
                                        <div class="col-12">
                                            <a href="{{route('show.produk.guest', $ptr->id)}}" class="text-white">
                                                <button
                                                    class="btn btn-block bg-white rounded-0 p-3"
                                                    style="opacity: 1.0!important;">
                                                    <span style="color: #0c84ff"><strong>Lihat</strong></span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="konten">
                                    @if(isset($ptr->path))
                                        @if($ptr->multipath)
                                            @php
                                                $path = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC';
                                                $myArray = explode(',', $ptr->path);
                                                $path = $myArray[0];
                                            @endphp
                                        @else
                                            @php
                                                $path = $ptr->path;
                                            @endphp
                                        @endif
                                    @else
                                    @endif
                                    <img class="card-img-top img-cropped w-100" src="{{asset($path)}}"
                                         alt="Card image cap">
                                    <div class="card-body" style="background-color: #F9F9F9;">
                                        <h4>{{$ptr->nama_produk}}</h4>
                                        <p class="text-muted">{{$ptr->name}}</p>
                                        <p class="card-text text-bold">{{indonesiaRupiah($ptr->range_min)}}
                                            - {{indonesiaRupiah($ptr->range_max)}}</p>
                                        {!! bringMeAStar(($ptr->rate*100)/5) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Data tidak ditemukan !!!</p>
                @endif
            </div>
            <div class="pagination bg-white d-flex align-middle justify-content-center">
                {{ $produk->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/all_produk_guest.js') }}" defer></script>
    <script type="text/javascript">
        var frontStars = document.getElementsByClassName("front-stars")[0];
        var percentage = 100 / 5 * 4.63;
        frontStars.style.width = percentage + "%";

        var rating = document.getElementsByClassName("star-rating")[0];
        rating.title = +(4.63.toFixed(2)) + " out of " + 5;
    </script>
@endsection
