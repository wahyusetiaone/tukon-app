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
        <li class="nav-item">
            <a href="{{ route('pengajuan') }}" class="nav-link {{ (request()->segment(1) == 'pengajuan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-inbox"></i>
                <p>Pengajuan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penawaran') }}" class="nav-link {{ (request()->segment(1) == 'penawaran') ? 'active' : '' }}">
                <i class="nav-icon fas fa-download"></i>
                <p>Penawaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penawaran.offline') }}" class="nav-link {{ (request()->segment(1) == 'penawaran-offline') ? 'active' : '' }}">
                <i class="nav-icon fas fa-download"></i>
                <p>Penawaran Offline</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('projek') }}" class="nav-link {{ (request()->segment(1) == 'projek') ? 'active' : '' }}">
                <i class="nav-icon fas fa-building"></i>
                <p>Projek</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('history') }}" class="nav-link {{ (request()->segment(1) == 'history') ? 'active' : '' }}">
                <i class="nav-icon fas fa-history"></i>
                <p>Riwayat Projek</p>
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



