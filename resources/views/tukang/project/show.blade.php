@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    <link href="{{ asset('css/show_proyek.css') }}" rel="stylesheet">
@endsection

@section('content')
    <br>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Projects Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Pembayaran</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{indonesiaRupiah($data->pembayaran->total_tagihan)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Presentase</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{$data->persentase_progress}} %</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span
                                            class="info-box-text text-center text-muted">Estimasi pengerjaan</span>
                                        <span class="info-box-number text-center text-muted mb-0">20 (Hari)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Recent Activity</h4>
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                             alt="user image">
                                        <span class="username">
                                            Pengajuan.
                                        </span>
                                        <span
                                            class="description">Dipublikasikan - {{indonesiaDate($data->pembayaran->pin->pengajuan->created_at)}}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        {{$data->pembayaran->pin->pengajuan->diskripsi_proyek}}
                                    </p>

                                    <p>
                                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Lihat
                                            Blueprint</a>
                                    </p>
                                </div>

                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                             alt="User Image">
                                        <span class="username">
                                            Penawaran
                                        </span>
                                        <span
                                            class="description">Disetujui - {{indonesiaDate($data->pembayaran->pin->penawaran->created_at)}}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p> Komponen yang di ajukan :
                                        @foreach($data->pembayaran->pin->penawaran->komponen as $item)
                                            {{$item->nama_komponen}},
                                        @endforeach
                                    </p>
                                    <p>
                                        <a href="#" class="link text-sm"><i class="fas fa-link mr-1"></i> Lihat
                                            Penawaran</a>
                                    </p>
                                </div>

                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm"
                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                             alt="user image">
                                        <span class="username">
                                            Pembayaran.
                                        </span>
                                        <span
                                            class="description">Dibayar pada {{indonesiaDate($data->pembayaran->transaksi_pembayaran[0]->created_at)}}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Pembayaran dilakukan secara manual.
                                    </p>

                                    <p>
                                        <a href="#" class="link-black text-sm"><i class="fas fa-link mr-1"></i> Lihat
                                            Bukti Struk Pembayaran</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <br>
                        <h4><i class="fas fa-globe"></i> Tukang Online (TUKON)</h4>
                        <br>
                        <p class="text-muted">{{$data->pembayaran->pin->pengajuan->diskripsi_proyek}}</p>
                        <br>
                        <div class="text-muted">
                            <p class="text-sm">Nama Klien
                                <b class="d-block">{{$data->pembayaran->pin->pengajuan->client->user->name}}</b>
                            </p>
                            <p class="text-sm">Nama Tukang
                                <b class="d-block">{{$data->pembayaran->pin->tukang->user->name}}</b>
                            </p>
                        </div>
                        <!-- Timelime example  -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center mt-5 mb-3">
                                    @if($data->persentase_progress >= 90)
                                        @if($data->kode_status == "ON01")
                                            <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                                    class="btn btn-sm btn-success">Konfirmasi Proyek Selesai
                                            </button>
                                        @elseif($data->kode_status == "ON04")
                                            <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                                    class="btn btn-sm btn-success disabled">Menuggu konfirmasi klien
                                            </button>
                                        @elseif($data->kode_status == "ON05")
                                            <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                                    class="btn btn-sm btn-success disabled">Proyek Telah Selesai
                                            </button>
                                        @endif
                                    @endif
                                    @if($data->kode_status == "ON03")
                                        <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                                class="btn btn-sm btn-danger disabled">Proyek dibatalkan
                                        </button>
                                    @else
                                        <a href="{{route('form.upload.progress',$data->id)}}"
                                           class="btn btn-sm btn-primary">Upload
                                            Progress</a>
                                    @endif
                                </div>
                                <!-- The time line -->
                                <div class="timeline">
                                @isset($data->progress->onprogress)
                                    @foreach($data->progress->onprogress as $item)
                                        <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-info">{{indonesiaDate($item->created_at, false)}}</span>
                                            </div>
                                            <!-- /.timeline-label -->
                                        @foreach($item->doc as $doc)
                                            <!-- timeline item -->
                                                <div>
                                                    <i class="fa fa-camera bg-purple"></i>
                                                    <div class="timeline-item">
                                                        {{--                                                    <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>--}}
                                                        {{--                                                    <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new--}}
                                                        {{--                                                        photos--}}
                                                        {{--                                                    </h3>--}}
                                                        <div class="timeline-body">
                                                            <img src="{{asset($doc->path)}}" width="200px"
                                                                 height="140px" alt="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                            @endforeach
                                        @endforeach
                                    @endisset
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_project.js') }}" defer></script>
@endpush
