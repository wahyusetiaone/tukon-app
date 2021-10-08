@extends('layouts.v2.app_client_no_header')

@section('third_party_stylesheets')
    <style type="text/css">
        label {
            color: #756F86 !important;
        }
    </style>
@endsection

@section('content')
    <div class="col-12 p-5">
        <div class="row d-flex pl-5 pr-5">
            <div
                style="background-color: rgba(221, 240, 255, 0.85); padding-left: 23px; margin-left: auto; margin-right: auto; padding-bottom: 177px;"
                class="col-4 rounded-left pt-3">
                <a style="color: black;" href="{{ url()->previous() }}">
                    <i class="fa fa-chevron-left"></i> <span>Batal</span>
                </a>

                <div style="padding-top: 147px; padding-left: 18px;">
                    <img alt="" width="305px" height="136px" src="{{asset('images/tukon_icon.png')}}">
                </div>
            </div>
            <div class="col-8 bg-white rounded-right pt-4 pl-5 pr-5 pb-3">
                <form id="form-pengajuan" method="post"
                      action="{{ route('store.pengajuan.client',['id' => $id, 'multi' => $multi, 'kode_tukang'=>$data]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <div class="row pr-3">
                                <div class="col-3">
                                    <button type="button" id="btn_as_icon_one"
                                            class="btn border-0 rounded-0 shadow-none text-bold m-0"
                                            style="background-color: #CCE8F4">1
                                    </button>
                                </div>
                                <div class="col-9 my-auto text-bold">
                                    Buat Pengajuan
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" role="presentation" hidden>
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#home" role="tab"
                               aria-controls="pills-home" aria-selected="true">Buat Pengajuan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <div class="row  pr-3">
                                <div class="col-3">
                                    <button type="button" id="btn_as_icon_two"
                                            class="btn border-0 rounded-0 shadow-none text-bold m-0"
                                            style="background-color: #F0F0F0">2
                                    </button>
                                </div>
                                <div class="col-9 my-auto text-bold">
                                    Alamat Proyek
                                </div>
                            </div>
                        </li>
                        <li class="nav-item" role="presentation" hidden>
                            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#profile" role="tab"
                               aria-controls="pills-profile" aria-selected="false">Proyek</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <hr>
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-6 pr-4">
                                    <div class="form-group">
                                        <label for="nama_produk">Nama Proyek *</label>
                                        <input type="text"
                                               class="form-control @error('nama_proyek') is-invalid @enderror"
                                               id="nama_proyek"
                                               name="nama_proyek" placeholder="Masukan Nama Proyek">
                                        @error('nama_proyek')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="range">Jangkauan Harga *</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Minimum</label>
                                                    <input required value="10000" type="text"
                                                           class="form-control rupiah @error('range_min') is-invalid @enderror"
                                                           id="range_min" name="range_min" placeholder="10000">
                                                    @error('range_min')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Maximum</label>
                                                    <input required value="10000" type="text"
                                                           class="form-control rupiah @error('range_max') is-invalid @enderror"
                                                           id="range_max" name="range_max" placeholder="100000">
                                                    @error('range_max')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="diskripsi_proyek">Diskripsi Proyek *</label>
                                        <textarea type="text" name="diskripsi_proyek" class="form-control"
                                                  id="diskripsi_proyek"
                                                  class="form-control @error('diskripsi_proyek') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="Berisi tentang rincihan proyek yang anda ajukan kepada tukang."></textarea>
                                        @error('diskripsi_proyek')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="deadline">Deadline *</label>
                                        <input type="date" min="{{date("Y-m-d")}}"
                                               class="form-control @error('deadline') is-invalid @enderror"
                                               id="deadline"
                                               name="deadline" placeholder="Masukan Alamat Proyek">
                                        @error('deadline')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 border-left pl-4">
                                    <div class="form-group">
                                        <p>Blueprint / Sketsa Proyek *</p>
                                        <p style="font-size: 11pt">Ketentuan :
                                            <br>
                                            1.Upload file yang memiliki format Jpg dan Png<br>
                                            2.Maksimal Ukuran file adalah 1Mb</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="path_add">Gambar Blueprint Proyek</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input @error('path_add') is-invalid @enderror"
                                                       id="path_add" name="path_add[]" multiple>
                                                <label class="custom-file-label" for="path_add">Choose file</label>
                                            </div>
                                        </div>
                                        @error('path_add')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="count_file" class="float-right"></label>
                                    </div>
                                    <button id="next" type="button" class="btn pl-5 pr-5 float-right rounded-0"
                                            style="margin-top: 180px; background-color: #008CC6; color: white;">
                                        Selanjutnya
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat *</label>
                                        <input type="text"
                                               class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                               name="alamat" placeholder="Masukan Alamat Proyek">
                                        @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="expired">Kadaluwarsa Pengajuan *</label>
                                        <input type="datetime-local" min="{{date("Y-m-d")}}"
                                               class="form-control @error('expired') is-invalid @enderror"
                                               id="expired"
                                               name="expired">
                                        @error('expired')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <p>File Proyek</p>
                                        <p style="font-size: 11pt">Ketentuan :
                                            <br>
                                            1.Upload file yang memiliki format pdf atau docx<br>
                                            2.Maksimal Ukuran file adalah 1Mb</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="path_berkas">File Proyek</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                       class="custom-file-input @error('path_berkas') is-invalid @enderror"
                                                       id="path_berkas" name="path_berkas[]" multiple>
                                                <label class="custom-file-label" for="path_berkas">Choose file</label>
                                            </div>
                                        </div>
                                        @error('path_berkas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label id="count_berkas" class="float-right"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 100px;">
                                <div class="col-6">
                                    <button id="before" type="button" class="btn pl-5 pr-5 float-left rounded-0"
                                            style="background-color: #008CC6; color: white;">
                                        Sebelumnya
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn pl-5 pr-5 float-right rounded-0"
                                            style="background-color: #008CC6; color: white;">Kirim
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#next').click(function (event) {
                $('#pills-profile-tab').click(); // Select tab by name
                $('#btn_as_icon_two').css({"backgroundColor": "#CCE8F4"});
            });
            $('#before').click(function (event) {
                $('#pills-home-tab').click(); // Select tab by name
                $('#btn_as_icon_two').css({"backgroundColor": "#F0F0F0"});
            });
        });
    </script>
    <script src="{{ asset('js/form_pengajuan.js') }}" defer></script>
@endsection
