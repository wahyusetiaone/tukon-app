@extends('layouts.app_client')

@section('third_party_stylesheets')
    <link href="{{ asset('css/wishlist.css') }}" rel="stylesheet">
@endsection

@section('content')
    <br>
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
                            Nama Produk dan Tukang
                        </th>
                        <th style="width: 20%">
                            Gambar Produk
                        </th>
                        <th style="width: 30%">
                            Diskripsi Produk
                        </th>
                        <th>
                            Peringkat Tukang
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--                    {{var_dump($data)}}--}}
                    @foreach($data['data'] as $dat)
                        <tr>
                            <td>
                                #
                            </td>
                            <td>
                                <a>
                                    {{$dat['produk']['nama_produk']}}
                                </a>
                                <br/>
                                <small>
                                    {{$dat['produk']['tukang']['user']['name']}}
                                </small>
                            </td>
                            <td>
                                <ul class="list-inline">
                                    @if($dat['produk']['multipath'])
                                        @php
                                            $mpath = $dat['produk']['path'];
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
                                            {{--                                                <img alt="Img" class="img-thumbnail" src="{{url($path)}}">--}}
                                        </li>
                                    @else
                                        <li class="list-inline-item">
                                            <img alt="Img" class="img-thumbnail" src="{{asset($dat['produk']['path'])}}">
                                        </li>
                                    @endif
                                </ul>
                            </td>
                            <td class="project_progress">
                                {{$dat['produk']['diskripsi']}}
                            </td>
                            <td class="project-state">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $dat['produk']['tukang']['rate'])
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="#">
                                    <i class="fas fa-paper-plane">
                                    </i>
                                    Kirim Pengajuan
                                </a>
                                <button class="btn btn-danger btn-sm" value="{{$dat['id']}}" id="btn_remove_wishlist">
                                    <i class="fas fa-trash">
                                    </i>
                                    Hapus
                                </button>
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

            <a href="#" class="second-float">
                <h3 class="fa my-second-float">10</h3>
            </a>
            <a href="#" class="float" data-toggle="tooltip" data-placement="left" title="Kirim pengajuan ke banyak tukang">
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
