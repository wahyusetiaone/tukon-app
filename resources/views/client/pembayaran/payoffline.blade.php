@extends('layouts.app_client')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Offline Payment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{'pembayaran.client'}}">Pembayaran</a></li>
                            <li class="breadcrumb-item active">Pembayaran Offline</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Upload Bukti Pembayaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="form_pay_offline" role="form" method="post" enctype="multipart/form-data" action="{{route('store.payoffline.pembayaran.client', $id)}}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="note_transaksi">Catatan kepada admin</label>
                                    <textarea type="text" required name="note_transaksi" class="form-control" id="note_transaksi"
                                              placeholder="Catatan kepada admin ..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="path_transaksi">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" required name="path_transaksi" class="custom-file-input" id="path_transaksi">
                                            <label class="custom-file-label" for="path_transaksi">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="btn_kirim" class="btn btn-primary">Kirim</button>
                                <button type="button" id="btn_btl" class="btn btn-danger">Batal</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('third_party_scripts')
        <script src="{{ asset('js/payoffline_pembayaran_client.js') }}" defer></script>
@endsection
