@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@endpush

@section('content')
    <br>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Semua perubahan akan tersimpan jika tombol <b>Kirim Penawaran</b> ditekan, pastikan untuk tidak
                    menutup halaman ini sebelum melakukan upload penawaran agar semua data tidak hilang !
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary-dx">
                    <div class="card-header">
                        <h3 class="card-title text-white">Rincihan Projek</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus text-white"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> Tukang Online (TUKON)
                                    </h4>
                                    <div class="row">
                                        <div class="col-sm-12 invoice-col">
                                            <b>PIN ID #{{ sprintf("%06d", $data->id)}}</b><br>
                                            <p>Dibuat: {{indonesiaDate($data->created_at)}}<br>
                                                @if($data->created_at == $data->updated_at) @else
                                                    Diubah: {{indonesiaDate($data->updated_at)}} @endif</p>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-6 invoice-col">
                                    Dari
                                    <address>
                                        <strong>{{$data->pengajuan->client->user->name}}</strong><br>
                                        {{$data->pengajuan->client->alamat}}<br>
                                        {{$data->pengajuan->client->kota}}<br>
                                        Nomor: {{$data->pengajuan->client->nomor_telepon}}<br>
                                        Email: {{$data->pengajuan->client->user->email}}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6 invoice-col">
                                    Ke
                                    <address>
                                        <strong>{{$tukang->user->name}}</strong><br>
                                        {{$tukang->alamat}}<br>
                                        {{$tukang->kota}}<br>
                                        Phone: {{$tukang->nomor_telepon}}<br>
                                        Email: {{$tukang->user->email}}
                                    </address>
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
                                            <th>Nama Projek</th>
                                            <th>Alamat Projek</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$data->pengajuan->nama_proyek}}</td>
                                            <td>{{$data->pengajuan->alamat}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12">
                                    <p class="lead">Deskripsi :</p>
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        {{$data->pengajuan->diskripsi_proyek}}
                                    </p>
                                </div>
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Foto :</p>
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
                                            <a class="carousel-control-prev" href="#carouselExampleControls"
                                               role="button"
                                               data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls"
                                               role="button"
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
                                    <p class="lead">Deadline : {{indonesiaDate($data->pengajuan->deadline)}}</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Range Min:</th>
                                                <td>{{indonesiaRupiah($data->pengajuan->range_min)}}</td>
                                            </tr>
                                            <tr>
                                                <th style="width:50%">Range Max:</th>
                                                <td>{{indonesiaRupiah($data->pengajuan->range_max)}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.content -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <!-- /.card -->
                <div class="card card-secondary-dx">
                    <div class="card-header">
                        <h3 class="card-title text-white">Presentase laba</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus text-white"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="fm-penawaran" method="post" action="{{route('store.penawaran.json')}}">
                            @csrf
                            <label for="inputEstimatedBudget">Harga Proyek</label>
                            <div class="input-group pb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" name="harga" id="harga" class="form-control" value="10000">
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget">Presentase</label>
                                <p>Presentase Laba akan ditambah dengan BPA (Biaya Penggunaan Aplikasi), untuk saat ini
                                    BPA
                                    diterapkan sebesar <b>{{$bpa->bpa}}% dari Total Komponen.</b></p>
                                <p> Berapa persen margin keuntungan yang anda kehendaki, presentase ini didasari oleh
                                    harga
                                    total komponen.</p>
                            </div>
                            <div class="input-group mb-3">
                                <input type="number" value="{{$data->id}}" name="kode_pin" hidden>
                                <input type="number" id="inputPresentase" class="form-control" value="10" max="100"
                                       step="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <label for="inputEstimatedBudget">Keuntungan (%)</label>
                            <div class="input-group">
                                <input type="number" id="bpa"  value="{{$bpa->bpa}}" hidden class="form-control"
                                       readonly>
                                <input type="number" id="inputKeuntunganPersen" name="keuntungan" class="form-control" value="0" readonly>
                            </div>

                            <label for="inputEstimatedBudget">Keuntungan</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" id="inputKeuntungan" class="form-control" value="0" readonly>
                            </div>

                            <label for="inputEstimatedBudget">Harga Total</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" id="inputHargaTotal" name="harga_total" class="form-control"
                                       value="0" readonly>
                            </div>

                            <label for="inputEstimatedBudget">Metode Penarikan Dana</label>
                            <p class="text-sm">Silahkan pilih pembayaran yang di inginkan.</p>
                            @foreach($spd as $item)
                                @if($item->id == 1)
                                    <div class="form-check">
                                        <input checked class="form-check-input" type="radio" name="kode_spd"
                                               id="{{$item->id}}" value="{{$item->id}}">
                                        <label class="form-check-label" for="{{$item->id}}">
                                            {{$item->nama}}
                                        </label>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kode_spd" id="{{$item->id}}"
                                               value="{{$item->id}}">
                                        <label class="form-check-label" for="{{$item->id}}">
                                            {{$item->nama}}
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ url()->previous() }}" class="btn btn-danger pl-5 pr-5">Batal</a>
                                <button type="button" id="btnsubmitpenawaran" value="{{$data->id}}"
                                        class="btn btn-primary float-right">Kirim Penawaran
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/add_penawaran_by_pengajuan_v2.js') }}" defer></script>
@endpush
