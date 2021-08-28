@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@endpush

@section('third_party_stylesheets')
    <style>
        .img-wrap {
            position: relative;
        }

        .img-wrap .close {
            color: red;
            position: absolute;
            top: 12px;
            right: 20px;
            z-index: 100;
        }
    </style>
@endsection

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Konfirmasi Pengembalian Dana.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">

                <div class="col-7">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Tukang Online(TUKON).
                                    <br>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-7 invoice-col">
                                <b>ID Transaksi Pengembalian #0000{{$data->id}}</b><br>
                                <strong>Info Pengembalian Dana</strong>
                                <address>
                                    <span
                                        class="text-muted"> Nama : </span><br><strong>{{$data->project->pembayaran->pin->tukang->user->name}}</strong><br>
                                    <span
                                        class="text-muted">Nama Proyek: </span><br>{{$data->project->pembayaran->pin->pengajuan->nama_proyek}}
                                    <br>
                                    <span class="text-muted">Status Proyek : </span><br>
                                    @if($data->project->kode_status == 'ON03')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @elseif($data->project->kode_status == 'ON05')
                                        <span class="badge badge-info">Selesai</span>
                                    @else
                                        <span class="badge badge-success">Aktif</span>
                                    @endif
                                    <br><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col">
                                <b>Pengembalian Sejumlah :</b><br> {{indonesiaRupiah($data->jmlh_pengembalian)}}<br>
                                <b>Ke No.Rek :</b><br> {{$data->transaksi[0]->nomor_rekening}}<br>
                                <b>A.N :</b><br> {{$data->transaksi[0]->atas_nama_rekening}}<br>
                                <b>BANK :</b><br> {{$data->transaksi[0]->bank}}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-12 invoice-col">
                                <strong>Rincihan Dana</strong>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Total Dana</th>
                                        <th scope="col">Dana Ditarik</th>
                                        <th scope="col">Penalty</th>
                                        <th scope="col">Total Return</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">{{indonesiaRupiah($data->project->penarikan->total_dana)}}</th>
                                        <td>
                                            {{indonesiaRupiah($data->project->penarikan->penarikan)}}
                                            <br>
                                            <span class="badge bg-danger">{{$data->project->penarikan->persentase_penarikan}}%</span>
                                        </td>
                                        <td>
                                            @php
                                                $pen = ($data->project->penarikan->total_dana * $data->penalty->value)/100;
                                                @endphp
                                            {{indonesiaRupiah($pen)}}
                                            <br>
                                            <span class="badge bg-danger">{{$data->penalty->value}}%</span>
                                        </td>
                                        <td>{{indonesiaRupiah($data->jmlh_pengembalian)}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.invoice -->

                </div>
                <div class="col-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Konfirmasi.</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <p>Apakah kamu akan mengkonfirmasi pengembalian dana ini, jika iya mohon untuk menyiapkan
                                        bukti transfer pengembalian dana ini, atau jika ingin menolak penarikan ini mohon
                                        untuk memberikan alasan penolakan.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{route('reject.show.pengembalian-dana.admin', $data->id)}}">
                                        <button type="button" class="btn btn-danger">Tolak</button>
                                    </a>
                                    <a href="{{route('accept.show.pengembalian-dana.admin', $data->id)}}">
                                        <button type="button" class="btn btn-primary">Terima</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
{{--    <script src="{{ asset('js/konfirmasi_penarikan_admin.js') }}" defer></script>--}}
@endpush
