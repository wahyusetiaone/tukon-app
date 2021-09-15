@extends('layouts.v2.app_client_child')

@section('third_party_stylesheets')
    <style type="text/css">
        .img-cropped {
            object-fit: cover;
            object-position: center center;
            width: 268px;
            height: 288px;
        }

        .active {
            background-color: transparent !important;
            color: #008CC6 !important;
        }

        label {
            color: #8D8D8D !important;
            font-weight: normal !important;
        }

    </style>
    <style>
        #changephoto {
            display: none;
        }

        .profile-img-container {
            position: absolute;
            width: 10px;
        }

        .profile-img-container img:hover {
            opacity: 0.5;
            z-index: 501;
        }

        .profile-img-container img:hover + i {
            display: block;
            z-index: 500;
        }

        .profile-img-container i {
            display: none;
            position: absolute;
            margin-left: 40%;
            margin-top: 40%;
        }

        .profile-img-container img {
            position: absolute;
        }
    </style>
@endsection

@section('sub_contains')
    <h3>Detail Profil</h3>
    <p class="text-muted">memuat informasi pribadi anda berupa nama, password, email, nomor telepon, dsb.</p>
    <hr>
    <div class="row">
        <div class="col-8">
            <form id="form-pengajuan" method="post"
                  action="{{ route('update.user.profile.client',$client->id) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-3 my-auto">Nama</label>
                        <input type="text" value="{{$client->user->name}}"
                               class="form-control rounded-0 col-9 @error('kota') is-invalid @enderror" id="name"
                               name="name" placeholder="Masukan Nama Anda">
                        @error('kota')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="kota" class="col-3 my-auto">Kota</label>
                        <input type="text" value="{{$client->kota}}"
                               class="form-control rounded-0 col-9 @error('kota') is-invalid @enderror" id="kota"
                               name="kota" placeholder="Masukan Kota Anda">
                        @error('kota')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-3 my-auto">Alamat</label>
                        <textarea type="text" rows="3"
                                  class="form-control rounded-0 col-9 @error('alamat') is-invalid @enderror" id="alamat"
                                  name="alamat" placeholder="Masukan Alamat Anda">{{$client->alamat}}</textarea>
                        @error('alamat')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="nomor_telepon" class="col-3 my-auto">Nomor Tlp</label>
                        <input type="number" value="{{$client->nomor_telepon}}"
                               class="form-control rounded-0 col-9 @error('nomor_telepon') is-invalid @enderror"
                               id="nomor_telepon"
                               name="nomor_telepon" placeholder="Masukan Nomor Telepon Anda">
                        @error('nomor_telepon')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-3 my-auto">Email</label>
                        <input type="text" value="{{$client->user->email}}"
                               class="form-control rounded-0 col-9 @error('email') is-invalid @enderror" id="email"
                               name="email" placeholder="Masukan Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <button type="submit" style="background-color: #008CC6; color: white"
                        class="btn mr-4 float-right rounded-0">Simpan Perubahan
                </button>
            </form>

            <form method="post"
                  action="{{ route('update.user.newpassword.client',['id' => $client->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body pt-5">
                    <div class="form-group">
                        <label for="old_password">Ubah Sandi</label>
                        <input type="password"
                               class="form-control rounded-0 @error('old_password') is-invalid @enderror"
                               id="old_password"
                               name="old_password" placeholder="Masukan Kata Sandi Lama Anda">
                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password"
                               class="form-control rounded-0 @error('new_password') is-invalid @enderror"
                               id="new_password"
                               name="new_password" placeholder="Masukan Kata Sandi Baru Anda">
                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password"
                               class="form-control rounded-0 @error('c_new_password') is-invalid @enderror"
                               id="c_new_password"
                               name="c_new_password" placeholder="Masukan Ulang Kata Sandi Baru Anda">
                        @error('c_new_password')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <button type="submit" style="background-color: #008CC6; color: white"
                        class="btn mr-4 float-right rounded-0">Ubah Sandi
                </button>
            </form>
        </div>
        <div class="col-4 border-left d-flex justify-content-center">

            <form method="post" id="myphoto"
                  action="{{ route('upload.user.photo.client',['id' => $client->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                <div style="display: inline-block">
                    <div class="profile-img-container pl-4">
                        <img height="100px;" class="profile-user-img img-circle"
                             src="{{asset($client->path_foto)}}"
                             alt="User profile picture">
                        <i class="fa fa-upload fa-5x"></i>
                    </div>
                    <input id='changephoto' type='file' name="path_foto"
                           onchange="event.preventDefault(); document.getElementById('myphoto').submit();">
                </div>
                <div style="padding-top: 110px;">
                    <p class="text-muted text-center p-0 m-0">File upload maks 1 Mb</p>
                    <p class="text-muted text-center">Format Jpeg, PNG</p>
                </div>
            </form>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script type="text/javascript">
        // $('.profile-img-container img').click(function(){
        //     $('#changephoto').click();
        // });
        var url = '{{$client->path_foto}}'
    </script>
    <script src="{{ asset('js/show_profile_client.js') }}" defer></script>
@endsection
