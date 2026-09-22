<nav class="navbar navbar-expand-lg navbar-dark shadow-lg navbar-modern">

    <style>
    .navbar-modern {
        background: linear-gradient(135deg,
                #2e042c,
                #0d064e,
                #065f46);
        padding: 15px 25px;
    }

    /* BRAND */
    .navbar-brand {
        font-size: 24px;
        font-weight: 800;
        color: white !important;
        text-decoration: none;
        transition: .3s;
    }

    .navbar-brand:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .brand-icon {
        width: 45px;
        height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #102fb9;
        border-radius: 15px;
        margin-right: 10px;
        font-size: 24px;
    }

    /* MENU */
    .nav-link {
        color: #d1fae5 !important;
        font-weight: 600;
        margin: 0 5px;
        padding: 10px 15px !important;
        border-radius: 12px;
        transition: .3s;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, .15);
        color: white !important;
        transform: translateY(-2px);
    }

    .nav-link.active {
        background: #5110b9;
        color: white !important;
        box-shadow: 0 5px 15px rgba(16, 185, 129, .4);
    }

    /* CLOCK */
    .clock-box {
        background: rgba(157, 16, 185, 0.2);
        border: 1px solid rgba(48, 31, 206, 0.4);
        color: #d1fae5;
        font-weight: 700;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* LOGOUT */
    .logout-btn {
        border: none;
        padding: 10px 22px;
        border-radius: 15px;
        background: #dc2626;
        color: white;
        font-weight: 700;
        transition: .3s;
        cursor: pointer;
    }

    .logout-btn:hover {
        background: #991b1b;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(220, 38, 38, .4);
    }

    /* MOBILE */
    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    /* LAPORAN */
    .laporan-menu {
        position: relative;
    }

    .laporan-badge {
        font-size: 9px;
        background: #10b981;
        color: white;
        padding: 2px 5px;
        border-radius: 5px;
        margin-left: 4px;
        vertical-align: top;
    }
    </style>


    <div class="container-fluid px-0">

        {{-- BRAND --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('tentang.toko') }}">

            <span class="brand-icon">🛒</span>

            Remon Thrift House

        </a>


        {{-- MOBILE BUTTON --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">


            {{-- MENU --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">


                {{-- DASHBOARD --}}
                <li class="nav-item">

                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">

                        Dashboard

                    </a>

                </li>


                {{-- USERS --}}
                @if(Auth::check() && Auth::user()->role->name === 'admin')

                <li class="nav-item">

                    <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                        href="{{ route('admin.users') }}">

                        Users

                    </a>

                </li>

                @endif


                {{-- PRODUK --}}
                <li class="nav-item">

                    <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">

                        Produk

                    </a>

                </li>


                {{-- PENJUALAN --}}
                <li class="nav-item">

                    <a class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}"
                        href="{{ route('penjualan.index') }}">

                        Penjualan

                    </a>

                </li>


                {{-- LAPORAN PENJUALAN KHUSUS ADMIN --}}
                @if(Auth::check() && Auth::user()->role->name === 'admin')

                <li class="nav-item laporan-menu">

                    <a class="nav-link {{ Request::is('admin/laporan-penjualan*') ? 'active' : '' }}"
                        href="{{ route('penjualan.laporan') }}">

                        Laporan Penjualan

                        <span class="laporan-badge">
                            ADMIN
                        </span>

                    </a>

                </li>

                @endif


                {{-- TENTANG SAYA --}}
                <li class="nav-item">

                    <a class="nav-link {{ Request::is('tentang-saya*') ? 'active' : '' }}"
                        href="{{ route('tentang.saya') }}">

                        Tentang Saya

                    </a>

                </li>

            </ul>


            {{-- WAKTU & LOGOUT --}}
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">


                {{-- JAM --}}
                <div class="clock-box">

                    <span>🕒</span>

                    <span id="live-clock">
                        --:--:-- WIB
                    </span>

                </div>


                {{-- LOGOUT --}}
                <form action="{{ route('logout') }}" method="POST" class="m-0">

                    @csrf

                    <button type="submit" class="logout-btn">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>


<!-- SCRIPT WAKTU REAL-TIME -->

<script>
function updateClock() {

    const now = new Date();

    const hours =
        String(now.getHours()).padStart(2, '0');

    const minutes =
        String(now.getMinutes()).padStart(2, '0');

    const seconds =
        String(now.getSeconds()).padStart(2, '0');

    const clock =
        document.getElementById('live-clock');

    if (clock) {

        clock.textContent =
            `${hours}:${minutes}:${seconds} WIB`;

    }

}

setInterval(updateClock, 1000);

updateClock();
</script>