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
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="col-12 p-4">

        <div class="card bg-white border-0 rounded-0 shadow-none">
            <div class="row">
                <div class="col-12 p-2 pl-4 pr-4">
                    Wishlist
                </div>
            </div>
        </div>
        <div class="card bg-white border-0 rounded-0 shadow-none">
            <div class="row">
                <div class="col-12 p-4">
                    @foreach($data['data'] as $dat)
                        <div class="card shadow-none bg-gray-light pl-3 pr-3 pt-1 mb-2 d-flex mb-0 rounded-0">
                            <div class="row">
                                <div class="col-1 my-auto">
                                    <label>
                                        <input type="checkbox" name="wish-{{$dat['produk']['tukang']['id']}}"
                                               value="{{$dat['produk']['tukang']['id']}}"/>
                                    </label>
                                </div>
                                <div class="col-11">
                                    <div class="row">
                                        <div class="col-3">
                                            <p class="text-muted mb-0 pb-0">Nama Proyek</p>
                                            <h6 class="mt-0 pt0">
                                                {{$dat['produk']['nama_produk']}}
                                            </h6>
                                        </div>
                                        <div class="col-2">
                                            <p class="text-muted mb-0 pb-0">Tukang</p>
                                            <h6 class="mt-0 pt0">
                                                {{$dat['produk']['tukang']['user']['name']}}
                                            </h6>
                                        </div>
                                        <div class="col-2">
                                            <p class="text-muted mb-0 pb-0">Peringtak Tukang</p>
                                            <h6 class="mt-0 pt0">
                                                {!! bringMeAStar(($dat['produk']['tukang']['rate']*100)/5) !!}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            @if($dat['produk']['multipath'])
                                                @php
                                                    $mpath = $dat['produk']['path'];
                                                    $apath = explode(',',$mpath);
                                                    $cpath = count($apath);
                                                @endphp
                                                <li class="list-inline-item">
                                                    <div id="carouselExampleIndicators" class="carousel slide"
                                                         data-ride="carousel">
                                                        <ol class="carousel-indicators">
                                                            @for($i=0;$i<$cpath;$i++)
                                                                <li data-target="#carouselExampleIndicators"
                                                                    data-slide-to="{{$i}}"
                                                                    class="{{ $i == 0  ? 'active' : '' }}"></li>
                                                            @endfor
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            @foreach($apath as $key=>$path)
                                                                <div class="carousel-item {{ $key == 0  ? 'active' : '' }}">
                                                                    <img class="d-block w-100" src="{{asset($path)}}"
                                                                         alt="First slide">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    {{--                                                <img alt="Img" class="img-thumbnail" src="{{url($path)}}">--}}
                                                </li>
                                            @else
                                                <li class="list-inline-item">
                                                    <img alt="Img" class="img-thumbnail"
                                                         src="{{asset($dat['produk']['path'])}}">
                                                </li>
                                            @endif
                                        </div>
                                        <div class="col-10">
                                            <div class="float-right" style="padding-top: 80px;">
                                                <button class="btn btn-info rounded-0 btn-sm" id="send_pengajuan" name="send_pengajuan" value="{{$dat['produk']['tukang']['id']}}">
                                                    <i class="fas fa-paper-plane">
                                                    </i>
                                                    Kirim Pengajuan
                                                </button>
                                                <button class="btn btn-danger rounded-0 btn-sm" value="{{$dat['id']}}" id="btn_remove_wishlist" name="btn_remove_wishlist">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            @foreach($data['links'] as $dat)
                                <li class="page-item {{$dat['active'] ? "active" : ""}} {{$dat['url'] ?? 'disabled'}}">
                                    <a class="page-link" href="{{$dat['url']}}">@php echo $dat['label']; @endphp</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <a name="send-multi" href="#" class="float" data-toggle="tooltip" data-placement="left" title="Kirim pengajuan ke banyak tukang">
            <i class="fa fa-paper-plane my-float"></i>
        </a>
        <a href="#" class="second-float">
            <h3 class="fa my-second-float text-sm" id="count">0</h3>
        </a>
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
        var starValue = document.getElementById('star_value');
        starValue.textContent = (4.63.toFixed(2));
        var starValue2 = document.getElementById('star_value_2');
        starValue2.textContent = (4.63.toFixed(2));
    </script>
    <script src="{{ asset('js/wishlist.js') }}" defer></script>

@endsection
