@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
@endsection

@section('content')
    <div class="col-12 p-4">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="card bg-white border-0 rounded-0 shadow-none">
                    <div class="row">
                        <div class="col-12 p-2 pl-4 pr-4">
                            Notifikasi
                        </div>
                    </div>
                </div>
                <div class="card bg-white border-0 rounded-0 shadow-none">
                    <div class="row">
                        <div class="col-12 p-4">
                            @if(count($data) == 0)
                                Belum Ada Data
                            @else
                                @foreach($data as $dat)
                                    @if($dat->read)
                                        <div class="card shadow-none pl-3 pr-3 pt-1 mb-2 d-flex mb-0 rounded-0">
                                            <p class="text-muted mb-0 pb-0">
                                                {{$dat->name}}
                                            </p>
                                            <h6 class="mt-0 pt0">
                                                {{$dat->message}}
                                            </h6>
                                        </div>
                                    @else
                                        <a href="{{route('notification.client.read',[$dat->id, $dat->deep_id,$dat->title])}}">
                                            <div class="card shadow-none bg-gray-light pl-3 pr-3 pt-1 mb-2 d-flex mb-0 rounded-0">
                                                <p class="text-muted mb-0 pb-0">
                                                    {{$dat->name}}
                                                </p>
                                                <h6 class="mt-0 pt0">
                                                    {{$dat->message}}
                                                </h6>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    {!! $data->links("pagination::bootstrap-4") !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
@endsection
