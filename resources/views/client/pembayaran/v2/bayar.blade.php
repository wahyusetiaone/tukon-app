@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
@endsection

@section('content')
    <div class="col-12 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="card bg-white border-0 rounded-0 shadow-none p-3 pl-5 pr-5">
                    <div class="row pb-3">
                        <div class="col-12">
                            <a style="color: black;" href="{{ url()->previous() }}">
                                <span class="float-right text-muted">KEMBALI</span>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-white p-3 rounded-0">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-bold pb-0 mb-0">Nama Proyek</p>
                                        <p class="text-muted">{{$data->pin->pengajuan->nama_proyek}}</p>
                                    </div>
                                    <div class="col-6">
                                        <div class="float-right text-right">
                                            <p class="text-bold pb-0 mb-0">Penyedia Jasa</p>
                                            <p class="text-muted">{{$data->pin->tukang->user->name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-bold pb-0 mb-0">Alamat Proyek</p>
                                        <p class="text-muted">{{$data->pin->pengajuan->alamat}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-gray-light border-0 shadow-none rounded-0 p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-bold pb-0 mb-0">Total Pembayaran</p>
                                    </div>
                                    <div class="col-6">
                                        <div class="float-right text-right">
                                            <p class="text-bold pb-0 mb-0">{{indonesiaRupiah($data->total_tagihan, false)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-5">
                        <div class="col-6 pt-3">
                            <form action="{{route('checkout.pembayaran.client', $data->id)}}" method="post"
                                  name="fcm-up">
                                @csrf
                                <input type="text" id="online" name="mode" value="online" hidden>
                                <div class="form-group">
                                    <label class="text-muted" for="channel">Metode Pembayaran</label>
                                    <select class="form-control text-muted shadow-sm" name="channel"
                                            id="channel">
                                        @foreach($channel as $item)
                                            <option
                                                value="{{$item['channel_code']}}">{{$item['channel_code']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-6 pt-4">
                            <div class="row pb-3">
                                <div class="col-12">
                                    <button type="button" id="btn_checkout" value="{{$data->pin->pembayaran->id}}"
                                            class="btn btn-info float-right rounded-0 w-50">Checkout
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" id="btn_btll" value="{{$data->pin->pembayaran->id}}"
                                            class="btn btn-danger float-right rounded-0 w-50"> Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/show_pembayaran_client.js') }}" defer></script>
@endsection
