@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit produk .</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="form-edit-produk" method="post" action="{{ route('update.produk', $data->id) }} ">
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
                    <label for="range">Jangkauan Harga</label>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Minimum</label>
                                <input value="{{$data->range_min}}" type="number" class="form-control @error('range_min') is-invalid @enderror"
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
                                <input value="{{$data->range_max}}" type="number" class="form-control @error('range_max') is-invalid @enderror"
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
                    <textarea type="text" class="form-control" id="diskripsi" class="form-control @error('diskripsi') is-invalid @enderror" rows="3"
                              placeholder="Berisi tentang produk jasa yang anda tawarkan kepada pelanggan.">{{$data->diskripsi}}</textarea>
                    @error('diskripsi')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Gambar produk</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
{{--                        <div class="input-group-append">--}}
{{--                            <span class="input-group-text">Upload</span>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
    {{--    <script src="{{ mix('js/all_produk.js') }}" defer></script>--}}
@endpush
