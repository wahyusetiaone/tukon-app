<!-- need to remove -->

@auth('web')
    @if(Auth::guard('web')->user()->kode_role == 1)
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link active">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
        </a>
    </li>
    @endif
    @if(Auth::guard('web')->user()->kode_role == 2)
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>Home Tukang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('produk') }}" class="nav-link {{ (request()->segment(1) == 'produk') ? 'active' : '' }}">
                <i class="nav-icon fas fa-paperclip"></i>
                <p>Produk</p>
            </a>
        </li>
    @endif
    @if(Auth::guard('web')->user()->kode_role == 3)
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>Home Klien</p>
            </a>
        </li>
    @endif
@endauth

{{--@auth('client')--}}
{{--    <li class="nav-item">--}}
{{--        <a href="{{ route('home') }}" class="nav-link active">--}}
{{--            <i class="nav-icon fas fa-home"></i>--}}
{{--            <p>Home Klien</p>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--@endauth--}}

{{--@auth('tukang')--}}
{{--    <li class="nav-item">--}}
{{--        <a href="{{ route('home') }}" class="nav-link active">--}}
{{--            <i class="nav-icon fas fa-home"></i>--}}
{{--            <p>Home Tukang</p>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--@endauth--}}



