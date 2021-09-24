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
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">PEMBAYARAN PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row">
                <div class="col-12 pr-4">
                    @if($data->pin->pembayaran->kode_status == "P03")
                        <a href="{{route('pdf.invoice', $data->id)}}" style="color: white; background-color: #008CC6;"
                           target="_blank" class="btn btn-default float-right border-0 rounded-0"><i
                                class="fas fa-print"></i> Print</a>
                    @endif
                </div>
                <!-- /.col -->
            </div>

            <!-- info row -->
            <div class="row invoice-info pr-3 pl-3">
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
            <div class="row pr-3 pl-3">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nama Proyek</th>
                            <th>Alamat Proyek</th>
                            <th>Penyedia Jasa</th>
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

            <div class="row pr-3 pl-3">
                <!-- accepted payments column -->
                <div class="col-6">

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
            <div class="row no-print pr-3 pl-3">
                <div class="col-12">
                    @if($data->pin->pembayaran->kode_status == "P01" && !isset($data->invoice))
                        <a href="{{route('bayar.pembayaran.client', $data->pin->pembayaran->id)}}">
                            <button type="button"
                                    class="btn btn-info float-right rounded-0 border-0 "> CheckOut
                            </button>
                        </a>
                        <button type="button" id="btn_btll" value="{{$data->pin->pembayaran->id}}"
                                class="btn btn-danger rounded-0 border-0 float-right"
                                style="margin-right: 5px;">Batalkan
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
                            <button type="button" class="btn btn-info rounded-0 float-right"><i
                                    class="far fa-building"></i> Lihat Proyek
                            </button>
                        </a>
                    @elseif($data->pin->pembayaran->kode_status == "P01" && isset($data->invoice))
                        <a href="{{$data->invoice->invoice_url}}" target="_blank">
                            <button type="button" class="btn btn-warning float-right rounded-0 border-0 text-white"><i
                                    class="far fa-clipboard"></i> Lihat Invoice
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pembayaran_client.js') }}" defer></script>
@endsection
