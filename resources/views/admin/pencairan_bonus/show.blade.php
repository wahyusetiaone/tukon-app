@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <h3 class="card-title">Konfirmasi Pencairan Bonus.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">

                <div class="col-6">
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
                                <strong>Info Pencairan</strong>
                                <address>
                                    <span class="text-muted"> Nama Admin : </span><br><strong>{{$data->bonus->admin->user->name}}</strong><br>
                                    <span class="text-muted">Nama Proyek: </span><br>{{$data->bonus->project->pembayaran->pin->pengajuan->nama_proyek}}<br>
                                    <span class="text-muted">Pencairan : </span><br>{{indonesiaRupiah($data->pencairan)}}<br>
                                    <span class="text-muted">Status Proyek : </span><br>
                                    @if($data->bonus->project->kode_status == 'ON03')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @elseif($data->bonus->project->kode_status == 'ON05')
                                        <span class="badge badge-info">Selesai</span>
                                    @else
                                        <span class="badge badge-success">Aktif</span>
                                    @endif
                                        <br><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col">
                                <b>ID Transaksi Pencairan #0000{{$data->id}}</b><br>
                                <b>Pencairan Sejumlah :</b><br> {{indonesiaRupiah($data->pencairan)}}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <br>
{{--                        Catatan dari klien :--}}
{{--                        <p>{{$tr->note_transaksi}}</p>--}}
{{--                        Bukti Pembayaran :--}}
                        <br>
                        <!-- /.row -->
{{--                        <img height="500px" width="400px" src="{{asset($tr->path)}}" class="img">--}}
                    </div>
                    <!-- /.invoice -->

                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Konfirmasi.</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <p>Apakah kamu akan mengkonfirmasi pencairan ini, jika iya mohon untuk menyiapkan bukti transfer pencairan bonus ini, atau jika ingin menolak penarikan ini mohon untuk memberikan alasan penolakan.</p>
                                </div>
                                <div class="card-footer">
                                    <a href="{{route('reject.show.pencairan.admin', $data->id)}}"> <button type="button" class="btn btn-danger">Tolak</button></a>
                                    <a href="{{route('accept.show.pencairan.admin', $data->id)}}"> <button type="button" class="btn btn-primary">Terima</button></a>
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
        <script src="{{ asset('js/konfirmasi_pencairan_admin.js') }}" defer></script>
@endpush
