@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah produk .</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form id="form-edit-produk" method="post" action="{{ route('store.produk') }} " enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk *</label>
                            <input type="text"
                                   class="form-control @error('nama_produk') is-invalid @enderror" id="nama_produk"
                                   name="nama_produk" placeholder="Masukan Nama Produk">
                            @error('nama_produk')
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="range">Jangkauan Harga *</label>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Minimum</label>
                                        <input required value="10000" type="text" class="form-control rupiah @error('range_min') is-invalid @enderror"
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
                                        <input required value="10000" type="text" class="form-control rupiah @error('range_max') is-invalid @enderror"
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
                            <label for="diskripsi">Diskripsi Produk *</label>
                            <textarea type="text" name="diskripsi" class="form-control" id="diskripsi" class="form-control @error('diskripsi') is-invalid @enderror" rows="3"
                                      placeholder="Berisi tentang produk jasa yang anda tawarkan kepada pelanggan."></textarea>
                            @error('diskripsi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="path_add">Gambar produk *</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('path_add') is-invalid @enderror" id="path_add" name="path_add[]" multiple>
                                    <label class="custom-file-label" for="path_add">Choose file</label>
                                </div>
                            </div>
                            @error('path_add')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label id="count_file" class="float-right"></label>
                        </div>
                    </div>
                </div>

                <button type="button" id="btn-sub" class="btn btn-primary">Simpan Data</button>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
        <script src="{{ asset('js/add_produk.js') }}" defer></script>
@endpush
