@extends('layouts.app_client')

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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Pengajuan Proyek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('pengajuan.client')}}">Pengajuan</a></li>
                        <li class="breadcrumb-item"><a href="{{route('show.pengajuan.client', $data->id)}}">Lihat</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Pengajuan</li>
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
            <div class="row">
                <div class="col-6">
                    <form id="form-edit-pengajuan" method="post"
                          action="{{ route('update.pengajuan.client',$data->id)}}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_produk">Nama Proyek</label>
                            <input type="text" value="{{$data->nama_proyek}}"
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
                            <input type="text" value="{{$data->alamat}}"
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
                                        <input required value="{{$data->range_min}}" type="number"
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
                                        <input required value="{{$data->range_max}}" type="number"
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
                            <label for="deadline">Deadline</label>
                            <input type="date" min="{{date("Y-m-d")}}" value="{{$data->deadline}}"
                                   class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                                   name="deadline">
                            @error('deadline')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="diskripsi_proyek">Diskripsi Proyek</label>
                            <textarea type="text" name="diskripsi_proyek" class="form-control" id="diskripsi_proyek"
                                      class="form-control @error('diskripsi_proyek') is-invalid @enderror" rows="8"
                                      placeholder="Berisi tentang rincihan proyek yang anda ajukan kepada tukang.">{{$data->diskripsi_proyek}}</textarea>
                            @error('diskripsi_proyek')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </form>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="path_show">Gambar Pengajuan</label>
                        <form id="form-rm-img" method="post"
                              action="{{ route('remove.pengajuan.client.photo', $data->id) }} "
                              enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="urlImg" hidden>
                        </form>
                        @if($data->multipath)
                            @php
                                $str_arr = explode (",", $data->path);
                            @endphp
                            <div class="col-12 img-wrap">
                                <a href="#" name="removeImg" title="Hapus Gambar"><span class="close"><i
                                            class="fas fa-trash-alt"></i></span></a>
                                <img src="{{asset($str_arr[0])}}" id="targetImg" class="product-image"
                                     alt="Product Image">
                            </div>
                            <div class="col-12 product-image-thumbs">
                                @foreach($str_arr as $item)
                                    <div class="product-image-thumb active">
                                        <img src="{{asset($item)}}" name="thumnailImg"
                                             alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @if(!empty($data->path))
                                <div class="col-12 img-wrap">
                                    <a href="#" title="Hapus Gambar"><span class="close"><i
                                                class="fas fa-trash-alt"></i></span></a>
                                    <img src="{{asset($data->path)}}"
                                         class="product-image" alt="Product Image">
                                </div>
                                <div class="col-12 product-image-thumbs">
                                    <div class="product-image-thumb active">
                                        <img
                                            src="{{asset($data->path)}}"
                                            alt="Product Image"></div>
                                </div>
                            @else
                                <div class="col-12 img-wrap">
                                    Belum Ada Gambar
                                </div>
                            @endif
                        @endif
                        <br>
                        <div class="input-group">
                            <div class="custom-file">
                                <form id="form-add-img" method="post"
                                      action="{{ route('add.pengajuan.client.photo', $data->id) }} "
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="file"
                                           class="custom-file-input @error('path_show') is-invalid @enderror"
                                           id="path_show" name="path_show[]" multiple>
                                    <label class="custom-file-label" for="path_show">Tambah Gambar Pengajuan</label>
                                </form>
                            </div>
                        </div>
                        @error('path_show')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="button" id="btn_hps_pengajuan" value="{{$data->id}}" class="btn btn-danger">Hapus</button>
            <button type="button" id="btn_submit_pengajuan" class="btn btn-primary">Perbarui Pengajuan</button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/edit_pengajuan_client.js') }}" defer></script>
@endsection
