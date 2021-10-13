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
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">DETAIL PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
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
                                    <span class="info-box-number text-center text-muted mb-0">{{$data->progress->deadlineinday}} Hari</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 pb-0">Nama Proyek</p>
                                        <h6 class="mt-0 pt0">{{$data->pembayaran->pin->pengajuan->nama_proyek}}</h6>
                                    </div>
                                    <div class="col-3 border-left border-right">
                                        <p class="text-muted mb-0 pb-0 text-center">Klien</p>
                                        <h6 class="mt-0 pt0 text-center">{{$data->pembayaran->pin->pengajuan->client->user->name}}</h6>
                                    </div>
                                    <div class="col-3">
                                        <p class="text-muted mb-0 pb-0 text-center">Penyedia Jasa</p>
                                        <h6 class="mt-0 pt0 text-center">{{$data->pembayaran->pin->tukang->user->name}}</h6>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-muted mb-0 pt-3 pb-0">Detail Proyek</p>
                                        <h6 class="mt-0 pt0">{{$data->pembayaran->pin->pengajuan->diskripsi_proyek}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <div class="post clearfix">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active rounded-0" href="#activity"
                                                            data-toggle="tab">Aktifitas</a></li>
                                    <li class="nav-item"><a class="nav-link rounded-0" href="#timeline" data-toggle="tab">Penarikan
                                            Dana</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle"
                                                 src="{{asset('images/icons/icon_checklist.svg')}}"
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
                                            <a href="{{route('show.pengajuan.client',$data->pembayaran->pin->pengajuan->id)}}" class="text-sm"><i class="fas fa-link mr-1"></i>
                                                Lihat
                                                Pengajuan</a>
                                        </p>
                                    </div>

                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle"
                                                 src="{{asset('images/icons/icon_checklist.svg')}}"
                                                 alt="User Image">
                                            <span class="username">
                                            Penawaran
                                        </span>
                                            <span
                                                class="description">Disetujui - {{indonesiaDate($data->pembayaran->pin->penawaran->created_at)}}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            <a href="{{route('show.penawaran.client',$data->pembayaran->pin->penawaran->id)}}" class="link text-sm"><i class="fas fa-link mr-1"></i> Lihat
                                                Penawaran</a>
                                        </p>
                                    </div>

                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle"
                                                 src="{{asset('images/icons/icon_checklist.svg')}}"
                                                 alt="user image">
                                            <span class="username">
                                            Pembayaran.
                                        </span>
                                            @if(isset($data->pembayaran->transaksi_pembayaran) && sizeof($data->pembayaran->transaksi_pembayaran) !=0 )
                                                <span
                                                    class="description">Dibayar pada {{indonesiaDate($data->pembayaran->transaksi_pembayaran[0]->created_at)}}</span>
                                            @endif
                                            @if(isset($data->pembayaran->invoice))
                                                <span
                                                    class="description">Dibayar pada {{indonesiaDate($data->pembayaran->invoice->updated_at)}}</span>
                                            @endif
                                        </div>
                                        <!-- /.user-block -->
                                        @if(isset($data->pembayaran->transaksi_pembayaran) && sizeof($data->pembayaran->transaksi_pembayaran) !=0 )

                                            <p>
                                                Pembayaran dilakukan secara manual.
                                            </p>
                                        @endif
                                        @if(isset($data->pembayaran->invoice))

                                            <p>
                                                Pembayaran dilakukan secara digital.
                                            </p>
                                        @endif

                                        <p>
                                            <a href="{{route('show.pembayaran.client', $data->pembayaran->id)}}" class="text-sm"><i class="fas fa-link mr-1"></i>
                                                Lihat Pembayaran</a>
                                        </p>
                                    </div>
                                </div>
                                <div class="tab-pane" id="timeline">

                                    @if(isset($data->penarikan->transaksi_penarikan))
                                        @foreach($data->penarikan->transaksi_penarikan as $item)
                                            <div class="post clearfix">
                                                <div class="user-block">
                                                    <img class="img"
                                                         src="{{asset('images/icons/penarikan_dana.svg')}}"
                                                         alt="User Image">
                                                    <span class="username">
                                                    Penarikan Sebesar {{indonesiaRupiah($item->penarikan)}}
                                                </span>
                                                    <span class="description">
                                                        @if($item->kode_status == "PN01")
                                                            Diajukan - {{indonesiaDate($item->created_at)}}
                                                        @elseif($item->kode_status == "PN02")
                                                            Ditolak - {{indonesiaDate($item->updated_at)}}
                                                        @elseif($item->kode_status == "PN03")
                                                            Disetujui - {{indonesiaDate($item->updated_at)}}
                                                        @elseif($item->kode_status == "PN03")
                                                            Diajukan ke admin - {{indonesiaDate($item->updated_at)}}
                                                        @elseif($item->kode_status == "PN03")
                                                            Dicairkan - {{indonesiaDate($item->updated_at)}}
                                                        @endif
                                                    </span>
                                                </div>
                                                <!-- /.user-block -->
                                                @if($item->kode_status == "PN01")
                                                    <p>
                                                        Menuggu konfirmasi anda !!!
                                                    </p>

                                                    <p>
                                                        <button class="btn btn-info rounded-0" id="btnPenarikan"
                                                                name="btnTerima"
                                                                value="{{$data->penarikan->id}}/{{$item->id}}"><i
                                                                class="fas fa-link mr-1"></i>
                                                            Terima
                                                        </button>
                                                        <button class="btn btn-danger rounded-0" name="btnTolak"
                                                                value="{{$data->penarikan->id}}/{{$item->id}}"><i
                                                                class="fas fa-link mr-1"></i>
                                                            Tolak
                                                        </button>
                                                    </p>
                                                @elseif($item->kode_status == "PN02")
                                                    <p>
                                                        Anda Menolak penarikan ini.
                                                    </p>
                                                @elseif($item->kode_status == "PN03")
                                                    <p>
                                                        Anda Menyetujui penarikan ini.
                                                    </p>
                                                @elseif($item->kode_status == "PN04")
                                                    <p>
                                                        Penarikan ini sedang di proses admin.
                                                    </p>
                                                @elseif($item->kode_status == "PN05")
                                                    Dicairkan - {{indonesiaDate($item->updated_at)}}
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">Tidak ada data.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center mt-5 mb-3">
                                @if($data->kode_status == 'ON04')
                                    <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                            class="btn btn-info"
                                            class="btn btn-sm btn-primary">Konfirmasi Selesai Proyek.
                                    </button>
                                @elseif($data->kode_status == "ON03")
                                    <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                            class="btn btn-sm btn-danger disabled">Proyek dibatalkan
                                    </button>
                                    <br>
                                    <br>
                                    <a href="{{route('show.pengembalian-dana.client', $data->pengembalian->id)}}">
                                        <button id="btnAjukanPengembalianDana"
                                                class="btn btn-info ">Ajukan Pengembalian Dana
                                        </button>
                                    </a>
                                @elseif($data->kode_status == "ON05")
                                    <button value="{{$data->id}}" id="btnKonfirmasiSelesaiProyek"
                                            class="btn btn-sm btn-info disabled">Proyek Telah Selesai
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <!-- Timelime example  -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <div class="text-muted">
                                <p class="text-sm">Progress</p>
                            </div>
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
                                                <i class="fa fa-camera bg-info"></i>
                                                <div class="timeline-item">
                                                        <span class="time"><i
                                                                class="fas fa-clock"></i> {{masaLalu($doc->created_at)}}</span>
                                                    <h3 class="timeline-header"><span class="text-bold">{{$data->pembayaran->pin->tukang->user->name}}</span>
                                                        upload foto baru.
                                                    </h3>
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
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_project_client.js') }}" defer></script>
@endsection
