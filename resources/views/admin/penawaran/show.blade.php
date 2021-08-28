@extends('layouts.app')


@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if($data->penawaran->kode_status == "T02")
                        @if($data->status == "N01")
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                This page has been enhanced for printing. Click the print button at the bottom of the
                                invoice to
                                test.
                            </div>
                        @elseif($data->status == "D01A")
                            <div class="callout callout-success">
                                <h5><i class="fas fa-check"></i> Selamat, penawaran anda disetujui.</h5>
                                Penawaran anda telah disetujui klien, segera konfirmasi persetujuan kesangupan anda
                                untuk melakukan pekerjaan projek ini !
                            </div>
                        @elseif($data->status == "D02")
                            @if($data->pembayaran->kode_status == "P01" )
                                <div class="callout callout-secondary">
                                    <h5><i class="fas fa-clock"></i> Menunggu pembayaran dilakuan oleh Klien.</h5>
                                    Projek menunggu pembayaran dari klien.
                                </div>
                            @elseif($data->pembayaran->kode_status == "P01B")
                                <div class="callout callout-secondary">
                                    <h5><i class="fas fa-clock"></i> Klien telah berhasil melakukan pembayaran.</h5>
                                    Klien telah melakukan pembayaran, pembayaran menuggu validasi dari admin.
                                </div>
                            @elseif($data->pembayaran->kode_status == "P03")
                                <div class="callout callout-success">
                                    <h5><i class="fas fa-clock"></i> Penawaran telah diterima.</h5>
                                    Proses ini berlanjut ke tahap pengerjaan projek.
                                </div>
                            @endif
                        @endif
                    @elseif($data->penawaran->kode_status == "T02A")
                        @if(isset($data->kode_revisi))
                            <div class="callout callout-danger">
                                <h5><i class="fas fa-ban"></i> Penawaran Ditolak !!!</h5>
                                Penawaran anda ditolak, mohon untuk mengajukan ulang revisi penawaran !
                                <br>
                                Catatan Penolakan : <b>{{$data->revisi[0]->note}}</b>
                            </div>
                        @else
                            <div class="callout callout-danger">
                                <h5><i class="fas fa-ban"></i> Penawaran Ditolak !!!</h5>
                                Penawaran anda ditolak, mohon untuk mengajukan ulang revisi penawaran !
                            </div>
                    @endif
                @endif


                <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Tukang Online (TUKON)
                                </h4>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penawaran Projek</p>

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Dari
                                <address>
                                    <strong>{{$data->tukang->user->name}}</strong><br>
                                    {{$data->tukang->alamat}}<br>
                                    {{$data->tukang->kota}}<br>
                                    Phone: {{$data->tukang->nomor_telepon}}<br>
                                    Email: {{$data->tukang->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Ke
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
                                <b>PIN ID #{{ sprintf("%06d", $data->id)}}</b><br>
                                <b>Nomor Penawaran #{{ sprintf("%06d", $data->penawaran->id)}}</b><br>
                                <p>Dibuat: {{indonesiaDate($data->penawaran->created_at)}}<br>
                                    @if($data->penawaran->created_at == $data->penawaran->updated_at) @else
                                        Diubah: {{indonesiaDate($data->penawaran->updated_at)}} @endif</p>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h5>Informasi Projek</h5>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nama Projek</th>
                                        <th>Alamat Projek</th>
                                        <th>Dealine</th>
                                        <th>Range Harga</th>
                                        <th>Diskripsi Projek</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$data->pengajuan->nama_proyek}}</td>
                                        <td>{{$data->pengajuan->alamat}}</td>
                                        <td>{{indonesiaDate($data->pengajuan->deadline)}}</td>
                                        <td>{{indonesiaRupiah($data->pengajuan->range_min)}}
                                            - {{indonesiaRupiah($data->pengajuan->range_max)}}</td>
                                        <td>{{$data->pengajuan->diskripsi_proyek}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h5>Informasi Penawaran Projek</h5>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nama Komponen</th>
                                        <th>Merk / Type</th>
                                        <th>Spesifikasi Teknis</th>
                                        <th>Satuan</th>
                                        <th>Total Item</th>
                                        <th>Harga Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $thargakomponen = 0;
                                    @endphp
                                    @foreach($data->penawaran->komponen as $item)
                                        <tr>
                                            <td>{{$item->nama_komponen}}</td>
                                            <td>{{$item->merk_type}}</td>
                                            <td>{{$item->spesifikasi_teknis}}</td>
                                            <td>{{$item->satuan}}</td>
                                            <td>{{$item->total_unit}}</td>
                                            <td>{{indonesiaRupiah($item->harga)}}</td>
                                            @php
                                                $thargakomponen += $item->harga;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Foto:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                @if($data->pengajuan->multipath)
                                    @php
                                        $string_array = explode(",",$data->pengajuan->path);
                                    @endphp
                                    <div id="carouselExampleControls" style="max-width:200px;width:100%"
                                         class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @for($i = 0; $i < sizeof($string_array); $i++)
                                                <div class="carousel-item @if($i == 0) active @endif ">
                                                    <img class="d-block w-100" style="max-width:200px;width:100%"
                                                         src="{{asset($string_array[$i])}}" alt="First slide">
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
                                    <img style="max-width:200px;width:100%" src="{{asset($data->pengajuan->path)}}">
                                    @endif
                                    </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Informasi Harga</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Total Harga Komponen:</th>
                                            <td>{{indonesiaRupiah($thargakomponen)}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Keuntungan (%):</th>
                                            <td>{{$data->penawaran->keuntungan}}
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Keuntungan (Rp.):</th>
                                            <td>{{indonesiaRupiah(($thargakomponen*$data->penawaran->keuntungan)/100)}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Total Harga (Rp.):</th>
                                            <td>{{indonesiaRupiah($data->penawaran->harga_total)}}</td>
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
                                @if($data->penawaran->kode_status == "T02" || $data->penawaran->kode_status == "S02")
                                    @if($data->status == "N01")
                                        <button type="button" disabled id="menunggu-btn" value="{{$data->id}}"
                                                class="btn btn-danger float-right" style="margin-right: 5px;">
                                            Menunggu response klien
                                        </button>
                                    @elseif($data->status == "D01A")
                                        <button type="button" id="konfirmasi-btn" disabled value="{{$data->kode_penawaran}}"
                                                class="btn btn-info float-right" style="margin-right: 5px;">
                                            Konfirmasi Persetujuan
                                        </button>
                                    @elseif($data->status == "D02")
                                        @if($data->pembayaran->kode_status == "P01")
                                            <button type="button" disabled id="menunggu-btn" value="{{$data->id}}"
                                                    class="btn btn-secondaru float-right" style="margin-right: 5px;">
                                                Menunggu pembayaran klien
                                            </button>
                                        @elseif($data->pembayaran->kode_status == "P01B")
                                            <button type="button" disabled id="menunggu-btn" value="{{$data->id}}"
                                                    class="btn btn-secondaru float-right" style="margin-right: 5px;">
                                                Klien telah melakukan pembayaran, menuggu konfirmasi admin
                                            </button>
                                        @elseif($data->pembayaran->kode_status == "P03")
                                            <button type="button" disabled id="menunggu-btn" value="{{$data->id}}"
                                                    class="btn btn-secondaru float-right" style="margin-right: 5px;">
                                                Lihat Projek
                                            </button>
                                        @endif
                                    @endif
                                @elseif($data->penawaran->kode_status == "T02A")
                                    <a href="{{route('edit.penawaran', $data->kode_penawaran)}}">
                                        <button type="button" class="btn btn-warning float-right">
                                            <i class="fas fa-download"></i> Ajukan Ulang Revisi
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
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_pengajuan.js') }}" defer></script>
@endpush
