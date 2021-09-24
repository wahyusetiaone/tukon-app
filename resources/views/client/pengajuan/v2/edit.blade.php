@extends('layouts.v2.app_client')

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
    <div class="col-12 p-4">
        <div class="card bg-white border-0 rounded-0 shadow-none p-3">
            <!-- title row -->
            <div class="row pl-3 pr-3">
                <div class="col-8">
                    <a style="color: black;" href="{{ route('show.pengajuan.client', $data->id) }}"><i
                            class="fas fa-chevron-left"></i> KEMBALI</a>
                </div>
                <div class="col-4">
                    <p style="color: #008CC6;" class="float-right mb-0 pb-0">PENAWARAN PROYEK</p>
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="row pl-3 pr-3">
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
                                        <input required value="{{$data->range_min}}" type="text"
                                               class="form-control rupiah @error('range_min') is-invalid @enderror"
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
                                        <input required value="{{$data->range_max}}" type="text"
                                               class="form-control rupiah @error('range_max') is-invalid @enderror"
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

                    <!-- out off form -->
                    @isset($data->berkas[0])
                        <div class="form-group">
                            <label for="diskripsi_proyek">Berkas</label>
                            <div class="berkas">
                                @foreach($data->berkas as $item)
                                    <a href="{{asset($item->path)}}" target="_blank">{{$item->original_name}}</a>&nbsp;
                                    &nbsp;
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete-berkas-form').submit();">
                                        <i class="fas fa-trash text-red" title="Hapus File"></i>
                                    </a>
                                    <form id="delete-berkas-form" action="{{ route('remove.pengajuan.client.berkas', $data->id) }}" method="POST"
                                          class="d-none">
                                        @csrf
                                        <input hidden type="number" value="{{$item->id}}" name="id">
                                        <input hidden type="text" value="{{$item->path}}" name="path">
                                    </form>
                                    <br>
                                @endforeach
                            </div>
                            <a href="#"
                               onclick="event.preventDefault(); document.getElementById('berkas').click();"
                               class="btn btn-info rounded-0 mt-3">TAMBAH FILE</a>
                            <form id="add-berkas-form" action="{{ route('add.pengajuan.client.berkas', $data->id) }}" method="POST"
                                  class="d-none" enctype="multipart/form-data">
                                @csrf
                                <input hidden type="file" name="berkas[]" id="berkas" multiple>
                            </form>
                        </div>
                    @endisset

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
                <div class="col-12">
                    <div class="float-right">
                        <button type="button" id="btn_hps_pengajuan" value="{{$data->id}}"
                                class="btn btn-danger rounded-0">Hapus
                        </button>
                        <button type="button" id="btn_submit_pengajuan" class="btn btn-info rounded-0">Perbarui
                            Pengajuan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/edit_pengajuan_client.js') }}" defer></script>
@endsection
