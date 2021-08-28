@extends('layouts.app')

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
            <h3 class="card-title">Konfirmasi Pembayaran.</h3>
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
                                    <i class="fas fa-globe"></i> AdminLTE, Inc.
                                    <small class="float-right">Date: 2/10/2014</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            @php
                                $tr = array();
                                foreach ($data->transaksi_pembayaran as $item){
                                    if ($item->status_transaksi == 'A01'){
                                        $tr = $item;
                                    }
                                }

                            @endphp
                            <div class="col-sm-7 invoice-col">
                                From
                                <address>
                                    <strong>{{$data->pin->pengajuan->client->user->name}}</strong><br>
                                    {{$data->pin->pengajuan->client->kota}}<br>
                                    {{$data->pin->pengajuan->client->alamat}}<br>
                                    Phone: {{$data->pin->pengajuan->client->nomor_telepon}}<br>
                                    Email: {{$data->pin->pengajuan->client->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col">
                                <b>Invoice #0000{{$data->id}}</b><br>
                                <br>
                                <b>Tgl Pembayaran:</b><br> {{indonesiaDate($tr->created_at)}}<br>
                                <b>Total Pembayaran:</b><br> {{indonesiaRupiah($data->total_tagihan)}}
                            </div>
                            <!-- /.col -->
                        </div>
                        <br>
                        Catatan dari klien :
                        <p>{{$tr->note_transaksi}}</p>
                        Bukti Pembayaran :
                        <br>
                        <!-- /.row -->
                        <img height="500px" width="400px" src="{{asset($tr->path)}}" class="img">
                    </div>
                    <!-- /.invoice -->

                </div>
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Konfirmasi.</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="form-confirm" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="text" value="{{$tr->id}}" name="id_transaksi" hidden>
                                    <label for="note_return_transaksi">Catatan</label>
                                    <textarea type="text"
                                              class="form-control @error('note_return_transaksi') is-invalid @enderror"
                                              id="note_return_transaksi"
                                              name="note_return_transaksi"
                                              placeholder="Pembayaran telah kami terima."></textarea>
                                    @error('note_return_transaksi')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="btn-tolak" value="{{$data->id}}" class="btn btn-danger">Tolak</button>
                            <button type="button" id="btn-terima" value="{{$data->id}}" class="btn btn-primary">Terima</button>
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
        <script src="{{ asset('js/konfirmasi_pembayaran_admin.js') }}" defer></script>
@endpush
