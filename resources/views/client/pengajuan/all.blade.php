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
                    <h1 class="m-0">Daftar Pengajuan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('pengajuan.client')}}">Pengajuan</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pengajuan</h3>

                <div class="card-tools">

                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 20%">
                            Nama Proyek
                        </th>
                        <th style="width: 20%">
                            Gambar Buleprint
                        </th>
                        <th style="width: 30%">
                            Diskripsi Proyek
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
{{--                                        {{var_dump($data)}}--}}
                    @foreach($data['data'] as $dat)
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                <a>
                                    {{$dat['nama_proyek']}}
                                </a>
                                <br/>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    @if($dat['multipath'])
                                        @php
                                            $mpath = $dat['path'];
                                            $apath = explode(',',$mpath);
                                            $cpath = count($apath);
                                        @endphp
                                        <li class="list-inline-item">
                                            <div id="carouselExampleIndicators" class="carousel slide"
                                                 data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    @for($i=0;$i<$cpath;$i++)
                                                        <li data-target="#carouselExampleIndicators"
                                                            data-slide-to="{{$i}}"
                                                            class="{{ $i == 0  ? 'active' : '' }}"></li>
                                                    @endfor
                                                </ol>
                                                <div class="carousel-inner">
                                                    @foreach($apath as $key=>$path)
                                                        <div class="carousel-item {{ $key == 0  ? 'active' : '' }}">
                                                            <img class="d-block w-100" src="{{asset($path)}}"
                                                                 alt="First slide">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                                                                            <img alt="Img" class="img-thumbnail" src="{{url($path)}}">
                                        </li>
                                    @else
                                        <li class="list-inline-item">
                                            <img alt="Img" class="img-thumbnail" src="{{asset($dat['path'])}}">
                                        </li>
                                    @endif
                                </ul>
                            </td>
                            <td class="project_progress">
                                {{$dat['diskripsi_proyek']}}
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{route('show.pengajuan.client',$dat['id'])}}">
                                    <i class="fas fa-eye">
                                    </i>
                                    Lihat Pengajuan
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
{{--    <script src="{{ asset('js/wishlist.js') }}" defer></script>--}}
@endsection
