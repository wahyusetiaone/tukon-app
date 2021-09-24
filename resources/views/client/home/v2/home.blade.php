@extends('layouts.v2.app_client')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    <link href="{{ asset('css/home_client.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightslider.css') }}" rel="stylesheet">
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
    <!-- Main content -->
    <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide show-neighbors" data-ride="carousel">

            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="item__third">
                        <img src="{{asset('images/car01.png')}}" class="d-block w-100 p-2" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5>
                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="item__third">
                        <img src="{{asset('images/car02.png')}}" class="d-block w-100 p-2" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Second slide label</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="item__third">
                        <img src="{{asset('images/car01.png')}}" class="d-block w-100 p-2" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Third slide label</h5>
                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mvp ml-5">
                <div class="card border-0 rounded-0 p-2">
                    <div class="card-body">
                        <h2 style="text-align:left; color: #5F5F5F;">Wujudkan
                            Rumah
                            Impian Anda
                            Sekarang Juga</h2>
                        <p style="text-align:left; color: #5F5F5F;">Pilih pekerja yang tepat untuk membangun desain
                            interior anda
                        </p>
                        <a href="{{route('all.produk.guest')}}" class="btn btn-block bg-info rounded-0">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <br>
    <!-- Default box -->
    <!--new produk-->
    <div class="card card-solid d-inline-flex card-solid shadow-none rounded-0 border-0 pl-4 pr-4">
        <h3 class="text-center pt-5">Produk Terbaru</h3>
        <div class="card-body pb-0">
            <div class="row pl-5 pr-5">
                @foreach($produk_terbaru as $ptr)
                    <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column p-2">
                        <div class="card rounded-0 border-0 shadow-none prod-adv">
                            <div class="overlay">
                                <div class="row align-middle">
                                    <div class="col-12">
                                        <button id="send_pengajuan" name="send_pengajuan" value="{{$ptr->kode_tukang}}"
                                                class="btn btn-block bg-white rounded-0 p-3"
                                                style="opacity: 1.0!important;">
                                            <span style="color: #0c84ff"><strong>Pesan Sekarang</strong></span>
                                        </button>
                                    </div>
                                    <div class="col-6 pt-3">
                                        <button id="add_to_wish" name="add_to_wish" value="{{$ptr->kode_produk}}"
                                                class="btn btn-primary-outline text-white pt-0 mt-0"
                                                style="font-size: 9pt; display: inline-block;">
                                            <i class="far fa-heart" style="font-size: 15pt; display: inline-block"></i>
                                            <span style="display: inline-block; vertical-align: middle;" class="pb-1">Wishlist</span>
                                        </button>
                                    </div>
                                    <div class="col-6 pt-3">
                                        <a href="{{route('show.produk.guest', $ptr->kode_produk)}}" class="text-white"
                                           style="font-size: 9pt;">
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
                                <img class="card-img-top img-cropped" src="{{asset($path)}}" alt="Card image cap">
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
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <a href="{{route('all.produk.guest')}}">
                        <button class="btn btn-outline-info rounded-0 pt-2 pb-2 pr-4 pl-4">Lihat Selengkapnya</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--top tukang-->
    <ul id="lightSlider" class="pt-4" style="margin-left: 50px;">
        <li>
            <div class="item__third" style="padding-top: 100px;">
                <div style="width: 404px; height: 400px;" class="d-block w-100 p-2">
                    <div class="row p-2">
                        <div class="col-12">
                            <h2 class="font-weight-bold">Penyedia Jasa Terbaik Pilihan Pelanggan Kami </h2>
                        </div>
                        <div class="col-12">
                            <p class="pt-1">Penyedia jasa yang paling banyak dan memiliki rating tertinggi.</p>
                        </div>
                        <div class="col-12">
                            <a href="{{route('all.top.tukang.guest')}}">
                                <button class="btn pl-4 pr-4 bg-white rounded-0" style="color: #008CC6!important;">Lihat
                                    Selengkapnya
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @foreach($top_tukang as $ptr)
            <li>
                <div class="item__third">
                    <div class="container-ban">
                        @if(isset($ptr->path_icon))
                            <img src="{{asset($ptr->path_icon)}}" height="459px;" class="d-block w-100 p-2" alt="">
                        @else
                            <img src="{{asset('images/def_tukang.png')}}" class="d-block w-100 p-2" alt="">
                        @endif
                        <div class="bottom-left">
                            <div class="row">
                                <div class="col-8">
                                    <div class="card rounded-0 border-0 bg-gray-light pt-2 pb-2 pl-4 pr-4 text-left"
                                         style="width: 180px; opacity: 0.8">
                                        <p class="pb-0 mb-0"><strong>{{$ptr->name}}</strong><br><span
                                                class="text-muted">{{$ptr->kota}}</span></p>
                                        {!! bringMeAStar(($ptr->rate*100)/5) !!}
                                    </div>
                                </div>
                                <div class="col-4" style="padding-top: 78px;">
                                    <a href="{{route('show.tukang.guest', $ptr->kode_tukang)}}">
                                        <button class="btn btn-info rounded-0"><i class="fa fa-arrow-right"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <!--produk-->
    <div class="card card-solid d-inline-flex card-solid shadow-none rounded-0 border-0 pb-4 mb-0">
        <h3 class="text-center pt-5">Semua Produk</h3>
        <div class="card-body pb-0">
            <div class="row pl-5 pr-5">
                <ul id="lightSliderV2" class="pt-4">
                    @foreach($produk as $ptr)
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
                        <li>
                            <div class="item__third">
                                <div class="card border-0 rounded-0 shadow-none">
                                    <img src="{{asset($path)}}" height="250px" class="d-block w-100" alt="">
                                    <div class="card-body border-0 rounded-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <h5 class="card-title"><strong>{{$ptr->nama_produk}}</strong></h5>
                                                <p class="card-text">{{$ptr->name}}.</p>
                                                <p class="card-text">{{indonesiaRupiah($ptr->range_min, false)}}
                                                    - {{indonesiaRupiah($ptr->range_max, false)}}</p>
                                            </div>
                                            <div class="col-4">
                                                <a href="{{route('show.produk.guest', $ptr->kode_produk)}}" class="text-white">
                                                <button class="btn btn-info rounded-0 float-right"><i class="fa fa-arrow-right"></i>
                                                </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card-footer bg-white pb-4">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <a href="{{route('all.produk.guest')}}">
                        <button class="btn btn-outline-info rounded-0 pt-2 pb-2 pr-4 pl-4">Lihat Selengkapnya</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="row pt-5" style="padding-bottom: 100px;">
            <div class="col-12">
                <p class="text-center text-bold">Wujudkan Rumah Impianmu</p>
                <h2 class="text-center text-bold">#BersamaTuk-on</h2>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{asset('images/homepageassets/a.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                            <div class="col-8" style="padding-top: 79px;">
                                <img src="{{asset('images/homepageassets/b.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-6">
                                <img src="{{asset('images/homepageassets/f.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                            <div class="col-6">
                                <img src="{{asset('images/homepageassets/g.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">

                            </div>
                        </div>
                    </div>
                    <div class="col-2" style="padding-top: 220px;">
                        <img src="{{asset('images/homepageassets/c.png')}}" class="d-block w-100 p-0 m-0" alt="">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-8" style="padding-top: 109px;">
                                <img src="{{asset('images/homepageassets/d.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                            <div class="col-4">
                                <img src="{{asset('images/homepageassets/e.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-5">
                                <img src="{{asset('images/homepageassets/h.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                            <div class="col-7">
                                <img src="{{asset('images/homepageassets/i.png')}}" class="d-block w-100 p-0 m-0"
                                     alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/home_client.js') }}" defer></script>
    <script src="{{ asset('js/lightslider.min.js') }}" defer></script>
    <script type="text/javascript">

        $('.carousel-item', '.show-neighbors').each(function () {
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
        }).each(function () {
            var prev = $(this).prev();
            if (!prev.length) {
                prev = $(this).siblings(':last');
            }
            prev.children(':nth-last-child(2)').clone().prependTo($(this));
        });

        var frontStars = document.getElementsByClassName("front-stars")[0];
        var percentage = 100 / 5 * 4.63;
        frontStars.style.width = percentage + "%";

        var rating = document.getElementsByClassName("star-rating")[0];
        rating.title = +(4.63.toFixed(2)) + " out of " + 5;

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#lightSlider").lightSlider({
                item: 4,
                autoWidth: false,
                slideMove: 1, // slidemove will be 1 if loop is true
                slideMargin: 10,

                addClass: '',
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
                easing: 'linear', //'for jquery animation',////

                speed: 400, //ms'
                auto: false,
                loop: false,
                slideEndAnimation: true,
                pause: 2000,

                keyPress: false,
                controls: true,
                prevHtml: '',
                nextHtml: '',

                rtl: false,
                adaptiveHeight: false,

                vertical: false,
                verticalHeight: 500,
                vThumbWidth: 100,

                thumbItem: 10,
                pager: true,
                gallery: false,
                galleryMargin: 5,
                thumbMargin: 5,
                currentPagerPosition: 'middle',

                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40,

                responsive: [],

                onBeforeStart: function (el) {
                },
                onSliderLoad: function (el) {
                },
                onBeforeSlide: function (el) {
                },
                onAfterSlide: function (el) {
                },
                onBeforeNextSlide: function (el) {
                },
                onBeforePrevSlide: function (el) {
                }
            });
            $("#lightSliderV2").lightSlider({
                item: 3,
                autoWidth: false,
                slideMove: 1, // slidemove will be 1 if loop is true
                slideMargin: 25,

                addClass: ' ',
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
                easing: 'linear', //'for jquery animation',////

                speed: 400, //ms'
                auto: false,
                loop: false,
                slideEndAnimation: true,
                pause: 2000,

                keyPress: false,
                controls: true,
                prevHtml: '<i class="fa fa-lg fa-chevron-circle-left"></i>',
                nextHtml: '<i class="fa fa-lg fa-chevron-circle-right"></i>',

                rtl: false,
                adaptiveHeight: false,

                vertical: false,
                verticalHeight: 500,
                vThumbWidth: 100,

                thumbItem: 10,
                pager: true,
                gallery: false,
                galleryMargin: 5,
                thumbMargin: 5,
                currentPagerPosition: 'middle',

                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40,

                responsive: [],

                onBeforeStart: function (el) {
                },
                onSliderLoad: function (el) {
                },
                onBeforeSlide: function (el) {
                },
                onAfterSlide: function (el) {
                },
                onBeforeNextSlide: function (el) {
                },
                onBeforePrevSlide: function (el) {
                }
            });
        });
    </script>
@endsection
