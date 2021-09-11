@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
    <style type="text/css">
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
                            {!! bringMeAStar(($data->tukang->rate*100)/5) !!}
                        </div>
                        <div class="col-5">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script type="text/javascript">
        var frontStars = document.getElementsByClassName("front-stars")[0];
        var percentage = 100 / 5 * 4.63;
        frontStars.style.width = percentage + "%";

        var rating = document.getElementsByClassName("star-rating")[0];
        rating.title = +(4.63.toFixed(2)) + " out of " + 5;
    </script>
@endsection
