@extends('layouts.app')

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/show_proyek.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <a href="#" title="{{$data->id}}" id="changephoto">
                                    @if(isset($data->path_foto))
                                        <img class="profile-user-img img-fluid img-circle image"
                                             src="{{asset($data->path_foto)}}"
                                             alt="User profile picture">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle image"
                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                             alt="User profile picture">
                                    @endif
                                </a>
                            </div>

                            <h3 class="profile-username text-center">{{$data->user->name ?? 'Admin Cabang'}}</h3>

                            <p class="text-muted text-center">{{$data->user->admin->kota ?? 'Kota Admin'}}</p>

                            @isset($data->user)
                                <div class="form-group">
                                    <form id="frm-banned" action="{{route('pengguna.banned.admin', $data->user->id)}}"
                                          method="POST">
                                        @csrf
                                        <input type="text" name="reason" hidden>
                                    </form>
                                    @if(isset($data->user->ban))
                                        <a href="#">
                                            <button class="btn btn-warning form-control" value="{{$data->user->id}}"
                                                    id="btn_unbanned">Unbanned Account
                                            </button>
                                        </a>
                                        <br>
                                        <br>
                                        <div class="form-group">
                                            <label for="banned">Alasan :</label>
                                            <textarea type="text" disabled
                                                      class="form-control @error('banned') is-invalid @enderror"
                                                      id="banned"
                                                      name="banned"> {{$data->user->ban->reason}}</textarea>
                                        </div>
                                    @else
                                        <a href="#">
                                            <button class="btn btn-danger form-control" id="btn_banned">Banned Account
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            @endisset

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Data Diri</h3>
                        </div>
                    @if(isset($data->user))
                        <!-- /.card-header -->
                            <form id="form-pengajuan" method="post"
                                  action="#"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" disabled value="{{$data->user->name}}"
                                               class="form-control @error('kota') is-invalid @enderror" id="name"
                                               name="name" placeholder="Masukan Nama Anda">
                                        @error('kota')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" disabled value="{{$data->user->admin->kota}}"
                                               class="form-control @error('kota') is-invalid @enderror" id="kota"
                                               name="kota" placeholder="Masukan Kota Anda">
                                        @error('kota')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" disabled value="{{$data->user->admin->alamat}}"
                                               class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                               name="alamat" placeholder="Masukan Alamat Anda">
                                        @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_telepon">Nomor Telepon</label>
                                        <input type="number" disabled value="{{$data->user->admin->nomor_telepon}}"
                                               class="form-control @error('nomor_telepon') is-invalid @enderror"
                                               id="nomor_telepon"
                                               name="nomor_telepon" placeholder="Masukan Nomor Telepon Anda">
                                        @error('nomor_telepon')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" disabled value="{{$data->user->admin->user->email}}"
                                               class="form-control @error('email') is-invalid @enderror" id="email"
                                               name="email" placeholder="Masukan Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        @else
                            <div class="card-body">
                                <h3>Mohon maaf, detail belum tersedia karena admin cabang belum melakukan pendaftaran
                                    ulang.</h3>
                            </div>
                        @endif
                    </div>
                    <!-- /.card -->
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
    <script type="text/javascript">
        var url = '{{$data->path_foto}}'
    </script>
    <script src="{{ asset('js/show_profile_user_admin.js') }}" defer></script>
@endpush
