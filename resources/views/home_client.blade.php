@extends('layouts.app_client')

@section('third_party_stylesheets')
    <link href="{{ asset('css/home_client.css') }}" rel="stylesheet">
@endsection

@section('content')
    <br>
    <!-- Main content -->
    <section class="content">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <br>
        <!-- Default box -->
        <!--new produk-->
        <div class="card card-solid">
            <blockquote class="blockquote">
                <p class="mb-0">Produk - produk terbaru.</p>
            </blockquote>
            <div class="card-body pb-0">
                <div class="row scrolling-wrapper flex-row flex-nowrap ">
                    @foreach($produk_terbaru as $ptr)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">

                                    <h2 class="lead"><b>{{$ptr->nama_produk}}</b></h2>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <p class="text-muted text-sm"><b>Tukang: </b> {{$ptr->name}} <br>
                                                <b>Diskripsi: </b> @if(strlen($ptr->diskripsi) < 50 ){{$ptr->diskripsi}} @else {{substr($ptr->diskripsi, 0, 50) }}
                                                ... @endif </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span>Alamat :
                                                    <br> {{$ptr->alamat}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                    Telepon : <br>{{$ptr->nomor_telepon}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-dollar-sign"></i></span>
                                                    Harga : <br>{{$ptr->range_min}} - {{$ptr->range_max}}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if(isset($ptr->path))
                                                @if($ptr->multipath)
                                                    @php
                                                        $myArray = explode(',', $ptr->path);
                                                    @endphp
                                                    <div id="carouselExampleControls" style="max-width:200px;width:100%"
                                                         class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @for($i = 0; $i < sizeof($myArray); $i++)
                                                                <div class="carousel-item @if($i == 0) active @endif ">
                                                                    <img class="d-block w-100"
                                                                         style="max-width:200px;width:100%"
                                                                         src="{{asset($myArray[$i])}}"
                                                                         alt="First slide">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleControls"
                                                           role="button"
                                                           data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleControls"
                                                           role="button"
                                                           data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <img src="{{asset($ptr->path)}}" alt="user-avatar"
                                                         class="img-fluid">

                                                @endif
                                            @else
                                                <img
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                                    alt="user-avatar"
                                                    class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="https://wa.me/{{substr_replace($ptr->nomor_telepon, "62", 0, 1)}}"
                                           class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        <button id="add_to_wish" name="add_to_wish" value="{{$ptr->kode_produk}}"
                                                class="btn btn-sm bg-danger wish">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                        <button id="send_pengajuan" name="send_pengajuan" value="{{$ptr->kode_tukang}}"
                                                class="btn btn-sm bg-primary">
                                            <i class="fas fa-paper-plane"></i> Ajukan
                                        </button>
                                        <a href="{{route('show.produk.guest', $ptr->kode_produk)}}">
                                            <button class="btn btn-sm bg-secondary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{route('all.new.produk.guest')}}">
                    <div class="blockquote-footer text-right btn float-right">Lebih lanjut <cite title="Source Title">...</cite>
                    </div>
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--top tukang-->
        <div class="card card-solid">
            <blockquote class="blockquote">
                <p class="mb-0">Top Tukang</p>
            </blockquote>
            <div class="card-body pb-0">
                <div class="row scrolling-wrapper flex-row flex-nowrap ">
                    @foreach($top_tukang as $ptr)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">

                                    <h2 class="lead"><b>{{$ptr->name}}</b></h2>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span>Alamat :
                                                    <br>{{$ptr->alamat}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-chart-area"></i></span>Area Kerja :
                                                    <br>{{$ptr->kota}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                    Telepon : <br>{{$ptr->nomor_telepon}}
                                                </li>
                                                <li class="medium">
                                                    @for($i = 0; $i < 5; $i++)
                                                        @if($i < $ptr->rate)
                                                            <span class="fa fa-star checked"></span>
                                                        @else
                                                            <span class="fa fa-star"></span>
                                                        @endif
                                                    @endfor
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if(isset($ptr->path_icon))
                                                <img src="{{asset($ptr->path_icon)}}" alt="user-avatar"
                                                     class="img-circle img-fluid">
                                            @else
                                                <img
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                                    alt="user-avatar"
                                                    class="img-circle img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="https://wa.me/{{substr_replace($ptr->nomor_telepon, "62", 0, 1)}}"
                                           class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        <a href="{{route('show.tukang.guest', $ptr->kode_tukang)}}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{route('all.tukang.guest')}}">
                    <div class="blockquote-footer text-right btn float-right">Lebih lanjut <cite title="Source Title">...</cite>
                    </div>
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--produk-->
        <div class="card card-solid">
            <blockquote class="blockquote">
                <p class="mb-0">Semua Produk</p>
            </blockquote>
            <div class="card-body pb-0">
                <div class="row scrolling-wrapper flex-row flex-nowrap ">
                    @foreach($produk as $ptr)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">

                                    <h2 class="lead"><b>{{$ptr->nama_produk}}</b></h2>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <p class="text-muted text-sm"><b>Tukang: </b> {{$ptr->name}} <br>
                                                <b>Diskripsi: </b> @if(strlen($ptr->diskripsi) < 50 ){{$ptr->diskripsi}} @else {{substr($ptr->diskripsi, 0, 50) }}
                                                ... @endif </p>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span>Alamat :
                                                    <br> {{$ptr->alamat}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                    Telepon : <br>{{$ptr->nomor_telepon}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-dollar-sign"></i></span>
                                                    Harga : <br>{{$ptr->range_min}} - {{$ptr->range_max}}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if(isset($ptr->path))
                                                @if($ptr->multipath)
                                                    @php
                                                        $myArray = explode(',', $ptr->path);
                                                    @endphp
                                                    <div id="carouselExampleControls" style="max-width:200px;width:100%"
                                                         class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @for($i = 0; $i < sizeof($myArray); $i++)
                                                                <div class="carousel-item @if($i == 0) active @endif ">
                                                                    <img class="d-block w-100"
                                                                         style="max-width:200px;width:100%"
                                                                         src="{{asset($myArray[$i])}}"
                                                                         alt="First slide">
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <a class="carousel-control-prev" href="#carouselExampleControls"
                                                           role="button"
                                                           data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next" href="#carouselExampleControls"
                                                           role="button"
                                                           data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <img src="{{asset($ptr->path)}}" alt="user-avatar"
                                                         class="img-fluid">
                                                @endif
                                            @else
                                                <img
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                                    alt="user-avatar"
                                                    class="img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="https://wa.me/{{substr_replace($ptr->nomor_telepon, "62", 0, 1)}}"
                                           class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        <button id="add_to_wish" name="add_to_wish" value="{{$ptr->kode_produk}}"
                                                class="btn btn-sm bg-danger wish">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                        <button id="send_pengajuan" name="send_pengajuan" value="{{$ptr->kode_tukang}}"
                                                class="btn btn-sm bg-primary">
                                            <i class="fas fa-paper-plane"></i> Ajukan
                                        </button>
                                        <a href="{{route('show.produk.guest', $ptr->kode_produk)}}">
                                            <button class="btn btn-sm bg-secondary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{route('all.produk.guest')}}">
                    <div class="blockquote-footer text-right btn float-right">Lebih lanjut <cite title="Source Title">...</cite>
                    </div>
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!--tukang-->
        <div class="card card-solid">
            <blockquote class="blockquote">
                <p class="mb-0">Semua Tukang</p>
            </blockquote>
            <div class="card-body pb-0">
                <div class="row scrolling-wrapper flex-row flex-nowrap ">
                    @foreach($tukang as $ptr)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">

                                    <h2 class="lead"><b>{{$ptr->name}}</b></h2>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-building"></i></span>Alamat :
                                                    <br>{{$ptr->alamat}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i
                                                            class="fas fa-lg fa-chart-area"></i></span>Area Kerja :
                                                    <br>{{$ptr->kota}}
                                                </li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                    Telepon : <br>{{$ptr->nomor_telepon}}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            @if(isset($ptr->path_icon))
                                                <img src="{{asset($ptr->path_icon)}}" alt="user-avatar"
                                                     class="img-circle img-fluid">
                                            @else
                                                <img
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                                    alt="user-avatar"
                                                    class="img-circle img-fluid">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <a href="https://wa.me/{{substr_replace($ptr->nomor_telepon, "62", 0, 1)}}"
                                           class="btn btn-sm bg-teal">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                        <a href="{{route('show.tukang.guest', $ptr->kode_tukang)}}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-user"></i> View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="{{route('all.top.tukang.guest')}}">
                    <div class="blockquote-footer text-right btn float-right">Lebih lanjut <cite title="Source Title">...</cite>
                    </div>
                </a>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/home_client.js') }}" defer></script>
    <script type="text/javascript">
        @if(\Illuminate\Support\Facades\Auth::check())
        window.Echo.channel('private-user.{{ \Illuminate\Support\Facades\Auth::id() }}')
            .listen('PrivateChannelTest', (e) => {
                alert(e.message.message);
            });
        @endif
    </script>
@endsection
