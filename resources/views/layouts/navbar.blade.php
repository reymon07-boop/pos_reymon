<nav class="navbar navbar-expand-lg navbar-dark shadow-lg navbar-modern">

<style>
.navbar-modern {
    background: linear-gradient(
        135deg,
        #052e16,
        #064e3b,
        #065f46
    );
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
    background: #10b981;
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
    background: #10b981;
    color: white !important;
    box-shadow: 0 5px 15px rgba(16, 185, 129, .4);
}

/* JAM / WAKTU */
.clock-box {
    background: rgba(16, 185, 129, 0.2);
    border: 1px solid rgba(16, 185, 129, 0.4);
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
</style>

<div class="container-fluid px-0">

    {{-- BRAND / LOGO SEKARANG MEMBUKA HALAMAN TENTANG TOKO --}}
    <a class="navbar-brand d-flex align-items-center" href="{{ route('tentang.toko') }}">
        <span class="brand-icon">🛒</span>
        Remon Thrift House
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                    Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                    Penjualan
                </a>
            </li>

            {{-- MENU TENTANG SAYA --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tentang-saya*') ? 'active' : '' }}" href="{{ route('tentang.saya') }}">
                    Tentang Saya
                </a>
            </li>
        </ul>

        <!-- WAKTU & LOGOUT -->
        <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
            <div class="clock-box">
                <span>🕒</span>
                <span id="live-clock">--:--:-- WIB</span>
            </div>

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
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    document.getElementById('live-clock').textContent = `${hours}:${minutes}:${seconds} WIB`;
}

setInterval(updateClock, 1000);
updateClock();
</script>