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
                    Semua perubahan akan tersimpan jika tombol <b>Update Data Penawaran</b> ditekan, pastikan untuk tidak
                    menutup halaman ini sebelum melakukan upload penawaran agar semua data tidak hilang !
                </div>
            </div>
            <div class="col-md-6">

                <div class="card card-primary-dx">
                    <div class="card-header">
                        <h3 class="card-title text-white">Informasi Klien</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus text-white"></i></button>
                        </div>
                    </div>
                    <!-- form start -->
                    <form id="formupdateinfoclient" role="form" method="post"
                          action="{{route('data.penawaran.offline.update_client', $data->id)}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_client">Nama Klien</label>
                                <input type="text" value="{{$data->nama_client}}"
                                       class="form-control @error('nama_client') is-invalid @enderror"
                                       id="nama_client" name="nama_client" placeholder="Nama Klient">
                                @error('nama_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email_client">Email</label>
                                <input type="text" value="{{$data->email_client}}"
                                       class="form-control @error('email_client') is-invalid @enderror"
                                       id="email_client" name="email_client" placeholder="Email">
                                @error('email_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nomor_telepon_client">Nomor Telepon</label>
                                <input type="text" pattern="[0-9]{1,13}" value="{{$data->nomor_telepon_client}}"
                                       class="form-control @error('nomor_telepon_client') is-invalid @enderror"
                                       id="nomor_telepon_client" name="nomor_telepon_client"
                                       placeholder="Nomor Telepon">
                                @error('nomor_telepon_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kota_client">Kota</label>
                                <input type="text" value="{{$data->kota_client}}"
                                       class="form-control @error('kota_client') is-invalid @enderror"
                                       id="kota_client" name="kota_client" placeholder="Kota">
                                @error('kota_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_client">Alamat</label>
                                <input type="text" value="{{$data->alamat_client}}"
                                       class="form-control @error('alamat_client') is-invalid @enderror"
                                       id="alamat_client" name="alamat_client" placeholder="Alamat">
                                @error('alamat_client')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" id="btnupdateinfoclient" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
                <div class="card card-warning-dx">
                    <div class="card-header">
                        <h3 class="card-title text-white">Informasi Proyek</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus text-white"></i></button>
                        </div>
                    </div>
                    <!-- form start -->
                    <form id="formupdateinfoproyek" role="form" method="post"
                          action="{{route('data.penawaran.offline.update_proyek', $data->id)}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_proyek">Nama Proyek</label>
                                <input type="text" value="{{$data->nama_proyek}}"
                                       class="form-control @error('nama_proyek') is-invalid @enderror"
                                       id="nama_proyek" name="nama_proyek" placeholder="Nama Proyek">
                                @error('nama_proyek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_proyek">Alamat</label>
                                <input type="text" value="{{$data->alamat_proyek}}"
                                       class="form-control @error('alamat_proyek') is-invalid @enderror"
                                       id="alamat_proyek" name="alamat_proyek" placeholder="Alamat Proyek">
                                @error('alamat_proyek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="date" min="{{date("Y-m-d")}}"
                                       class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                                       name="deadline" value="{{$data->deadline}}">
                                @error('deadline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="diskripsi_proyek">Diskripsi Proyek</label>
                                <textarea rows="3" type="text"
                                          class="form-control @error('diskripsi_proyek') is-invalid @enderror"
                                          id="diskripsi_proyek"
                                          name="diskripsi_proyek"
                                          placeholder="Diskripsi">{{$data->diskripsi_proyek}}</textarea>
                                @error('diskripsi_proyek')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="button" id="btnupdateinfoproyek" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">

                <div class="card card-info-dx">
                    <div class="card-header">
                        <h3 class="card-title text-white">Komponen</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fas fa-minus text-white"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table" id="tbl_komponen">
                            <thead>
                            <tr>
                                <th>Nama Komponen</th>
                                <th>Merk/Type</th>
                                <th>Spesifikasi</th>
                                <th>Jmlh Unit</th>
                                <th>Harga (Rp.)</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="6" style="text-align: center;">
                                    <button class="btn btn-primary" id="btn-tbh-componen">
                                        <i class="fa fa-plus-square"></i> Tambah Komponen
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
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
                        <div class="form-group">
                            <label for="inputEstimatedBudget">Presentase</label>
                            <p> Berapa persen margin keuntungan yang anda kehendaki, presentase ini didasar i oleh harga
                                total komponen.</p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" id="inputPresentase" class="form-control" value="{{$data->keuntungan}}"
                                   max="100"
                                   step="1">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <label for="inputEstimatedBudget">Total Harga Komponen</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" id="inputTotalHargaKomponen" class="form-control" value="0" readonly>
                        </div>

                        <label for="inputEstimatedBudget">Keuntungan</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" id="inputKeuntungan" class="form-control" value="0" readonly>
                        </div>

                        <label for="inputEstimatedBudget">Harga Total</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" id="inputHargaTotal" class="form-control" value="0" readonly>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ url()->previous() }}" class="btn btn-danger pl-5 pr-5">Batal</a>
                                <button type="button" id="btnsubmitpenawaran" value="{{$data->id}}"
                                        class="btn btn-primary float-right">Update Data Penawaran
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
    <script type="text/javascript">

        var tmp = {!! json_encode($data->komponen->toArray()) !!};

    </script>
    <script src="{{ asset('js/edit_penawaran_offline.js') }}" defer></script>
@endpush
