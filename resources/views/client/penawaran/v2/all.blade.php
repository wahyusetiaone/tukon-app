@extends('layouts.v2.app_client_child')

@section('third_party_stylesheets')
    <style type="text/css">
        .active{
            background-color: transparent!important;
            color: #008CC6!important;
        }
    </style>
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@push('nav_menu')
    @include('layouts.v2.components.nav_menu_child')
@endpush

@section('sub_contains')
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>PIN ID</th>
                    <th>Nama Proyek</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['data'] as $dat)
                    <tr class="bg-gray-light" aria-expanded="false">
                        <td>{{$dat['pin'][0]['id']}}</td>
                        <td>{{$dat['nama_proyek']}}</td>
                        <td>{{indonesiaDate($dat['created_at'])}}</td>
                        <td>{{$dat['pin'][0]['status']}}</td>
                        <td>
                            <a class="btn btn-info btn-sm"
                               href="{{route('show.pengajuan.client',$dat ['id'])}}">
                                <i class="fas fa-eye">
                                </i>
                                Lihat Pengajuan
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tukang</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($dat['pin'] as $pen)
                                    <tr>
                                        <td>{{$pen['id']}}</td>
                                        <td>{{$pen['tukang']['user']['name']}}</td>
                                        <td>
                                            @if(isset($pen['penawaran']['created_at']))
                                                {{indonesiaDate($pen['penawaran']['created_at'])}}
                                            @else
                                                Belum mengajukan penawaran
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($pen['penawaran']['kode_status']))
                                                <span
                                                    class="tag tag-success">{{$pen['penawaran']['kode_status']}}
                                                            </span>
                                            @else
                                                <span
                                                    class="tag tag-success">Belum mengajukan penawaran
                                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($pen['penawaran']['kode_status']))
                                                <a class="btn btn-info btn-sm"
                                                   href="{{route('show.penawaran.client',$pen['penawaran']['id'])}}">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                    Lihat Penawaran
                                                </a>
                                            @else
                                                <a class="btn btn-info btn-sm disabled" href="#">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                    Lihat Penawaran
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    @foreach($data['links'] as $dat)
                        <li class="page-item {{$dat['active'] ? "active" : ""}} {{$dat['url'] ?? 'disabled'}}">
                            <a class="page-link" href="{{$dat['url']}}">@php echo $dat['label']; @endphp</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

@endsection

@section('third_party_scripts')
    {{--    <script src="{{ asset('js/wishlist.js') }}" defer></script>--}}
@endsection
