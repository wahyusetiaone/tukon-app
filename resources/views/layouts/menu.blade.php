<!-- need to remove -->

@auth('web')
    @if(Auth::guard('web')->user()->kode_role == 1)
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>Home</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pembayaran.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'pembayaran') ? 'active' : '' }}">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Pembayaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penarikan.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'penarikan-dana') ? 'active' : '' }}">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Penarikan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengembalian-dana.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'pengembalian-dana') ? 'active' : '' }}">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Pengembalian Dana</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penawaran.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'penawaran') ? 'active' : '' }}">
                <i class="nav-icon fas fa-download"></i>
                <p>Penawaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengajuan.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'pengajuan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-upload"></i>
                <p>Pengajuan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('verification-tukang.admin') }}"
               class="nav-link {{ (request()->segment(2) == 'verification-tukang') ? 'active' : '' }}">
                <i class="nav-icon fas fa-check"></i>
                <p>Verifikasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengguna.client.admin') }}"
               class="nav-link {{ (request()->segment(3) == 'klien') ? 'active' : '' }}">
                <i class="far fa-user nav-icon"></i>
                <p>Klien</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengguna.tukang.admin') }}"
               class="nav-link {{ (request()->segment(3) == 'tukang') ? 'active' : '' }}">
                <i class="far fa-user nav-icon"></i>
                <p>Penyedia Jasa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengguna.admincabang.admin') }}"
               class="nav-link {{ (request()->segment(3) == 'admin-cabang') ? 'active' : '' }}">
                <i class="far fa-user nav-icon"></i>
                <p>Admin Cabang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengaturan.bpa.index.admin') }}"
               class="nav-link {{ (request()->segment(3) == 'bpa') ? 'active' : '' }}">
                <i class="fas fa-cog nav-icon"></i>
                <p>BPA</p>
            </a>
        </li>
    @endif
    @if(Auth::guard('web')->user()->kode_role == 2)
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}">
                <i class="home"></i>
                <p>Home Tukang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('produk') }}" class="nav-link {{ (request()->segment(1) == 'produk') ? 'active' : '' }}">
                <i class="product"></i>
                <p>Produk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengajuan') }}"
               class="nav-link {{ (request()->segment(1) == 'pengajuan') ? 'active' : '' }}">
                <i class="basket"></i>
                <p>Pengajuan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penawaran') }}"
               class="nav-link {{ (request()->segment(1) == 'penawaran') ? 'active' : '' }}">
                <span class="nav-icon material-icons-outlined">local_offer</span>
                <p>Penawaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penawaran.offline') }}"
               class="nav-link {{ (request()->segment(1) == 'penawaran-offline') ? 'active' : '' }}">
                <span class="nav-icon material-icons-outlined">local_offer</span>
                <p>Penawaran Offline</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('projek') }}" class="nav-link {{ (request()->segment(1) == 'projek') ? 'active' : '' }}">
                <i class="construction"></i>
                <p>Projek</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('penarikan.dana') }}"
               class="nav-link {{ (request()->segment(1) == 'penarikan-dana') ? 'active' : '' }}">
                <span class="nav-icon material-icons-outlined">credit_score</span>
                <p>Penarikan Dana</p>
            </a>
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a href="{{ route('history') }}" class="nav-link {{ (request()->segment(1) == 'history') ? 'active' : '' }}">--}}
        {{--                <i class="nav-icon fas fa-history"></i>--}}
        {{--                <p>Riwayat Projek</p>--}}
        {{--            </a>--}}
        {{--        </li>--}}
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
