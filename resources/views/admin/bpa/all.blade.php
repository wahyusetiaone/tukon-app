@extends('layouts.app')


@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-5">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="search">Ganti BPA</label>
                            <i class="fas fa-question-circle" data-toggle="tooltip" data-html="true"
                               data-placement="top"
                               title="<p><small>Penggantian BPA akan otomatis menonaktifkan nilai BPA yang sekarang aktif.</small></p>"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <form id="fm-ganti-bpa" action="{{route('pengaturan.bpa.update.admin')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="number" max="100" min="0"
                                           class="form-control @error('bpa') is-invalid @enderror"
                                           id="bpa" placeholder="BPA dalam Persen"
                                           name="bpa">
                                    @error('bpa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <button class="btn btn-primary" id="ganti-bpa" type="button">Ganti</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.card -->
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Biaya Penggunaan Aplikasi (BPA).</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>BPA (%)</th>
                    <th>Dibuat</th>
                    <th>Non aktifkan</th>
                    <th>Status</th>
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
    <script src="{{ asset('js/all_bpa_admin.js') }}" defer></script>
@endpush
