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
                    <h1>Pengalihan Proyek</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                        <li class="breadcrumb-item active">Pengalihan Proyek</li>
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

                            <h3 class="profile-username text-center">{{$data->user->name}}</h3>

                            <p class="text-muted text-center">{{$data->kota}}</p>

                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Proyek</h3>
                        </div>
                        <div class="card-body">
                            <!-- /.card-header -->
                            <form id="form-pengalihan-proyek" method="post"
                                  action="{{route('pengguna.tukang.store.pengalihan.proyek.admin', $data->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @foreach($proyek as $item)
                                    <div class="form-group">
                                        <label for="proyek">{{$item->pembayaran->pin->pengajuan->nama_proyek}}</label>
                                        <p class="text-sm text-info">Akan dialihkan kepada</p>
                                        <div class="row">
                                            <div class="col-1">
                                                <span data-toggle="modal" data-target="#modalCariTukang"
                                                      data-id="{{$item->pembayaran->pin->id}}">
                                                <button type="button" class="btn btn-primary-cs" data-toggle="tooltip"
                                                        data-html="true"
                                                        data-placement="bottom"
                                                        title="<p><small>Cari Penyedia Jasa</small></p>">
                                                    <i class="fas fa-search"></i></button>
                                                </span>
                                            </div>
                                            <div class="col-11">
                                                <input type="number" name="id_pin[]" value="{{$item->pembayaran->pin->id}}" hidden/>
                                                <input type="number" id="id_penyedia_jasa_{{$item->pembayaran->pin->id}}"
                                                       name="id_penyedia_jasa[]" hidden/>
                                                <input type="text" readonly
                                                       class="form-control  rounded-0 @error('nama_penyedia_jasa') is-invalid @enderror"
                                                       id="nama_penyedia_jasa_{{$item->pembayaran->pin->id}}"
                                                       name="nama_penyedia_jasa[]" placeholder="Nama Penyedia Jasa">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                                <div class="form-group">
                                    <label for="proyek">Alasan</label>
                                    <p class="text-sm text-info">Alasan melakukan pemblokiran Akun</p>
                                    <textarea
                                           class="form-control  rounded-0 @error('reason') is-invalid @enderror"
                                              name="reason" placeholder="Alasan"></textarea>
                                    @error('kota')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                        </div>
                        <!-- /.card-body -->
                        </form>
                        <div class="card-footer">
                            <button class="btn btn-info float-right" id="kirim_pengalihan_proyek">Alihkan & Ban Akun
                            </button>
                            <a href="{{url()->previous()}}">
                                <button class="btn btn-danger float-right mr-4" id="kirim_pengalihan_proyek">Batal
                                </button>
                            </a>
                        </div>
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

    <!--Modal-->
    <div id="modalCariTukang" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Pencarian Pengalihan Penyedia Jasa
                        <p class="text-sm text-info">Masukan nama penyedia jasa pada kolom di bawah
                            <ini class=""></ini>
                        </p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cari Penyedia Jasa</label>
                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="search_penyedia_jasa" class="form-control"
                                       id="search_penyedia_jasa">
                                @error('search_penyedia_jasa')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-1 ml-3">
                                <button type="button" class="btn btn-primary-cs" data-toggle="tooltip" data-html="true"
                                        data-placement="bottom" id="btn_cari_jasa"
                                        title="<p><small>Cari Penyedia Jasa</small></p>">
                                    <i class="fas fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Hasil :</label>
                        <div class="list-group" id="results">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--/End Modal-->
@endsection
@push('page_scripts')
    <script src="{{ asset('js/show_pengalihan_proyek_admin.js') }}" defer></script>
@endpush
