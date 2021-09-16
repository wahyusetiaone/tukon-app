@extends('layouts.v2.app_client')

@section('third_party_stylesheets')
    <style type="text/css">
        .img-cropped {
            object-fit: cover;
            object-position: center center;
            width: 268px;
            height: 288px;
        }
    </style>
@endsection

@section('content')
    <div class="col-3 pl-4 pr-4 pt-5">
        <div class="card bg-white rounded-0 p-3 shadow-none">
            <div class="text-center pt-3">
                @php
                    $user = auth()->user();
                    $user->load('client');
                @endphp
                @if(isset($user->client->path_foto))
                    <img height="100px;" class="profile-user-img img-circle"
                         src="{{asset($user->client->path_foto)}}"
                         alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle"
                         src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAllBMVEUAmf8Al/8Alf8Ak/8Am/8Amv+Dyv8Anf/x+v////9Drv8An//t9/8Akf+23v/2/f/A4/+y2f8hpf8sqf8Aof/U7v90wP/p9P8Ajf+V0//o+P9OrP/e8v+k1f+Nyv9tvP9Zuv/M5/9Ktf9ctP/X8f/W6f9esP9Fqf96xP85sP+t3/+R0f8mqv9uuP9Yu/93v/+Kxv+34/9+itgGAAADxklEQVR4nO3Ya3uaShSGYdaMAorKWSsHD7FR0yRt8///3AYEDWjc/dCQva/rub+Y107GWTCzMDUMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA/AfJ35qnM9H92BelgjC09PnTtRUGA2V8EO+QYmgYqPNYKSZ2LjV3Ym9UlC9s257MgtPKVDCbFNFUciveI5vHYqgdm9M6rxcTe7IN1c3Ym+Jzlw/OVL149qtUyxz5L4Z6yOLAuI736LfHYyDT6DjxBmWOtu5DpIPl6Cg3Yo+CsNqfYuRJce1lPJqXt0tFW+863iVPw+r2qMD+Xfyg/azcFaI29k6u4leQnVu+5N/1KW7cUK7i/Rnq1+mbX/wYufPTftRvM+sqfgUJ7aFhHJLmCk8fZ7oba9bg/EvO8HomtSwqVMusOX97N5VO/JwS/oX6XexS2SeH+uOVuVCdWI+Uld+sNvJubDmdFLtUP+bN+CB7lU78rCI+JCJ6PDkqQ47njiIPk0C1YzN87J6WK07sOd2JlMqz4k1rMW/qcLbPqhM/sZZbBod0v15mm7KjLL3zIQnsULdjs0ax3PIsSRh731ozBWm6N2OvfOaF9lMzfDhb6nbsu8LDW5yMsgepKpydz9jAfdLteHl2jxczVd7BQWsi9RzH7mhZPVjDdxfE/6Hb8Qvu4WFXXHqrXaHljnU7Xo6PFBu1LLBzoIL0kM5/TNa6qvA8+FThu9h3hafjI/73ogM+X7alU1TYju/qEcsedbZoPZHo0C0e6uHk5Ty8rLAV+6+wWlw02Ygyt03rkKei07Tj+9FOPPI/WKg246iarc6W96w68a+v/o/oRa7kNTs3z5+LQSdexpZncGznt1cqO/sganFs/jWK5934Ccv/A9OsqDBN9s0DcLbVnXgeWnVRdeqo12RfVug34yW19934aUXcVT2yrO2yXkkw+XkVa3UXrTrqjYlkHkfF89MO6r9OVtexV1IvUv8aReX3lZFTvaFXiXEVa1HdRcuO+m6m+g8s+ZbMypckr7JodyVXsU/mKrAMGUQruzopkmc7S4xo5VatoRNP8qaLirNYn9923nbRUMQZb4tGU5af5MW9s8ZZ1Y87sU87L/Z8f5bFx1MnsfzMK2O99E6sXHaZRJdv3sM83s58P068+uG+KbOXeMObsT9ipb9M8/gaNR88SNem+WG8N1OwN01znTYlSLQ7mse0uQad2Kfy2/L7/z6p8ofx7kzqaqY7EQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA4H/lHxB4QrAbb7G8AAAAAElFTkSuQmCC"
                         alt="User profile picture">
                @endif
            </div>

            <h3 class="profile-username text-center">{{$user->name}}</h3>
            <p class="text-muted text-center m-0">{{$user->client->kota}}</p>
            <nav class="mt-2 pl-3 pr-3 pt-4">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item  border-0">
                        <a href="{{ route('show.user.ptofile.client') }}"
                           class="nav-link {{ (request()->segment(3) == 'profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li class="nav-item border-0">
                        <a href="{{ route('penawaran.client') }}"
                           class="nav-link
                            {{ (request()->segment(2) == 'penawaran') ? 'active' : '' }}
                            {{ (request()->segment(2) == 'pembayaran') ? 'active' : '' }}
                            {{ (request()->segment(2) == 'project') ? 'active' : '' }}
                               ">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Pesanan Saya</p>
                        </a>
                    </li>
                    <li class="nav-item  border-0 pl-5 pr-5 pt-2">
                        <a href="#" class="btn btn-block rounded-0" style="background-color: #008CC6; color: white;"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="col-9 pl-4 pr-4 pt-5">
        @stack('nav_menu')
        <div class="card w-100 bg-white rounded-0 shadow-none border-0 p-4 mb-5">
            @yield('sub_contains')
        </div>
    </div>
    <!-- /.content -->
@endsection

@section('third_party_scripts')
@endsection
