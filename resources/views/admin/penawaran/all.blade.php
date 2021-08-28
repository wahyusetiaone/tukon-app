@extends('layouts.app')


@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <form name="search-opt">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="search">Pencarian</label>
                                <i class="fas fa-question-circle" data-toggle="tooltip" data-html="true" data-placement="top"
                                   title="<p><small>Isi dengan <strong>ID Penawaran</strong> atau <strong>Nama Tukang</strong> dalam kolom pencarian</small></p>"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control @error('query') is-invalid @enderror"
                                           id="query"
                                           name="query" placeholder="ID Penawaran atau Nama Tukang">
                                    @error('query')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-3">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Cari Penawaran</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.card -->
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Penawaran.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama Projek</th>
                    <th>Nama Tukang</th>
                    <th>Nama Klien</th>
                    <th>Tindakan</th>
                </tr>
                </thead>
                <tbody>

                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/all_penawaran_admin.js') }}" defer></script>
@endpush
