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
    <div class="col-12 pl-4 pr-4 pt-5">
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 pl-3 pr-3 pt-1 pb-1">
            <span class="text-muted" style="display: inline-block">
                Semua Tukang
            </span>
        </div>
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 p-3 mb-5">
            <div class="row d-flex align-items-stretch">
                @if($tukang->total() != 0)
                    @foreach($tukang as $ptr)
                        <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column p-0">
                            <div class="item__third">
                                <div class="container-ban">
                                    <img src="{{asset('images/def_tukang.png')}}" class="d-block w-100 p-2" alt="">
                                    <div class="bottom-left">
                                        <div class="row">
                                            <div class="col-8">
                                                <div
                                                    class="card rounded-0 border-0 bg-gray-light pt-2 pb-2 pl-4 pr-4 text-left"
                                                    style="width: 180px; opacity: 0.8">
                                                    <p class="pb-0 mb-0"><strong>{{$ptr->user->name}}</strong><br><span
                                                            class="text-muted">{{$ptr->kota}}</span><br><span
                                                            class="text-muted">{{$ptr->nomor_telepon}}</span></p>
                                                    {!! bringMeAStar(($ptr->rate*100)/5) !!}
                                                </div>
                                            </div>
                                            <div class="col-4" style="padding-top: 78px;">
                                                <button class="btn btn-info rounded-0"><i class="fa fa-arrow-right"></i>
                                                </button>
                                            </div>
                                        </div>
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
                {{ $tukang->links('pagination::bootstrap-4') }}
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
