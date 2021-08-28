@extends('layouts.app_client')


@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if($data->kode_status == "T02")
                        @if($data->pin->status == "N01")
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Note:</h5>
                                This page has been enhanced for printing. Click the print button at the bottom of the
                                invoice to
                                test.
                            </div>
                        @elseif($data->pin->status == "D01A")
                            <div class="callout callout-success">
                                <h5><i class="fas fa-check"></i> Selamat, penawaran anda disetujui.</h5>
                                Penawaran anda telah disetujui klien, segera konfirmasi persetujuan kesangupan anda
                                untuk melakukan pekerjaan projek ini !
                            </div>
                        @elseif($data->pin->status == "D02")
                            @if($data->pin->pembayaran->kode_status == "P01" || "P01B")
                                <div class="callout callout-secondary">
                                    <h5><i class="fas fa-clock"></i> Menunggu pembayaran.</h5>
                                    Projek menunggu pembayaran, mohon segera melakukan pembayaran.
                                </div>
                            @elseif($data->pin->pembayaran->kode_status == "P03")
                                <div class="callout callout-success">
                                    <h5><i class="fas fa-clock"></i> Penawaran telah diterima kedua belah pihak.</h5>
                                    Proses ini berlanjut ke tahap pengerjaan projek.
                                </div>
                            @endif
                        @endif
                    @elseif($data->kode_status == "T02A")
                        @if(isset($data->pin->kode_revisi))
                            <div class="callout callout-danger">
                                <h5><i class="fas fa-ban"></i> Penawaran Ditolak !!!</h5>
                                Penawaran telah anda tolak, tukang akan segera mengirim ulang revisi penawaran !
                                <br>
                                Catatan Penolakan : <b>{{$data->pin->revisi[0]->note}}</b>
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
                                    <strong>{{$data->pin->tukang->user->name}}</strong><br>
                                    {{$data->pin->tukang->alamat}}<br>
                                    {{$data->pin->tukang->kota}}<br>
                                    Phone: {{$data->pin->tukang->nomor_telepon}}<br>
                                    Email: {{$data->pin->tukang->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Ke
                                <address>
                                    <strong>{{$data->pin->pengajuan->client->user->name}}</strong><br>
                                    {{$data->pin->pengajuan->client->alamat}}<br>
                                    {{$data->pin->pengajuan->client->kota}}<br>
                                    Nomor: {{$data->pin->pengajuan->client->nomor_telepon}}<br>
                                    Email: {{$data->pin->pengajuan->client->user->email}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>PIN ID #{{ sprintf("%06d", $data->pin->id)}}</b><br>
                                <b>Nomor Penawaran #{{ sprintf("%06d", $data->id)}}</b><br>
                                <p>Dibuat: {{indonesiaDate($data->created_at)}}<br>
                                    @if($data->created_at == $data->updated_at) @else
                                        Diubah: {{indonesiaDate($data->updated_at)}} @endif</p>
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
                                        <td>{{$data->pin->pengajuan->nama_proyek}}</td>
                                        <td>{{$data->pin->pengajuan->alamat}}</td>
                                        <td>{{indonesiaDate($data->pin->pengajuan->deadline)}}</td>
                                        <td>{{indonesiaRupiah($data->pin->pengajuan->range_min)}}
                                            - {{indonesiaRupiah($data->pin->pengajuan->range_max)}}</td>
                                        <td>{{$data->pin->pengajuan->diskripsi_proyek}}</td>
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
                                    @foreach($data->komponen as $item)
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
                                @if($data->pin->pengajuan->multipath)
                                    @php
                                        $string_array = explode(",",$data->pin->pengajuan->path);
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
                                    <img style="max-width:200px;width:100%"
                                         src="{{asset($data->pin->pengajuan->path)}}">
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
                                            <th style="width:50%">Harga Jasa (Rp.):</th>
                                            <td>{{indonesiaRupiah(($thargakomponen*$data->keuntungan)/100)}}</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Total Harga (Rp.):</th>
                                            <td>{{indonesiaRupiah($data->harga_total)}}</td>
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
                                <a href="{{route('pdf.penawaran', $data->id)}}" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</a>
                                @if($data->kode_status == "T02" || $data->kode_status == "S02")
                                    @if($data->pin->status == "N01")
                                        <button type="button" id="tolak-btn" value="{{$kode}}/{{$data->id}}"
                                                class="btn btn-danger float-right" style="margin-right: 5px;">
                                            Tolak
                                        </button>

                                        <button type="button" id="terima-btn" value="{{$kode}}/{{$data->id}}"
                                                class="btn btn-success float-right" style="margin-right: 5px;">
                                            Terima
                                        </button>
                                    @elseif($data->pin->status == "D01A")
                                        <button type="button" disabled id="konfirmasi-btn"
                                                value="{{$data->pin->kode_penawaran}}"
                                                class="btn btn-danger float-right" style="margin-right: 5px;">
                                            Menunggu Persetujuan Tukang
                                        </button>
                                    @elseif($data->pin->status == "D02")
                                        @if($data->pin->pembayaran->kode_status == "P01" || "P01B")
                                            <button type="button" disabled id="menunggu-btn" value="{{$data->pin->id}}"
                                                    class="btn btn-secondaru float-right" style="margin-right: 5px;">
                                                Menunggu pembayaran
                                            </button>
                                        @elseif($data->pin->pembayaran->kode_status == "P03")
                                            <button type="button" disabled id="menunggu-btn" value="{{$data->pin->id}}"
                                                    class="btn btn-secondaru float-right" style="margin-right: 5px;">
                                                Lihat Projek
                                            </button>
                                        @endif
                                    @endif
                                @elseif($data->kode_status == "T02A")
                                    <button type="button" disabled class="btn btn-warning float-right">
                                        <i class="fas fa-download"></i> Menunggu Revisi Dari Tukang
                                    </button>
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
    <script src="{{ asset('js/show_pengajuan_client.js') }}" defer></script>
@endpush
