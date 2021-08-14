@extends('layouts.app_client')

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Semua Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Semua produk</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Produk</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body pb-0">
                            <div class="row d-flex align-items-stretch">
                                @if($produk->total() != 0)
                                    @foreach($produk as $ptr)
                                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                            <div class="card bg-light d-flex flex-fill">
                                                <div class="card-header text-muted border-bottom-0">

                                                    <h2 class="lead"><b>{{$ptr->nama_produk}}</b></h2>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <p><b>Tukang: </b>{{$ptr->tukang->user->name}} </p>
                                                            <p><b>Diskripsi: </b> @if(strlen($ptr->diskripsi) < 50 ){{$ptr->diskripsi}} @else {{substr($ptr->diskripsi, 0, 50)}}
                                                            ... @endif </p>
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                <li class="small"><span class="fa-li"><i
                                                                            class="fas fa-lg fa-building"></i></span>Alamat :
                                                                    <br> {{$ptr->tukang->alamat}}
                                                                </li>
                                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                                                    Telepon : <br>{{$ptr->tukang->nomor_telepon}}
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
                                                                    <div id="carouselExampleControls"
                                                                         style="max-width:200px;width:100%"
                                                                         class="carousel slide" data-ride="carousel">
                                                                        <div class="carousel-inner">
                                                                            @for($i = 0; $i < sizeof($myArray); $i++)
                                                                                <div
                                                                                    class="carousel-item @if($i == 0) active @endif ">
                                                                                    <img class="d-block w-100"
                                                                                         style="max-width:200px;width:100%"
                                                                                         src="{{asset($myArray[$i])}}"
                                                                                         alt="First slide">
                                                                                </div>
                                                                            @endfor
                                                                        </div>
                                                                        <a class="carousel-control-prev"
                                                                           href="#carouselExampleControls"
                                                                           role="button"
                                                                           data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                                                            <span class="sr-only">Previous</span>
                                                                        </a>
                                                                        <a class="carousel-control-next"
                                                                           href="#carouselExampleControls"
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
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                <li class="small"><span class="fa-li"><i
                                                                            class="fas fa-lg fa-dollar-sign"></i></span>
                                                                    Harga : <br>{{$ptr->range_min}}
                                                                    - {{$ptr->range_max}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <button id="add_to_wish" value="{{$ptr->id}}"
                                                                class="btn btn-sm bg-danger">
                                                            <i class="fas fa-cart-plus"></i>
                                                        </button>
                                                        <button id="send_pengajuan" value="{{$ptr->kode_tukang}}"
                                                                class="btn btn-sm bg-primary">
                                                            <i class="fas fa-paper-plane"></i> Ajukan
                                                        </button>
                                                        <a href="{{route('show.produk.guest', $ptr->id)}}">
                                                            <button class="btn btn-sm bg-secondary">
                                                                <i class="fas fa-eye"></i> Lihat
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    Belum Ada Produk.
                                @endif
                            </div>
                        </div><!-- /.card-body -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-center">
                                {{ $produk->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/all_produk_guest.js') }}" defer></script>
@endsection
