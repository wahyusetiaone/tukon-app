@extends('layouts.app_client')

@section('third_party_stylesheets')
    {{--    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Penawaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('penawaran.client')}}">Penawaran</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar penawaran berdasarkan pengajuan.</h3>
                    </div>
                    <!-- ./card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>PIN ID</th>
                                <th>Nama Proyek</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Diskripsi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['data'] as $dat)
                                <tr data-widget="expandable-table" class="bg-gray-light" aria-expanded="false">
                                    <td>{{$dat['pin'][0]['id']}}</td>
                                    <td>{{$dat['nama_proyek']}}</td>
                                    <td>{{indonesiaDate($dat['created_at'])}}</td>
                                    <td>{{$dat['pin'][0]['status']}}</td>
                                    <td>{{$dat['diskripsi_proyek']}}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                           href="{{route('show.pengajuan.client',$dat ['id'])}}">
                                            <i class="fas fa-eye">
                                            </i>
                                            Lihat Penawaran
                                        </a>
                                    </td>
                                </tr>
                                <tr class="expandable-body">
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
                    <!-- /.card-body -->
                    <div class="card-footer">
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
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    {{--    <script src="{{ asset('js/wishlist.js') }}" defer></script>--}}
@endsection
