@extends('layouts.app_client')

@section('third_party_stylesheets')
    {{--    <link href="{{ mix('css/home_client.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Form Pengajuan Proyek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('pengajuan.client')}}">Pengajuan</a></li>
                        <li class="breadcrumb-item active">Form Pengajuan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengajuan proyek .</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="form-pengajuan" method="post"
                  action="{{ route('store.pengajuan.client',['id' => $id, 'multi' => $multi, 'kode_tukang'=>$data]) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama_produk">Nama Proyek</label>
                            <input type="text"
                                   class="form-control @error('nama_proyek') is-invalid @enderror" id="nama_proyek"
                                   name="nama_proyek" placeholder="Masukan Nama Proyek">
                            @error('nama_proyek')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text"
                                   class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                   name="alamat" placeholder="Masukan Alamat Proyek">
                            @error('alamat')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="range">Jangkauan Harga</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Minimum</label>
                                        <input required value="10000" type="number"
                                               class="form-control @error('range_min') is-invalid @enderror"
                                               id="range_min" name="range_min" placeholder="10000">
                                        @error('range_min')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Maximum</label>
                                        <input required value="10000" type="number"
                                               class="form-control @error('range_max') is-invalid @enderror"
                                               id="range_max" name="range_max" placeholder="100000">
                                        @error('range_max')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="diskripsi_proyek">Diskripsi Produk</label>
                            <textarea type="text" name="diskripsi_proyek" class="form-control" id="diskripsi_proyek"
                                      class="form-control @error('diskripsi_proyek') is-invalid @enderror" rows="3"
                                      placeholder="Berisi tentang rincihan proyek yang anda ajukan kepada tukang."></textarea>
                            @error('diskripsi_proyek')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="date" min="{{date("Y-m-d")}}"
                                   class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                                   name="deadline" placeholder="Masukan Alamat Proyek">
                            @error('deadline')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="path_add">Gambar Blueprint Proyek</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('path_add') is-invalid @enderror"
                                           id="path_add" name="path_add[]" multiple>
                                    <label class="custom-file-label" for="path_add">Choose file</label>
                                </div>
                            </div>
                            @error('path_add')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Ajukan Proyek</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@section('third_party_scripts')
{{--    <script src="{{ mix('js/form_pengajuan.js') }}" defer></script>--}}
@endsection
