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
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
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
                    <div class="card card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <a href="#" title="{{$client->id}}" id="changephoto">
                                    @if(isset($client->path_icon))
                                        <img class="profile-user-img img-fluid img-circle image"
                                             src="{{asset($client->path_icon)}}"
                                             alt="User profile picture">
                                    @else
                                        <img class="profile-user-img img-fluid img-circle image"
                                             src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                                             alt="User profile picture">
                                    @endif
                                </a>
                            </div>

                            <h3 class="profile-username text-center">{{$client->user->name}}</h3>

                            <p class="text-muted text-center">{{$client->kota}}</p>

                            <div class="form-group">
                                <a href="{{route('show.user.newpassword')}}">
                                    <button class="btn btn-primary-cs form-control">Ubah Sandi</button>
                                </a>
                            </div>
                            <div class="form-group">
                                <a href="#" class="btn btn-danger form-control"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <!-- About Me Box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Profil</h3><br>
                            <small class="text-info">Memuat informasi pribadi anda berupa nama, password email, nomor telepon, dsb.</small>
                        </div>
                        <!-- /.card-header -->
                        <form id="form-pengajuan" method="post"
                              action="{{ route('update.user.profile',$client->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" value="{{$client->user->name}}"
                                           class="form-control @error('kota') is-invalid @enderror" id="name"
                                           name="name" placeholder="Masukan Nama Anda">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kota">Kota</label>
                                    <input type="text" value="{{$client->kota}}"
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
                                    <input type="text" value="{{$client->alamat}}"
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
                                    <input type="number" value="{{$client->nomor_telepon}}"
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
                                    <label for="no_rekening">Nomor Rekening</label>
                                    <input type="number" value="{{$client->no_rekening}}"
                                           class="form-control @error('no_rekening') is-invalid @enderror"
                                           id="no_rekening"
                                           name="no_rekening" placeholder="Masukan Nomor Rekening Anda">
                                    @error('no_rekening')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="atas_nama_rekening">Atas Nama Rekening</label>
                                    <input type="text" value="{{$client->atas_nama_rekening}}"
                                           class="form-control @error('atas_nama_rekening') is-invalid @enderror"
                                           id="atas_nama_rekening" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                           name="atas_nama_rekening" placeholder="Atas Nama Rekening Anda">
                                    @error('atas_nama_rekening')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bank">BANK</label>
                                    <input type="text" value="{{$client->bank}}"
                                           class="form-control @error('bank') is-invalid @enderror"
                                           id="bank" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);"
                                           name="bank" placeholder="Bank Anda">
                                    @error('bank')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" value="{{$client->user->email}}"
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary-cs float-right">Simpan Perubahan</button>
                            </div>
                        </form>
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
        var url = '{{$client->path_icon}}'
    </script>
    <script src="{{ asset('js/show_profile_tukang.js') }}" defer></script>
@endpush
