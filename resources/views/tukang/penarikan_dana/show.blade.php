@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    <link href="{{ asset('css/show_proyek.css') }}" rel="stylesheet">
    <style>
        .btn-squared-default {
            width: 100px !important;
            height: 100px !important;
            font-size: 24px;
            padding-top: 30px;
            margin-bottom: 8px;
        }

        .btn-squared-default:hover {
            border: 3px solid white;
            font-weight: 800;
        }
    </style>
@endsection

@section('content')
    <br>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Penarikan
                    Dana {{$data->project->pembayaran->pin->pengajuan->nama_proyek}}</h3>
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
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Total Dana</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{indonesiaRupiah($data->total_dana)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Limitasi</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{indonesiaRupiah($data->limitasi)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span
                                            class="info-box-text text-center text-muted">Penarikan</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{indonesiaRupiah($data->penarikan)}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span
                                            class="info-box-text text-center text-muted">Sisa Penarikan</span>
                                        <span
                                            class="info-box-number text-center text-muted mb-0">{{indonesiaRupiah($data->sisa_penarikan)}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span
                                            class="info-box-text text-center text-muted">Diambil</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{$data->persentase_penarikan}}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span
                                            class="info-box-text text-center text-muted">Batas Pengambilan</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{$data->limitasi_penarikan->value}}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#waiting" data-toggle="tab">Dalam Proses</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#success" data-toggle="tab">Berhasil</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#failed" data-toggle="tab">Gagal</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="waiting">
                                    @foreach($data->transaksi_penarikan as $item)
                                        @if($item->kode_status == 'PN01')
                                            <!-- Post -->
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                                             alt="user image">
                                                        <span class="username">
                                                  <a href="#">Penarikan Sebesar {{indonesiaRupiah($item->penarikan)}}</a>
                                                  <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                </span>
                                                        <span
                                                            class="description">{{indonesiaDate($item->created_at)}}</span>
                                                    </div>
                                                    <!-- /.user-block -->
                                                    <p>
                                                        {{$item->persentase->name}} dari <b>Limitasi</b> dalam prosess.
                                                    </p>
                                                </div>
                                        @endif
                                    @endforeach
                                    <!-- /.post -->
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="success">
                                    @foreach($data->transaksi_penarikan as $item)
                                        @if($item->kode_status == 'PN03' || $item->kode_status == 'PN04' || $item->kode_status == 'PN05')
                                            <!-- Post -->
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                                             alt="user image">
                                                        <span class="username">
                                                  <a href="#">Penarikan Sebesar {{indonesiaRupiah($item->penarikan)}}</a>
                                                  <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                </span>
                                                        <span
                                                            class="description">{{indonesiaDate($item->created_at)}}</span>
                                                    </div>
                                                    <!-- /.user-block -->
                                                    <p>
                                                        {{$item->persentase->name}} dari <b>Limitasi</b> berhasil
                                                        pada {{indonesiaDate($item->updated_at)}}.
                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="failed">
                                    @foreach($data->transaksi_penarikan as $item)

                                        @if($item->kode_status == 'PN02')
                                            <!-- Post -->
                                                <div class="post">
                                                    <div class="user-block">
                                                        <img class="img-circle img-bordered-sm"
                                                             src="https://upload.wikimedia.org/wikipedia/commons/a/ae/RYB.png"
                                                             alt="user image">
                                                        <span class="username">
                                                  <a href="#">Penarikan Sebesar {{indonesiaRupiah($item->penarikan)}}</a>
                                                  <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                </span>
                                                        <span
                                                            class="description">{{indonesiaDate($item->created_at)}}</span>
                                                    </div>
                                                    <!-- /.user-block -->
                                                    <p>
                                                        {{$item->persentase->name}} dari <b>Limitasi</b> Gagal
                                                        pada {{indonesiaDate($item->updated_at)}}.
                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Buat Penarikan</h3>
                            </div>
                            <!-- /.card-header -->
                            @if($verifikasiBeforePenarikan['status'])
                                <div class="card-body">
                                    <div class="container text-xs-center">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    5%
                                                </a>
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    10%
                                                </a>
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    15%
                                                </a>
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    20%
                                                </a>
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    25%
                                                </a>
                                                <a href="#"
                                                   class="btn btn-squared-default btn-outline-secondary disabled">
                                                    100%
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    @if(isset($verifikasiBeforePenarikan['message']['progress']))
                                        <p class="text-danger"><strong>{{$verifikasiBeforePenarikan['message']['progress']}}.</strong></p>
                                    @endif
                                    @if(isset($verifikasiBeforePenarikan['message']['bank']))
                                            <p class="text-danger"><strong>{{$verifikasiBeforePenarikan['message']['bank']}}.</strong></p>
                                    @endif
                                </div>
                            @else
                            <!-- form start -->
                                <form role="form">
                                    <div class="card-body">
                                        <div class="container text-xs-center">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id,5])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['5'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        5%
                                                    </a>
                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id, 10])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['10'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        10%
                                                    </a>
                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id, 15])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['15'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        15%
                                                    </a>
                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id, 20])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['20'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        20%
                                                    </a>
                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id, 25])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['25'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        25%
                                                    </a>
                                                    <a href="{{route('konfirmasi.penarikan.dana',[$data->id, 100])}}"
                                                       class="btn btn-squared-default @if(isset($avaliable['100'])) btn-primary @else btn-outline-secondary disabled @endif">
                                                        100%
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <p>Penarikan diatas berdasarkan limitasi yang berlaku saat ini yaitu
                                            <b>{{$data->limitasi_penarikan->name}}</b> dari <b>Total Dana</b>.</p>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_project.js') }}" defer></script>
@endpush
