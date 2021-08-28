@extends('layouts.app_client')


@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="callout callout-info">
                        <h5><i class="fas fa-info"></i> Note:</h5>
                        This page has been enhanced for printing. Click the print button at the bottom of the invoice to
                        test.
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Tukang Online (TUKON)
                                </h4>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengajuan Projek</p>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
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
                        <div class="row">
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
                        <div class="row">
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

                        <div class="row">
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
                                <a class="btn btn-primary btn-sm float-right" href="{{route('edit.pengajuan.client',$data->id)}}">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit Pengajuan
                                </a>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
{{--                        <div class="row no-print">--}}
{{--                            <div class="col-12">--}}
{{--                                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i--}}
{{--                                        class="fas fa-print"></i> Print</a>--}}
{{--                                @if($data->pin[0]->kode_penawaran == null && $data->pin[0]->status == 'N01')--}}
{{--                                    <button type="button" id="tolak-btn" value="{{$data->pin[0]->id}}"--}}
{{--                                            class="btn btn-danger float-right" style="margin-right: 5px;">--}}
{{--                                        Tolak Pengajuan--}}
{{--                                    </button>--}}
{{--                                    <a href="{{route('add.penawaran.bypengajuan', $data->pin[0]->id)}}">--}}
{{--                                        <button type="button" class="btn btn-primary float-right"--}}
{{--                                                style="margin-right: 5px;">--}}
{{--                                            <i class="fas fa-download"></i> Terima & Kirim Penawaran--}}
{{--                                        </button>--}}
{{--                                    </a>--}}
{{--                                @elseif($data->pin[0]->kode_penawaran != null &&$data->pin[0]->status == 'N01')--}}
{{--                                    <a href="{{route('show.penawaran', $data->kode_penawaran)}}">--}}
{{--                                        <button type="button" class="btn btn-success float-right">--}}
{{--                                            <i class="far fa-download"></i> Lihat Penawaran--}}
{{--                                        </button>--}}
{{--                                    </a>--}}
{{--                                @elseif($data->pin[0]->kode_penawaran != null &&$data->pin[0]->status == 'T03' || $data->pin[0]->kode_penawaran == null &&$data->status == 'T03')--}}
{{--                                    <button type="button" class="btn btn-secondary float-right" disabled>--}}
{{--                                        <i class="far fa-trash-alt"></i> Penawaran ditolak--}}
{{--                                    </button>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    {{--    <script src="{{ asset('js/show_pengajuan.js') }}" defer></script>--}}
@endpush
