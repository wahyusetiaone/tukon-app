@extends('layouts.app')


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
                                    <strong>{{$data->pengajuan->client->user->name}}</strong><br>
                                    {{$data->pengajuan->client->alamat}}<br>
                                    {{$data->pengajuan->client->kota}}<br>
                                    Nomor: {{$data->pengajuan->client->nomor_telepon}}<br>
                                    Email: {{$data->pengajuan->client->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Ke
                                <address>
                                    <strong>{{$tukang->user->name}}</strong><br>
                                    {{$tukang->alamat}}<br>
                                    {{$tukang->kota}}<br>
                                    Phone: {{$tukang->nomor_telepon}}<br>
                                    Email: {{$tukang->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>PIN ID #{{ sprintf("%06d", $data->id)}}</b><br>
                                <p>Dibuat: {{indonesiaDate($data->created_at)}}<br>
                                    @if($data->created_at == $data->updated_at) @else
                                        Diubah: {{indonesiaDate($data->updated_at)}} @endif</p>
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
                                        <td>{{$data->pengajuan->nama_proyek}}</td>
                                        <td>{{$data->pengajuan->alamat}}</td>
                                        <td>{{$data->pengajuan->diskripsi_proyek}}</td>
                                    </tr>
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
                                                         src="{{url($string_array[$i])}}" alt="First slide">
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
                                    <img style="max-width:200px;width:100%" src="{{url($data->pengajuan->path)}}">
                                    @endif
                                    </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Deadline : {{indonesiaDate($data->pengajuan->deadline)}}</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Range Min:</th>
                                            <td>{{indonesiaRupiah($data->pengajuan->range_min)}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Range Max:</th>
                                            <td>{{indonesiaRupiah($data->pengajuan->range_max)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</a>
                                @if($data->kode_penawaran == null && $data->status == 'N01')
                                    <button type="button" id="tolak-btn" value="{{$data->id}}"
                                            class="btn btn-danger float-right" style="margin-right: 5px;">
                                        Tolak Pengajuan
                                    </button>
                                    <a href="{{route('add.penawaran.bypengajuan', $data->id)}}">
                                        <button type="button" class="btn btn-primary float-right"
                                                style="margin-right: 5px;">
                                            <i class="fas fa-download"></i> Terima & Kirim Penawaran
                                        </button>
                                    </a>
                                @elseif($data->kode_penawaran != null &&$data->status == 'N01')
                                    <button type="button" class="btn btn-success float-right">
                                        <i class="far fa-download"></i> Lihat Penawaran
                                    </button>
                                @elseif($data->kode_penawaran != null &&$data->status == 'T03' || $data->kode_penawaran == null &&$data->status == 'T03')
                                    <button type="button" class="btn btn-secondary float-right" disabled>
                                        <i class="far fa-trash-alt"></i> Penawaran ditolak
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_pengajuan.js') }}" defer></script>
@endpush
