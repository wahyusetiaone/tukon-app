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
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">PENAWARAN PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row">
                <div class="col-10 pl-3 pr-3">
                    @if($data->kode_status == "T02")
                        @if($data->pin->status == "N01")
                            <div class="pl-2 pr-2 pb-4">
                                <h5 class="text-info"><i class="fas fa-clock text-info pr-1"></i>Menunggu respon anda.</h5>
                                <span class="text-info">
                                    Penawaran telah dikirim sebagai berikut.
                                    </span>
                            </div>
                        @elseif($data->pin->status == "D02")
                            @if($data->pin->pembayaran->kode_status == "P01" || "P01B")
                                <div class="pl-2 pr-2 pb-4">
                                    <h5 class="text-info"><i class="fas fa-clock text-info pr-1"></i>Menunggu pembayaran.</h5>
                                    <span class="text-info">
                                    Projek menunggu pembayaran, mohon segera melakukan pembayaran.
                                    </span>
                                </div>
                            @elseif($data->pin->pembayaran->kode_status == "P03")
                                <div class="pl-2 pr-2 pb-4">
                                    <h5 class="text-info"><i class="fas fa-clock text-info pr-1"></i> Penawaran telah diterima kedua belah pihak.</h5>
                                    <span class="text-info">
                                    Proses ini berlanjut ke tahap pengerjaan projek.
                                    </span>
                                </div>
                            @endif
                        @endif
                    @elseif($data->kode_status == "T02A")
                        @if(isset($data->pin->kode_revisi))
                            <div class="pl-2 pr-2 pb-4">
                                <h5 class="text-red"><i class="fas fa-ban text-red pr-1"></i> Penawaran Ditolak !!!</h5>
                                <span class="text-red">Penawaran telah anda tolak, tukang akan segera mengirim ulang revisi penawaran !
                                <br>
                                Catatan Penolakan : <b>{{$data->pin->revisi[0]->note}}</b>
                                </span>
                            </div>
                        @else
                            <div class="pl-2 pr-2 pb-4">
                                <h5 class="text-red"><i class="fas fa-ban text-red pr-1"></i> Penawaran Ditolak !!!</h5>
                                <span class="text-red">Penawaran telah anda tolak, tukang akan segera mengirim ulang revisi penawaran !</span>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="col-2 pr-4  ">
                    <a href="{{route('pdf.penawaran', $data->id)}}" style="color: white; background-color: #008CC6;" target="_blank" class="btn btn-default float-right border-0 rounded-0"><i
                            class="fas fa-print"></i> Print</a>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info pr-3 pl-3">
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
            <div class="row pr-3 pl-3">
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
            <div class="row pr-3 pl-3">
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
            <div class="row pr-3 pl-3">
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
            <div class="row no-print pr-3 pl-3">
                <div class="col-12">
                    @if($data->kode_status == "T02" || $data->kode_status == "S02")
                        @if($data->pin->status == "N01")
                            <button type="button" id="tolak-btn" value="{{$kode}}/{{$data->id}}"
                                    class="btn btn-danger float-right border-0 rounded-0" style="margin-right: 5px;">
                                Tolak
                            </button>

                            <button type="button" id="terima-btn" value="{{$kode}}/{{$data->id}}"
                                    class="btn btn-success float-right border-0 rounded-0" style="color: white; background-color: #008CC6;margin-right: 5px;">
                                Terima
                            </button>
                        @elseif($data->pin->status == "D01A")
                            <p class="text-muted float-right">Menunggu Persetujuan Tukang</p>
                        @elseif($data->pin->status == "D02")
                            @if($data->pin->pembayaran->kode_status == "P01" || "P01B")
                                <p class="text-muted float-right">Menunggu Pembayaran</p>
                            @elseif($data->pin->pembayaran->kode_status == "P03")
                                <p class="text-muted float-right">Lihat Proyek</p>
                            @endif
                        @endif
                    @elseif($data->kode_status == "T02A")
                        <p class="text-muted float-right">Menunggu Revisi dari Tukang</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pengajuan_client.js') }}" defer></script>
@endsection
