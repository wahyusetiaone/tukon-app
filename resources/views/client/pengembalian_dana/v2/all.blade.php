@extends('layouts.v2.app_client_child')

@section('third_party_stylesheets')
    <style type="text/css">
        .active {
            background-color: transparent !important;
            color: #008CC6 !important;
        }
    </style>
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@push('nav_menu')
    @include('layouts.v2.components.nav_menu_child')
@endpush

@section('sub_contains')
    <div class="row">
        @foreach($data['data'] as $dat)
            <div class="col-12 pb-2">
                <div class="card shadow-none bg-gradient-light pl-3 pr-3 pt-1 pb-2 d-flex mb-0 rounded-0">
                    <div class="row p-2">
                        <div class="col-6">
                            @if($dat['kode_status'] == 'ON01')
                                <span class="text-muted">Proses Pembanggunan</span>
                            @elseif($dat['kode_status'] == 'ON03')
                                <span class="text-red">Dibatalkan</span>
                            @elseif($dat['kode_status'] == 'ON05')
                                <span class="text-info">Selesai</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <span class=" float-right"><span class="text-info">Tanggal Pemesanan :</span> {{indonesiaDate($dat['pembayaran']['pin']['pengajuan']['created_at'])}}</span>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-4">
                            <p class="text-muted mb-0 pb-0">Nama Proyek</p>
                            <h6 class="mt-0 pt0">{{$dat['pembayaran']['pin']['pengajuan']['nama_proyek']}}</h6>
                        </div>
                        <div class="col-3 border-left">
                            <p class="text-muted mb-0 pb-0">Tukang</p>
                            <h6 class="mt-0 pt0">{{$dat['pembayaran']['pin']['tukang']['user']['name']}}</h6>
                        </div>
                        <div class="col-5 border-left">
                            <p class="text-muted mb-0 pb-0">Alamat</p>
                            <h6 class="mt-0 pt0">{{$dat['pembayaran']['pin']['pengajuan']['alamat']}}</h6>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-9">
                            <p class="text-muted mb-0 pb-1">Progress</p>
                            <div class="progress progress-xs progress-striped " style="height:25px">
                                <div class="progress-bar bg-info"
                                     style="width: {{(int)$dat['persentase_progress']}}%;height:25px"></div>
                            </div>
                        </div>
                        <div class="col-1">
                            <span class="badge text-info" style=" font-size:16pt; margin-top: 26px;">{{(int)$dat['persentase_progress']}}%</span>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <div class="col-12 float-right pb-1">
                                    <a href="{{route('show.project.client', $dat['id'])}}">
                                        <button class="btn btn-outline-info rounded-0 w-100"
                                                @if($dat['persentase_progress'] != 0) style="margin-top: 21px;" @endif>
                                            Lihat Detail
                                        </button>
                                    </a>
                                </div>
                                @if($dat['penarikan']['persentase_penarikan'] <= 50)
                                    @if($dat['kode_status'] == 'ON01' || $dat['kode_status'] == 'ON02' || $dat['kode_status'] == 'ON04')
                                        <div class="col-12 float-right pb-1">
                                            <button id="btn_cancle_proyek" value="{{$dat['id']}}" class="btn btn-outline-danger rounded-0 w-100">Batal</button>
                                            <form id="batal-form-{{$dat['id']}}" action="{{ route('client_cancle.projek', $dat['id']) }}"
                                                  method="GET"
                                                  class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    @if($data['total'] == 0)
                        Belum Ada Data
                    @else
                        @foreach($data['links'] as $dat)
                            <li class="page-item {{$dat['active'] ? "active" : ""}} {{$dat['url'] ?? 'disabled'}}">
                                <a class="page-link" href="{{$dat['url']}}">@php echo $dat['label']; @endphp</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </nav>
        </div>
    </div>

@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/all_client_project.js') }}" defer></script>
@endsection
