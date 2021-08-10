@extends('layouts.app_client')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Pembayaran</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('wishlist')}}">Wishlist</a></li>
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
                            Nama Project
                        </th>
                        <th style="width: 20%">
                            Tukang
                        </th>
                        <th style="width: 30%">
                            Tagihan
                        </th>
                        <th>
                            Status Pembayaran
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                                                            {{var_dump($data)}}--}}
                    @foreach($data['data'] as $dat)
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                {{$dat['pin']['pengajuan']['nama_proyek']}}
                            </td>
                            <td>
                                {{$dat['pin']['tukang']['user']['name']}}
                            </td>
                            <td class="project_progress">
                                {{indonesiaRupiah($dat['total_tagihan'])}}
                            </td>
                            <td class="project-state">
                                {{$dat['kode_status']}}
                            </td>
                            <td class="project-actions text-right">
                                <a href="{{route('show.pembayaran.client', $dat['id'])}}">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fas fa-eye">
                                        </i>
                                        Lihat Tagihan
                                    </button>
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

            <a href="#" class="second-float">
                <h3 class="fa my-second-float">10</h3>
            </a>
            <a href="#" class="float" data-toggle="tooltip" data-placement="left"
               title="Kirim pengajuan ke banyak tukang">
                <i class="fa fa-paper-plane my-float"></i>
            </a>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
    <script src="{{ asset('js/wishlist.js') }}" defer></script>
@endsection
