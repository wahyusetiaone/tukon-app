@extends('layouts.app')

@push('head_meta')
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
@endpush

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
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
                            <h3 class="card-title">Upload Progress</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="form_upload_progress" role="form" method="post" enctype="multipart/form-data" action="{{route('upload.progress', $id)}}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="path_progress">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" required name="path_progress" class="custom-file-input" id="path_progress">
                                            <label class="custom-file-label" for="path_progress">Choose file</label>
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
@endsection

@section('third_party_scripts')
{{--        <script src="{{ asset('js/payoffline_pembayaran_client.js') }}" defer></script>--}}
@endsection
