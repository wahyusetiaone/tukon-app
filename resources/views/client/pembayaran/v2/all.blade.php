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
                            @if($dat['kode_status'] == 'P01')
                                <span class="text-muted">Menuggu Pembayaran</span>
                            @elseif($dat['kode_status'] == 'P02')
                                <span class="text-red">Pembayaran Dibatalkan</span>
                            @elseif($dat['kode_status'] == 'P03')
                                <span class="text-info">Berhasil dibayar</span>
                            @endif
                        </div>
                        <div class="col-6">
                            <span class=" float-right"><span class="text-info">Tanggal Pemesanan :</span> {{indonesiaDate($dat['pin']['pengajuan']['created_at'])}}</span>
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-4">
                            <p class="text-muted mb-0 pb-0">Nama Proyek</p>
                            <h5 class="mt-0 pt0">{{$dat['pin']['pengajuan']['nama_proyek']}}</h5>
                        </div>
                        <div class="col-3 border-left">
                            <p class="text-muted mb-0 pb-0">Penyedia Jasa</p>
                            <h5 class="mt-0 pt0">{{$dat['pin']['tukang']['user']['name']}}</h5>
                        </div>
                        <div class="col-3 border-left">
                            <p class="text-muted mb-0 pb-0">Tagihan</p>
                            <h5 class="mt-0 pt0">{{indonesiaRupiah($dat['total_tagihan'])}}</h5>
                        </div>
                        <div class="col-2 border-left">
                            <p class="text-muted mb-0 pb-0">Status</p>
                            {{$dat['kode_status']}}
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{route('show.pembayaran.client', $dat['id'])}}">
                                    <button class="btn btn-outline-info rounded-0">Lihat Detail</button>
                                </a>
                                @if($dat['kode_status'] == 'P01')
                                    @if(isset($dat['invoice']))
                                        <a target="_blank"  href="{{$dat['invoice']['invoice_url']}}">
                                            <button class="btn btn-info rounded-0">Lihat Invoice</button>
                                        </a>
                                    @else
                                        <a href="{{route('bayar.pembayaran.client', $dat['id'])}}">
                                            <button class="btn btn-info rounded-0">Bayar</button>
                                        </a>
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
    {{--    <script src="{{ asset('js/wishlist.js') }}" defer></script>--}}
@endsection
