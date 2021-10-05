@extends('layouts.app')

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
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit produk .</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">

                <div class="col-6">
                    <form id="form-edit-produk" method="post" action="{{ route('update.produk', $data->id) }} "
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input value="{{$data->nama_produk}}" type="text"
                                   class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk"
                                   name="nama_produk" placeholder="Masukan Nama Produk">
                            @error('nama_produk')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <!-- text input -->
                            <label>Harga</label>
                            <input required value="{{$data->harga}}" type="text"
                                   class="form-control rupiah @error('harga') is-invalid @enderror"
                                   id="harga" name="harga" placeholder="10000">
                            @error('harga')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="diskripsi">Diskripsi Produk</label>
                            <textarea type="text" name="diskripsi" class="form-control" id="diskripsi"
                                      class="form-control @error('diskripsi') is-invalid @enderror" rows="13"
                                      placeholder="Berisi tentang produk jasa yang anda tawarkan kepada pelanggan.">{{$data->diskripsi}}</textarea>
                            @error('diskripsi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </form>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="path_show">Gambar produk</label>
                        <form id="form-rm-img" method="post" action="{{ route('remove.produk.photo', $data->id) }} "
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
                                      action="{{ route('add.produk.photo', $data->id) }} "
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="file"
                                           class="custom-file-input @error('path_show') is-invalid @enderror"
                                           id="path_show" name="path_show[]" multiple>
                                    <label class="custom-file-label" for="path_show">Tambah Gambar Produk</label>
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

            <button type="button" id="btn-sub" class="btn btn-primary">Update Data</button>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_produk.js') }}" defer></script>
@endpush
