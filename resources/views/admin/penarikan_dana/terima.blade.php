@extends('layouts.app')

@push('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@endpush

@section('third_party_stylesheets')
    <style>
        .img-wrap {
            position: relative;
        }

        .img-wrap .close {
            color: red;
            position: absolute;
            top: 12px;
            right: 20px;
            z-index: 100;
        }
    </style>
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Konfirmasi Persetujuan.</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="form-confirm-terima" method="post" action="{{route('accept.penarikan.admin')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" value="{{$id}}" name="id_transaksi" hidden>
                            <label for="catatan_penolakan">Mohon untuk upload bukti pembayaran.</label>
                            <input type="file"
                                   class="form-control-file @error('bukti_tf_admin') is-invalid @enderror"
                                   id="bukti_tf_admin"
                                   name="bukti_tf_admin">
                            @error('bukti_tf_admin')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" id="btn-terima-send" value="{{$id}}" class="btn btn-info">
                        Terima
                    </button>
                    <a href="{{ URL::previous() }}"> <button type="button" class="btn btn-danger">
                            Batal
                        </button>
                    </a>
                </div>
            </div>
        </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/konfirmasi_penarikan_admin.js') }}" defer></script>
@endpush
