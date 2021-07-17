@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit produk .</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="form-edit-produk" method="post" action="{{ route('update.produk', $data->id) }} " enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
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
                            <label for="range">Jangkauan Harga</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Minimum</label>
                                        <input required value="{{$data->range_min}}" type="number" class="form-control @error('range_min') is-invalid @enderror"
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
                                        <input required value="{{$data->range_max}}" type="number" class="form-control @error('range_max') is-invalid @enderror"
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
                            <label for="diskripsi">Diskripsi Produk</label>
                            <textarea type="text" name="diskripsi" class="form-control" id="diskripsi" class="form-control @error('diskripsi') is-invalid @enderror" rows="3"
                                      placeholder="Berisi tentang produk jasa yang anda tawarkan kepada pelanggan.">{{$data->diskripsi}}</textarea>
                            @error('diskripsi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="path_show">Gambar produk</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"  class="custom-file-input @error('path_show') is-invalid @enderror" id="path_show" name="path_show[]" multiple>
                                    <label class="custom-file-label" for="path_show">Choose file</label>
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
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
        <script src="{{ mix('js/show_produk.js') }}" defer></script>
@endpush
