@extends('layouts.app_client')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

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
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{'pembayaran.client'}}">Pembayaran</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                    {{--                        <div class="callout callout-info">--}}
                    {{--                            <h5><i class="fas fa-info"></i> Note:</h5>--}}
                    {{--                            This page has been enhanced for printing. Click the print button at the bottom of the--}}
                    {{--                            invoice to test.--}}
                    {{--                        </div>--}}


                    <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> Tukang Online (TUKON)
                                        <small class="float-right">Tanggal
                                            : {{indonesiaDate($data->created_at)}}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    Dari
                                    <address>
                                        <strong>{{$data_user->user->name}}</strong><br>
                                        {{$data_user->alamat}}<br>
                                        {{$data_user->kota}}<br>
                                        Phone: {{$data_user->nomor_telepon}}<br>
                                        Email: {{$data_user->user->email}}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice {{$data->id}}</b><br>
                                    <br>
                                    <b>ID PIN:</b> {{$data->pin->id}}<br>
                                    <b>Payment Due:</b> -<br>
                                    <b>Account:</b> -
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
                                            <th>Nama Proyek</th>
                                            <th>Alamat Proyek</th>
                                            <th>Tukang</th>
                                            <th>Pembayaran</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$data->pin->pengajuan->nama_proyek}}</td>
                                            <td>{{$data->pin->pengajuan->diskripsi_proyek}}</td>
                                            <td>{{$data->pin->tukang->user->name}}</td>
                                            <td>{{indonesiaRupiah($data->total_tagihan)}}</td>
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
                                    <p class="lead">Payment Methods:</p>
                                    <p class="lead">Offline</p>
                                    {{--                                    <img src="../../dist/img/credit/visa.png" alt="Visa">--}}
                                    {{--                                    <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">--}}
                                    {{--                                    <img src="../../dist/img/credit/american-express.png" alt="American Express">--}}
                                    {{--                                    <img src="../../dist/img/credit/paypal2.png" alt="Paypal">--}}

                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    {{--                                    <p class="lead">Amount Due 2/22/2014</p>--}}

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Tagihan:</th>
                                                <td>{{indonesiaRupiah($data->total_tagihan)}}</td>
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

                                    <a href="{{route('pdf.invoice', $data->id)}}" target="_blank"
                                       class="btn btn-default"><i
                                            class="fas fa-print"></i> Print</a>

                                    @if($data->pin->pembayaran->kode_status == "P01")
                                        <a href="{{route('payoffline.pembayaran.client',$data->pin->pembayaran->id)}}">
                                            <button type="button" id="btn_bayar" value="{{$data->pin->pembayaran->id}}"
                                                    class="btn btn-success float-right"><i
                                                    class="far fa-credit-card"></i> Bayar
                                            </button>
                                        </a>
                                        <button type="button" id="btn_btll" value="{{$data->pin->pembayaran->id}}" class=" btn btn-danger float-right"
                                                style="margin-right: 5px;">
                                            <i class="fas fa-unlock"></i> Batalkan
                                        </button>
                                    @elseif($data->pin->pembayaran->kode_status == "P01B")
                                        <button type="button" class="btn btn-primary float-right"
                                                style="margin-right: 5px;">
                                            <i class="fas credit-card"></i> Menunggu Konfirmasi Admin
                                        </button>
                                    @elseif($data->pin->pembayaran->kode_status == "P02")
                                        <button type="button" class="btn btn-primary float-right disabled"
                                                style="margin-right: 5px;">
                                            <i class="fas fa-toolbox"></i> Pembayaran Gagal
                                        </button>
                                    @elseif($data->pin->pembayaran->kode_status == "P03")
                                        <a href="{{route('show.project.client', $data->project->id)}}">
                                            <button type="button" class="btn btn-success float-right"><i
                                                    class="far fa-building"></i> Lihat Proyek
                                            </button>
                                        </a>
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
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pembayaran_client.js') }}" defer></script>
@endsection
