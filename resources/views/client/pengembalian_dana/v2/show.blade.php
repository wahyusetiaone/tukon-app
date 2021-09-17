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
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">PENGEMBALIAN DANA PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row">
                <div class="col-8">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <div class="row invoice-info">
                            <div class="col-sm-7 invoice-col">
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
                                <b>ID Transaksi Pengembalian #0000{{$data->id}}</b><br>
                                <b>Pengembalian Sejumlah :</b><br> {{indonesiaRupiah($data->jmlh_pengembalian)}}<br>
                                <br>
                                @if($data->hasTransaksi && $data->kode_status == "PM01")
                                    <b>Riwayat Transaksi Terakhir :</b>
                                    <br>
                                    @if($data->transaksi[0]->kode_status == 'TP02')
                                        Pengajuan pada {{indonesiaDate($data->transaksi[0]->created_at)}} <br>
                                        <strong>Ditolak</strong><br>
                                        Pesan : {{$data->transaksi[0]->catatan_penolakan}}
                                    @endif

                                @endif
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
                </div><!-- /.col -->
                <div class="col-4">
                    @if($data->kode_status != "PM01" )
                        <div class="card rounded-0">
                            <div class="card-header border-0 rounded-0">
                                <div class="callout callout-warning">
                                    <h5><i class="fas fa-info"></i> Dalam Proses:</h5>
                                    Pengajuan Pengembalian Dana dalam proses, mohon tunggu 2x24 jam.
                                </div>
                                <h3 class="card-title">Riwayat Tindakan</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                    <tr>
                                        <th>Pengajuan</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data->transaksi as $item)
                                        <tr>
                                            <td>{{indonesiaDate($item->created_at)}}</td>
                                            <td>
                                                @if($item->kode_status == "TP01")
                                                    Dalam Prosess
                                                @elseif($item->kode_status == "TP02")
                                                    Ditolak
                                                @else
                                                    Selesai
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>

                    @else
                        <div class="card card-info rounded-0">
                            <div class="card-header">
                                <h3 class="card-title">Ajukan Pengembalian Dana.</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <p>Dana yang akan dikembalikan adalah sisa dari potongan Penarikan Dana oleh Tukang
                                    serta
                                    Biaya Penalty (20%) dan juga Biaya Pengunaan Aplikasi (2%). Lebih jelasnya mohon
                                    untuk membaca keterangan disamping.</p>
                                <form id="form-ajukan" method="post"
                                      action="{{route('ajukan.pengembalian-dana.client')}}">
                                    @csrf
                                    <input type="text" value="{{$data->id}}" name="id_pengembalian" hidden>

                                    <div class="form-group">
                                        <label for="dana">Dana yang dikembalikan</label>
                                        <input type="text" value="{{indonesiaRupiah($data->jmlh_pengembalian)}}"
                                               disabled
                                               class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="nomor_rekening">Nomor Rekening</label>
                                        <input type="number"
                                               class="form-control @error('nomor_rekening') is-invalid @enderror"
                                               id="no_rekening"
                                               name="nomor_rekening"
                                               placeholder="Nomor Rekening Anda.">
                                        @error('nomor_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="atas_nama_rekening">Atas Nama Rekening</label>
                                        <input type="text"
                                               oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                               class="form-control @error('atas_nama_rekening') is-invalid @enderror"
                                               id="atas_nama_rekening"
                                               name="atas_nama_rekening"
                                               placeholder="Atas Nama Rekening.">
                                        @error('atas_nama_rekening')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="bank">BANK</label>
                                        <input type="text"
                                               oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                               class="form-control @error('bank') is-invalid @enderror"
                                               id="bank"
                                               name="bank"
                                               placeholder="BANK">
                                        @error('bank')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer bg-white">
                                <button type="button" id="btn-send" class="btn btn-info rounded-0">
                                    Kirim
                                </button>
                                <a href="{{ URL::previous() }}">
                                    <button type="button" class="btn btn-danger rounded-0">
                                        Kembali
                                    </button>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div><!-- /.row -->

        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/konfirmasi_pengembalian_client.js') }}" defer></script>
@endsection
