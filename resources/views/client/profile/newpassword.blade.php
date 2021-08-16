@extends('layouts.app_client')

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/show_proyek.css') }}" rel="stylesheet">--}}
    <style type="text/css">
        .ratings {
            background-color: #fff;
        }

        .product-rating {
            font-size: 50px
        }

        .stars i {
            font-size: 18px;
            color: #FFC400
        }
    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Kata Sandi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('show.user.ptofile.client', $client->id)}}">Profile</a></li>
                        <li class="breadcrumb-item active">Ubah Kata Sandi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="container-sm">
                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Reset Kata Sandi</h3>
                            </div>
                            <!-- /.card-header -->
                            <form method="post"
                                  action="{{ route('update.user.newpassword.client',['id' => $client->id]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="old_password">Kata Sandi Lama</label>
                                        <input type="password"
                                               class="form-control @error('old_password') is-invalid @enderror" id="old_password"
                                               name="old_password" placeholder="Masukan Kata Sandi Lama Anda">
                                        @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Kata Sandi Baru</label>
                                        <input type="password"
                                               class="form-control @error('new_password') is-invalid @enderror" id="new_password"
                                               name="new_password" placeholder="Masukan Kata Sandi Baru Anda">
                                        @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="c_new_password">Ulangi Kata Sandi Baru</label>
                                        <input type="password"
                                               class="form-control @error('c_new_password') is-invalid @enderror" id="c_new_password"
                                               name="c_new_password" placeholder="Masukan Ulang Kata Sandi Baru Anda">
                                        @error('c_new_password')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success float-right">Ubah Kata Sandi</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('page_scripts')
    {{--    <script src="{{ asset('js/show_project_client.js') }}" defer></script>--}}
@endpush
