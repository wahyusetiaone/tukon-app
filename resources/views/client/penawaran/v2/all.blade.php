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
        <div class="col-12 pb-3">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-2">
                    <a class="btn btn-block rounded-0 {!! (!request()->exists('only')) ? 'btn-info' : 'btn-outline-info'  !!}"
                    {!!  (!request()->exists('only')) ? 'style="pointer-events: none;cursor: default;" onclick="return false"' : ''  !!}
                    href="{{route('penawaran.client')}}">
                        Aktif
                    </a>
                </div>
                <div class="col-2">
                    <a class="btn btn-block rounded-0 {!!(request()->exists('only')) ? ((request()->input('only') == 'batal') ? 'btn-info"' : 'btn-outline-info') : 'btn-outline-info' !!}"
                       {!!(request()->exists('only')) ? ((request()->input('only') == 'batal') ? 'style="pointer-events: none;cursor: default;" onclick="return false"' : '') : '' !!}
                       href="{{route('penawaran.client', ['only'=>'batal'])}}">
                        Batal
                    </a>
                </div>
            </div>
        </div>
        @foreach($data['data'] as $dat)
            <div class="col-12 pb-3">
                <div class="card shadow-sm bg-gradient-light p-3 mb-0 d-flex rounded-0">
                    <div class="row">
                        <div class="col-9">
                            <h4>{{$dat['nama_proyek']}}</h4>
                            @switch($dat['pin'][0]['status'])
                                @case('N01') @case('D01A') @case('D01B')
                                <p class="p-0 m-0 text-info">Aktif</p>
                                @break

                                @case('B01') @case('B02')
                                <p class="p-0 m-0 text-danger">Batal</p>
                                @break

                                @default
                                <span>Something went wrong, please try again</span>
                            @endswitch
                        </div>
                        <div class="col-3">
                            <a href="{{route('show.pengajuan.client',$dat['id'])}}">
                                <button class="btn btn-info float-right">Lihat Pengajuan</button>
                            </a>
                        </div>
                    </div>
                </div>
                @foreach($dat['pin'] as $pen)
                    <div class="card shadow-none bg-gray-light pl-3 pr-3 pt-1 pb-2 d-flex mb-0 rounded-0">
                        <div class="row">
                            <div class="col-3">
                                <p class="text-muted mb-0 pb-0">Penyedia Jasa</p>
                                <h5 class="mt-0 pt0">{{$pen['tukang']['user']['name']}}</h5>
                            </div>
                            <div class="col-4 border-left">
                                <p class="text-muted mb-0 pb-0">Tanggal Pengajuan</p>
                                @if(isset($pen['penawaran']['created_at']))
                                    <h5 class="mt-0 pt0">{{indonesiaDate($pen['penawaran']['created_at'])}}</h5>
                                @else
                                    Blm mengajukan penawaran
                                @endif
                            </div>
                            <div class="col-3 border-left">
                                <p class="text-muted mb-0 pb-0">Status</p>
                                @if(isset($pen['penawaran']['kode_status']))
                                    <span
                                        class="tag tag-success">{{$pen['penawaran']['kode_status']}}
                                                            </span>
                                @else
                                    <span
                                        class="tag tag-success">Blm mengajukan penawaran
                                                            </span>
                                @endif
                            </div>
                            <div class="col-2">
                                @if(isset($pen['penawaran']['kode_status']))
                                    <a class="btn btn-outline-info float-right mt-3 btn-sm"
                                       href="{{route('show.penawaran.client',$pen['penawaran']['id'])}}">
                                        <i class="fas fa-eye">
                                        </i>
                                        Lihat
                                    </a>
                                @else
                                    <a class="btn btn-outline-secondary float-right mt-3 disabled" href="#">
                                        <i class="fas fa-eye">
                                        </i>
                                        Lihat
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
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
