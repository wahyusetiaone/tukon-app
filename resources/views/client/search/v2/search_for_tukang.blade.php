@extends('layouts.v2.app_client')
@section('third_party_stylesheets')
    <style type="text/css">
        .parent {
            width: 320px;
            height: 50px;
            display: block;
            transition: all 0.3s;
            cursor: pointer;
            padding: 12px;
            box-sizing: border-box;
        }

        /***  desired colors for children  ***/
        .parent {
            color: #000;
        }

        .parent span {
            font-size: 18px;
            margin-right: 8px;
            font-weight: bold;
            font-family: 'Helvetica';
            line-height: 26px;
            vertical-align: top;
        }

        .parent svg {
            max-height: 26px;
            width: auto;
            display: inline;
        }

        .parent svg path {
            fill: currentcolor;
        }
    </style>
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
    <style>
        .container-ban {
            position: relative;
            text-align: center;
            color: white;
        }

        .bottom-left {
            position: absolute;
            bottom: 20px;
            left: 30px;
        }
    </style>
@endsection

@section('content')
    <!-- content -->
    <div class="col-3 pl-4 pr-4 pt-5 pb-5">
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 p-2">
            <div class="footer content align-middle d-flex">
                <div class='parent'>
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13 8C11.1334 8 9.56545 6.72147 9.12406 4.99237C9.08341 4.99741 9.04201 5 9 5H1C0.447715 5 0 4.55228 0 4C0 3.44772 0.447715 3 1 3H9C9.04201 3 9.08341 3.00259 9.12406 3.00763C9.56545 1.27853 11.1334 0 13 0C14.8638 0 16.4299 1.27477 16.874 3H19C19.5523 3 20 3.44772 20 4C20 4.55228 19.5523 5 19 5H16.874C16.4299 6.72523 14.8638 8 13 8ZM0 11C0 10.4477 0.447715 10 1 10H2C2.04201 10 2.08342 10.0026 2.12407 10.0076C2.56545 8.27853 4.13342 7 6 7C7.86384 7 9.42994 8.27477 9.87398 10H19C19.5523 10 20 10.4477 20 11C20 11.5523 19.5523 12 19 12H9.87398C9.42994 13.7252 7.86384 15 6 15C4.13342 15 2.56545 13.7215 2.12407 11.9924C2.08342 11.9974 2.04201 12 2 12H1C0.447715 12 0 11.5523 0 11ZM0 18C0 17.4477 0.447715 17 1 17H8C8.04201 17 8.08342 17.0026 8.12407 17.0076C8.56545 15.2785 10.1334 14 12 14C13.8666 14 15.4345 15.2785 15.8759 17.0076C15.9166 17.0026 15.958 17 16 17H19C19.5523 17 20 17.4477 20 18C20 18.5523 19.5523 19 19 19H16C15.958 19 15.9166 18.9974 15.8759 18.9924C15.4345 20.7215 13.8666 22 12 22C10.1334 22 8.56545 20.7215 8.12407 18.9924C8.08342 18.9974 8.04201 19 8 19H1C0.447715 19 0 18.5523 0 18ZM15 4C15 5.10457 14.1046 6 13 6C11.8954 6 11 5.10457 11 4C11 2.89543 11.8954 2 13 2C14.1046 2 15 2.89543 15 4ZM14 18C14 19.1046 13.1046 20 12 20C10.8954 20 10 19.1046 10 18C10 16.8954 10.8954 16 12 16C13.1046 16 14 16.8954 14 18ZM8 11C8 12.1046 7.10457 13 6 13C4.89543 13 4 12.1046 4 11C4 9.89543 4.89543 9 6 9C7.10457 9 8 9.89543 8 11Z"
                              fill="black"/>
                    </svg>
                    <span style="color:#7A7A7A; font-size: 12pt;">Filter Lokasi</span>
                </div>
            </div>
            <div class="pl-3 pt-3 pr-3">
                <p class="text-muted" hidden id="b_filter"></p>
                <div class="form-group pb-3">
                    <label class="text-muted pb-2">Provinsi</label>
                    <select class="form-control rounded-1 shadow-sm" id="inProv" name="inProv">
                        <option value="all">Semua Provinsi</option>
                        @foreach($prov->provinsi as $item)
                            <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group pb-4">
                    <label class="text-muted pb-2">Kota</label>
                    <select class="form-control rounded-1 shadow-sm" id="inKota" name="inKota" disabled>
                    </select>
                </div>
                <div class="form-group pb-3 pt-4 d-flex justify-content-center">
                    <button id="btnGass" style="background-color: #0880AE; border-color: #0880AE;"
                            class="btn btn-primary pt-2 pb-2 pl-5 pr-5" type="button">Filter
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="col-9 pl-4 pr-4 pt-5">
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 pl-3 pr-3 pt-1 pb-1">
            <span class="text-muted" style="display: inline-block">
                Urutkan
            <button class="btn border-1 rounded-0 ml-4 mr-4 pt-1 pb-1 pr-3 pl-3"
                    style="display: inline-block; border-color: #008CC6; background-color: #008CC6; color: white;">Terkait</button>
            <button class="btn border-1 rounded-0 pt-1 pb-1 pr-3 pl-3"
                    style="display: inline-block; border-color: #008CC6;">Terbaru</button>
            </span>
        </div>
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 p-3 mb-5">
            <div class="row d-flex align-items-stretch">
                @if(count($obj['data']) != 0)
                    @if($filter == "produk")
                        @foreach($obj['data'] as $ptr)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column p-2">
                                <div class="card rounded-0 border-0 shadow-none prod-adv">
                                    <div class="overlay">
                                        <div class="row align-middle">
                                            <div class="col-12">
                                                <button class="btn btn-block bg-white rounded-0 p-3"
                                                        style="opacity: 1.0!important;">
                                                    <span
                                                        style="color: #0c84ff"><strong>Masukan Keranjang</strong></span>
                                                </button>
                                            </div>
                                            <div class="col-5 pt-3">
                                                <a href="#" class="text-white" style="font-size: 10pt;">
                                                    <i class="far fa-heart" style="font-size: 15pt"></i> Wishlist
                                                </a>
                                            </div>
                                            <div class="col-7 pt-3">
                                                <a href="#" class="text-white" style="font-size: 10pt;">
                                                    <i class="far fa-star" style="font-size: 15pt"></i> Selengkapnya
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
                    @endif
                    @if($filter == "tukang")
                        @foreach($obj['data'] as $ptr)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column p-0">
                                <div class="item__third">
                                    <div class="container-ban">
                                        <img src="{{asset('images/def_tukang.png')}}" class="d-block w-100 p-2" alt="">
                                        <div class="bottom-left">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="card rounded-0 border-0 bg-gray-light pt-2 pb-2 pl-4 pr-4 text-left"
                                                         style="width: 180px; opacity: 0.8">
                                                        <p class="pb-0 mb-0"><strong>{{$ptr->name}}</strong><br><span
                                                                class="text-muted">{{$ptr->kota}}</span><br><span
                                                                class="text-muted">{{$ptr->nomor_telepon}}</span></p>
                                                        {!! bringMeAStar(($ptr->rate*100)/5) !!}
                                                    </div>
                                                </div>
                                                <div class="col-4" style="padding-top: 78px;">
                                                    <button class="btn btn-info rounded-0"><i class="fa fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @else
                    <p>Data tidak ditemukan !!!</p>
                @endif
            </div>
            <div class="pagination bg-white d-flex align-middle justify-content-center" >
                @if(count($obj['data']) != 0)
                    <span class="text-info pt-1">{{$obj['current_page']}}&nbsp;</span>
                    <span class="text-muted pt-1 mr-2"> /&nbsp;{!! $obj['last_page'] !!}</span>
                    <a href="{{$obj['links'][0]['url']}}" class="btn btn-sm btn-info ml-1 mr-1 {{$obj['links'][0]['url'] ?? 'disabled'}}"><i class="fa fa-chevron-left"></i></a>
                    <a href="{{$obj['links'][2]['url']}}" class="btn btn-sm btn-info ml-1 mr-1 {{$obj['links'][2]['url'] ?? 'disabled'}}"><i class="fa fa-chevron-right"></i></a>
                @endif
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ mix('js/search_only_page_active.js') }}" defer></script>
    <script type="text/javascript">
        var frontStars = document.getElementsByClassName("front-stars")[0];
        var percentage = 100 / 5 * 4.63;
        frontStars.style.width = percentage + "%";

        var rating = document.getElementsByClassName("star-rating")[0];
        rating.title = +(4.63.toFixed(2)) + " out of " + 5;
    </script>
@endsection
