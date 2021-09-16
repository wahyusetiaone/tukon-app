<div class="col-12">
    <div class="row align-items-center">
        <div class="col-2 pl-4">
            <a href="/">
                <img width="134px" height="74px" src="{{asset('images/tukon_icon.png')}}">
            </a>
        </div>
        <div class="col-8 pl-0 pt-4 m-0">
            <div class="row bg-white align-items-center p-0 m-0">
                <div class="col-2 p-0 m-0">
                    <select class="form-control border-0 bg-gray-light" style="border-radius: 0 !important;"
                            id="filter_search">
                        <option class="select2-results__option" style="background-color: rgba(221, 240, 255, 0.85);"
                                value="produk">PRODUK
                        </option>
                        <option class="select2-results__option" style="background-color: rgba(221, 240, 255, 0.85);"
                                value="tukang">TUKANG
                        </option>
                    </select>
                </div>
                <div class="col-9 p-0 m-0">
                    <div class="form-group p-0 m-0">
                        <input type="text" class="form-control border-0" placeholder="Cari Jasa apa hari ini ?"
                               id="search_input">
                    </div>
                </div>
                <div class="col-1 p-0 m-0">
                    <button type="button" id="btn-search" class="btn btn-primary btn-block border-0"
                            style="border-radius: 0 !important; background-color: #008CC6;"><i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-2 pl-0 pt-4">
            <div class="float-right pr-5">
                <div class="row align-items-center">
                    <div class="col-4">
                        <a href="{{route('wishlist')}}">
                            <img width="31px" height="27px" src="{{asset('images/icons/wishlist.svg')}}">
                        </a>
                    </div>
                    <div class="col-4">
                        <div class="item-kw">
                            <a href="{{route('notification.client')}}">
                                <span class="item-kw-notify-badge">0</span>
                                <img src="{{asset('images/icons/icon_notif.svg')}}"  alt="" />
                            </a>
                        </div>
{{--                        <span class="badge badge-light">9</span>--}}
{{--                        <img width="32px" height="30px" src="{{asset('images/icons/icon_notif.svg')}}">--}}
                    </div>
                    <div class="col-4">
                        <div class="dropdown">
                            @if (Route::has('login'))
                                @auth
                                    @php
                                        $user = auth()->user();
                                        $user->load('client');
                                    @endphp
                                    <img class="dropbtn img-circle" width="49px" height="49px"
                                         src="{{asset($user->client->path_foto)}}">
                                    <div class="dropdown-content">
                                        <a href="{{route('show.user.ptofile.client')}}">Profile</a>
                                        <a href="{{route('penawaran.client')}}">Pesanan</a>
                                        <a href="#"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                @else
                                    <img class="dropbtn" width="49px" height="49px"
                                         src="{{asset('images/icons/profile.svg')}}">
                                    <div class="dropdown-content">
                                        <a href="{{route('panel.login')}}">Login</a>
                                        <a href="{{route('panel.register')}}">Daftar</a>
                                    </div>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
