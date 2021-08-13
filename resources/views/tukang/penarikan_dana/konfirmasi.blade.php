@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('third_party_stylesheets')
    <link href="{{ asset('css/show_proyek.css') }}" rel="stylesheet">
@endsection

@section('content')
    <br>
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Konfirmasi Penarikan
                    Dana</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        Anda akan melakukan penarikan dana sebesar {{$persen}}% dari total dana
                        sebesar {{indonesiaRupiah($data->total_dana)}}, maka rincihan sebagai berikut : <br>
                        <span class="text-muted">Penarikan</span>
                        <p>{{indonesiaRupiah($data->total_dana * ($persen/100))}}</p>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <!-- general form elements -->
                        <form id="formaddpenawaranoffline" role="form" method="post"
                              action="{{route('store.penarikan.dana',[$data->id, $persen])}}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Masukan Password Anda</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <p class="text-muted">Masukan password untuk konfirmasi bawah itu adalah anda.</p>
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" placeholder="Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Ajukan</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>

                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    {{--    <script src="{{ asset('js/show_project.js') }}" defer></script>--}}
@endpush
