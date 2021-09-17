@extends('layouts.app')


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Produk yang dimiliki.</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <a href="{{route('add.produk')}}"> <button type="button" id="btn-sub" class="btn btn-primary-cs">Tambah Produk</button>
            </a>
            <table id="produk-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nama Produk</th>
                    <th>Harga Min</th>
                    <th>Harga Maks</th>
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
    <script src="{{ asset('js/all_produk.js') }}" defer></script>
@endpush
