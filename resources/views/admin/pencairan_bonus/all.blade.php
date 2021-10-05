@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menunggu Konfirmasi Pencairan.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama Proyek</th>
                    <th>Nama Admin</th>
                    <th>Total Pencairan</th>
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
    <script src="{{ asset('js/all_pencairan_admin.js') }}" defer></script>
@endpush
