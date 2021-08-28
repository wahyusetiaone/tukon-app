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
                    <h1 class="m-0">Daftar Proyek</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('project.client')}}">Proyek</a></li>
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
                <h3 class="card-title">Wishlist</h3>

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
                        <th>
                            Alamat Proyek
                        </th>
                        <th style="width: 20%">
                            Tukang
                        </th>
                        <th style="width: 30%">
                            Progress
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['data'] as $dat)
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                {{$dat['pembayaran']['pin']['pengajuan']['nama_proyek']}}
                            </td>
                            <td>
                                {{$dat['pembayaran']['pin']['pengajuan']['alamat']}}
                            </td>
                            <td>
                                {{$dat['pembayaran']['pin']['tukang']['user']['name']}}
                            </td>
                            <td class="project_progress">
                                @if($dat['kode_status'] == 'ON03')
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar bg-danger" style="width: {{(int)$dat['persentase_progress']}}%"></div>
                                    </div>
                                    <span class="badge bg-danger">{{(int)$dat['persentase_progress']}}%</span>
                                    <span class="badge bg-danger">Batal</span>
                                @elseif($dat['kode_status'] == 'ON05')
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar bg-info" style="width: {{(int)$dat['persentase_progress']}}%"></div>
                                    </div>
                                    <span class="badge bg-info">{{(int)$dat['persentase_progress']}}%</span>
                                    <span class="badge bg-info">Selesai</span>
                                @else
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar bg-success"
                                             style="width: {{(int)$dat['persentase_progress']}}%"></div>
                                    </div>
                                    <span class="badge bg-success">{{(int)$dat['persentase_progress']}}%</span>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="{{route('show.project.client',$dat['id'])}}">
                                    <i class="fas fa-eye">
                                    </i>
                                    Lihat Proyek
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
            <!-- /.card-body -->
            <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    {{--    <script src="{{ asset('js/wishlist.js') }}" defer></script>--}}
@endsection
