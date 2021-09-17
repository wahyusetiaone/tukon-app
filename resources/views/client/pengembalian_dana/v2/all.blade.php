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
                            @if($dat['kode_status'] == 'PM01')
                                <span class="text-muted">Meunggu Pengajuan</span>
                            @elseif($dat['kode_status'] == 'PM02')
                                <span class="text-warning">Pengajuan Dalam Proses</span>
                            @elseif($dat['kode_status'] == 'PM03')
                                <span class="text-info">Selesai</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <span class=" float-right"><span class="text-info">Tanggal Pembatalan :</span> {{indonesiaDate($dat['created_at'])}}</span>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-6">
                            <p class="text-muted mb-0 pb-0">Nama Proyek</p>
                            <h6 class="mt-0 pt0">{{$dat['project']['pembayaran']['pin']['pengajuan']['nama_proyek']}}</h6>
                        </div>
                        <div class="col-3 border-left">
                            <p class="text-muted mb-0 pb-0">Pengembalian</p>
                            <h6 class="mt-0 pt0">{{indonesiaRupiah($dat['jmlh_pengembalian'])}}</h6>
                        </div>
                        <div class="col-1">
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <div class="col-12 float-right pb-1">
                                   @if($dat['kode_status'] == 'PM01')
                                        <a href="{{route('show.pengembalian-dana.client', $dat['id'])}}">
                                            <button class="btn btn-outline-warning rounded-0 w-100">
                                                Ajukan
                                            </button>
                                        </a>
                                    @else
                                        <a href="{{route('show.pengembalian-dana.client', $dat['id'])}}">
                                            <button class="btn btn-outline-info rounded-0 w-100">
                                                Lihat Detail
                                            </button>
                                        </a>
                                    @endif
                                </div>
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
