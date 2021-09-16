@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
@endsection

@section('content')
    <div class="col-12 p-4">
        <div class="card bg-white border-0 rounded-0 shadow-none p-3">
            <!-- title row -->
            <div class="row pl-3 pr-3">
                <div class="col-8">
                    <a style="color: black;" href="{{ url()->previous() }}"><i class="fas fa-chevron-left"></i> KEMBALI</a>
                </div>
                <div class="col-4">
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">PENAWARAN PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <!-- info row -->
            <div class="row invoice-info pl-3 pr-3">
                <div class="col-sm-4 invoice-col">
                    Dari
                    <address>
                        <strong>{{$data->client->user->name}}</strong><br>
                        {{$data->client->alamat}}<br>
                        {{$data->client->kota}}<br>
                        Nomor: {{$data->client->nomor_telepon}}<br>
                        Email: {{$data->client->user->email}}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>PIN ID #{{ sprintf("%06d", $data->pin[0]->id)}}</b><br>
                    <p>Dibuat: {{indonesiaDate($data->pin[0]->created_at)}}<br>
                        @if($data->pin[0]->created_at == $data->pin[0]->updated_at) @else
                            Diubah: {{indonesiaDate($data->pin[0]->updated_at)}} @endif</p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row pl-3 pr-3">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nama Projek</th>
                            <th>Alamat Projek</th>
                            <th>Diskripsi Projek</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$data->nama_proyek}}</td>
                            <td>{{$data->alamat}}</td>
                            <td>{{$data->diskripsi_proyek}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <br>
            <!-- Table row -->
            <div class="row pl-3 pr-3">
                <div class="col-12 table-responsive">
                    <h5>Tukang yang menerima pengajuan.</h5>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nama Tukang</th>
                            <th>Alamat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data->pin as $item)
                            <tr>
                                <td>{{$item->tukang->user->name}}</td>
                                <td>{{$item->tukang->alamat}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row pl-3 pr-3">
                <!-- accepted payments column -->
                <div class="col-6">
                    <p class="lead">Foto:</p>
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    @if($data->multipath)
                        @php
                            $string_array = explode(",",$data->path);
                        @endphp
                        <div id="carouselExampleControls" style="max-width:200px;width:100%"
                             class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @for($i = 0; $i < sizeof($string_array); $i++)
                                    <div class="carousel-item @if($i == 0) active @endif ">
                                        <img class="d-block w-100" style="max-width:200px;width:100%"
                                             src="{{asset($string_array[$i])}}" alt="First slide">
                                    </div>
                                @endfor
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                               data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                               data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    @else
                        <img style="max-width:200px;width:100%" src="{{asset($data->path)}}">
                        @endif
                        </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <p class="lead">Deadline : {{indonesiaDate($data->deadline)}}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Range Min:</th>
                                <td>{{indonesiaRupiah($data->range_min)}}</td>
                            </tr>
                            <tr>
                                <th style="width:50%">Range Max:</th>
                                <td>{{indonesiaRupiah($data->range_max)}}</td>
                            </tr>
                        </table>
                    </div>
                    <a class="btn btn-info rounded-0 btn-sm float-right" href="{{route('edit.pengajuan.client',$data->id)}}">
                        Edit Pengajuan
                    </a>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pengajuan_client.js') }}" defer></script>
@endsection
