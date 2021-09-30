@extends('layouts.app')

@push('page_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-duallistbox.css') }}">
@endpush

@section('content')
    <br>
    <div class="row ">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title"> Tambah Admin Cabang </h3>
                </div>
                <div class="card-body">
                    <form action="{{route('store.pengguna.admincabang.admin')}}" id="fm-add-admincabang" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <select id="provinsi_t" class="form-control">
                                        <option value="all">Pilih Provinsi</option>
                                        @foreach($prov->provinsi as $item)
                                            <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Email Admin</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                           placeholder="Masukan email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Pilih Cabang</label>
                                    <select class="duallistbox" id="duallistbox" name="duallistbox[]" multiple="multiple">
                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="button" id="btn-save" class="btn btn-primary float-right">Tambah</button>
                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    </div>
    <!-- /.card -->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <script src="{{ asset('js/add_admin_user_admin.js') }}" defer></script>
@endpush
