@extends('layouts.app_client')

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>E-commerce</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Produk</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">{{$data->nama_produk}}</h3>
                            @if($data->multipath)
                                @php
                                    $str_arr = explode (",", $data->path);
                                @endphp
                                <div class="col-12">
                                    <img src="{{asset($str_arr[0])}}" class="product-image" alt="Product Image">
                                </div>
                                <div class="col-12 product-image-thumbs">
                                    @foreach($str_arr as $item)
                                        <div class="product-image-thumb active">
                                            <img src="{{asset($item)}}"
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
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">{{$data->nama_produk}}</h3>
                            <p>{{$data->diskripsi}}.</p>

                            <hr>
                            <h4>Tukang</h4>
                            Nama : {{$data->tukang->user->name}} <br>
                            Alamat : {{$data->tukang->alamat}} <br>
                            Kota : {{$data->tukang->kota}} <br>
                            Nomor HP : {{$data->tukang->nomor_telepon}} <br>
                            Email : {{$data->tukang->user->email}} <br>


                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0">
                                    {{indonesiaRupiah($data->range_max)}}
                                </h2>
                                <h4 class="mt-0">
                                    <small>Minimum : {{indonesiaRupiah($data->range_min)}} </small>
                                </h4>
                            </div>

                            <div class="mt-4">
                                <button class="btn btn-default btn-lg btn-flat" id="add_to_wish" value="{{$data->id}}">
                                    <i class="fas fa-heart fa-lg mr-2"></i>
                                    Add to Wishlist
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('third_party_scripts')
        <script src="{{ asset('js/show_produk_client.js') }}" defer></script>
@endsection
