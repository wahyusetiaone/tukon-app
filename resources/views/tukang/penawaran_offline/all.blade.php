@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Produk yang dimiliki.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <a href="{{route('data.penawaran.offline.create')}}"> <button type="button" id="btn-sub" class="btn btn-success">Buat Penawaran Offline</button>
            </a>
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama Projek</th>
                    <th>Diskripsi Projeck</th>
                    <th>Alamat</th>
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
    <script src="{{ asset('js/all_penawaran_offline.js') }}" defer></script>
@endpush
