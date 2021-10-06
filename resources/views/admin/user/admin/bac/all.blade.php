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
                            <label for="search">Ganti BAC</label>
                            <i class="fas fa-question-circle" data-toggle="tooltip" data-html="true"
                               data-placement="top"
                               title="<p><small>Penggantian BAC akan otomatis menonaktifkan nilai BAC yang sekarang aktif.</small></p>"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <form id="fm-ganti-bpa" action="{{route('pengaturan.bac.update.admin')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="number" max="100" min="0"
                                           class="form-control @error('bac') is-invalid @enderror"
                                           id="bac" placeholder="BAC dalam Persen"
                                           name="bac">
                                    @error('bac')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <button class="btn btn-primary" id="ganti-bac" type="button">Ganti</button>
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
            <h3 class="card-title">Biaya Bonus Admin (BAC).</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>BAC (%)</th>
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
    <script src="{{ asset('js/all_bac_admin.js') }}" defer></script>
@endpush
