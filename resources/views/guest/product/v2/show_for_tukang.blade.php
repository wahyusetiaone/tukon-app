@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
    <style type="text/css">
        /*---------- star rating ----------*/
        .star-rating {
            display: flex;
            align-items: start;
            justify-content: left;
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

    </style>
@endsection

@section('content')
    <div class="col-12 p-0">
        <div class="card bg-white border-0 rounded-0 shadow-none">
            <div class="row">
                <div class="col-4 pl-4 pr-4 pt-5">
                    @if($data->multipath)
                        @php
                            $str_arr = explode (",", $data->path);
                        @endphp
                        <div class="col-12">
                            <img src="{{asset($str_arr[0])}}" id="targetImg"  class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            @foreach($str_arr as $item)
                                <div class="product-image-thumb active">
                                    <img src="{{asset($item)}}" name="thumnailImg"
                                         alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12">
                            <img src="{{asset($data->path)}}"
                                 class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active"><img
                                    src="{{asset($data->path)}}"
                                    alt="Product Image"></div>
                        </div>
                    @endif
                </div>
                <div class="col-8 pl-4 pr-4 pt-5">
                    <div class="row">
                        <div class="col-7">
                            <h3>{{$data->nama_produk}}</h3>
                            <div class="row d-flex  align-middle">
                                <div class="col-3">
                                    {!! bringMeAStar(($data->tukang->rate*100)/5) !!}
                                </div>
                                <div class="col-6 pt-2">
                                    <span style="color: #FFBC0B;" id="star_value"></span>  <span class="text-muted">| 5 Terpesan</span>
                                </div>
                            </div>
                            <div class="row  mt-5">
                                <div class="col-12">
                                    <div class="card bg-gray-light rounded-0 shadow-none border-0">
                                        <h2 class="text-bold p-3" style="color:#008CC6; text-align: center">{{indonesiaRupiah($data->range_min, false)}} - {{indonesiaRupiah($data->range_max, false)}}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row text-muted">
                        <div class="col-12">
                            Detail
                            <div class="card p-2 pt-4 pb-5">
                                {{$data->diskripsi}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pl-4 pr-4 pb-5">
                <div class="col-6">
                    <div class="row">
                        <div class="col-2">
                            <img class="img-circle" width="95px" height="95px" src="{{asset($data->tukang->path_icon)}}"/>
                        </div>
                        <div class="col-6 pt-2">
                            <p class="p-0 m-0">{{$data->tukang->user->name}}</p>
                            <p class="p-0 m-0">{{$data->tukang->kota}}</p>
                            <div class="row d-flex  align-middle">
                                <div class="col-5">
                                    {!! bringMeAStar(($data->tukang->rate*100)/5) !!}
                                </div>
                                <div class="col-6 pt-2">
                                    <span style="color: #FFBC0B;" id="star_value_2"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 pr-2 pt-4">
                    <div class="float-right">
                        <p class="p-0 m-0 text-bold" style="text-align: right">Kontak</p>
                        <p class="p-0 m-0 text-muted" style="text-align: right">{{$data->tukang->nomor_telepon}}</p>
                        <p class="p-0 m-0 text-muted" style="text-align: right">{{$data->tukang->user->email}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_produk_client.js') }}" defer></script>
    <script type="text/javascript">
        var frontStars = document.getElementsByClassName("front-stars")[0];
        var percentage = 100 / 5 * 4.63;
        frontStars.style.width = percentage + "%";

        var rating = document.getElementsByClassName("star-rating")[0];
        rating.title = +(4.63.toFixed(2)) + " out of " + 5;
        var starValue = document.getElementById('star_value');
        starValue.textContent = (4.63.toFixed(2));
        var starValue2 = document.getElementById('star_value_2');
        starValue2.textContent = (4.63.toFixed(2));
    </script>
@endsection
