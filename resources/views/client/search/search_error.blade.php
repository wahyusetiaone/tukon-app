@extends('layouts.app_client')

@section('third_party_stylesheets')
{{--    <link href="{{ mix('css/home_client.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <br>
    <!-- Main content -->
    <section class="content">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100"
                         src="https://www.etcspl.com/wp-content/uploads/2017/11/e-commerce-banner.jpg"
                         alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <br>
        <!-- Default box -->
        <div class="row">
            <div class="col-md-2">
                <div class="card card-solid">
                    <div class="card-body pb-0">
                        ss
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <footer class=" text-right"><cite title="Source Title">Tukang Online</cite>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card card-solid">
                    <blockquote class="blockquote">
                        <p class="mb-0">Semua Produk</p>
                    </blockquote>
                    <div class="card-body pb-0">
                        <div class="row d-flex align-items-stretch justify-content-center">
                            <p>{{$obj}}</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <ul class="pagination justify-content-center">

                        </ul>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
{{--    <script src="{{ mix('js/home_client.js') }}" defer></script>--}}
@endsection
