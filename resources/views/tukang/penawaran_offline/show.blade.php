@extends('layouts.app')


@section('content')
    <br>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
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
                                    <strong>{{$data->nama_client}}</strong><br>
                                    {{$data->alamat_client}}<br>
                                    {{$data->kota_client}}<br>
                                    Phone: {{$data->nomor_telepon_client}}<br>
                                    Email: {{$data->email_client}}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Nomor Penawaran Offline #{{ sprintf("%06d", $data->id)}}</b><br>
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
                                        <th>Diskripsi Projek</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$data->nama_proyek}}</td>
                                        <td>{{$data->alamat_proyek}}</td>
                                        <td>{{indonesiaDate($data->deadline)}}</td>
                                        <td>{{$data->diskripsi_proyek}}</td>
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
                                @if(isset($data->path))
                                    <div id="carouselExampleControls" style="max-width:200px;width:100%"
                                         class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @for($i = 0; $i < sizeof($data->path); $i++)
                                                <div class="carousel-item @if($i == 0) active @endif ">
                                                    <img class="d-block w-100" style="max-width:200px;width:100%"
                                                         src="{{asset($data->path[$i]->path)}}" alt="First slide">
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
                                            <td>{{$data->keuntungan}}
                                                %
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Keuntungan (Rp.):</th>
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
                                <a href="{{route('pdf.offline.penawaran', $data->id)}}" target="_blank" class="btn btn-primary"><i
                                        class="fas fa-print"></i> Print</a>

                                <a href="{{route('data.penawaran.offline.edit',$data->id)}}">
                                    <button type="button" class="btn btn-info float-right">
                                        <i class="fas fa-pencil-alt"></i> Edit Data Penawaran
                                    </button>
                                </a>
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
