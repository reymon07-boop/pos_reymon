@extends('layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')

@include('layouts.navbar')

<div class="sales-dashboard-container">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="sales-header">

        <div class="header-content">

            <div class="title-icon">
                💰
            </div>

            <div>
                <div class="header-label">
                    REMON THRIFT HOUSE
                </div>

                <h1 class="page-title">
                    Daftar Penjualan
                </h1>

                <p class="page-subtitle">
                    Kelola riwayat transaksi dan pencatatan kasir aplikasi POS dengan mudah.
                </p>
            </div>

        </div>


        <a
            href="{{ route('penjualan.create') }}"
            class="btn-create-new"
        >
            <i class="bi bi-plus-lg"></i>

            <span>
                Tambah Penjualan Baru
            </span>
        </a>

    </div>


    {{-- =========================
         STATISTIC
    ========================== --}}
    <div class="row g-3 mb-4">

        <div class="col-12">

            <div class="stat-card">

                <div class="stat-icon icon-emerald">
                    📊
                </div>

                <div class="stat-content">

                    <span class="stat-label">
                        TOTAL TRANSAKSI
                    </span>

                    <h4 class="stat-value">

                        {{ method_exists($sales, 'total') ? $sales->total() : count($sales) }}

                    </h4>

                    <span class="stat-desc">
                        Data transaksi tercatat
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         SUCCESS MESSAGE
    ========================== --}}
    @if(session('success'))

        <div
            class="alert alert-custom-success fade show mb-4"
            role="alert"
        >

            <div class="alert-icon">
                ✓
            </div>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- =========================
         MAIN CARD
    ========================== --}}
    <div class="page-card">


        {{-- =========================
             CARD HEADER
        ========================== --}}
        <div class="table-card-header">

            <div>

                <h5 class="table-title">
                    Riwayat Transaksi
                </h5>

                <p class="table-subtitle">
                    Daftar seluruh transaksi penjualan yang tersimpan.
                </p>

            </div>

            <div class="transaction-badge">
                🧾 Transaksi
            </div>

        </div>


        {{-- =========================
             SEARCH
        ========================== --}}
        <form
            action="{{ route('penjualan.index') }}"
            method="GET"
            class="mb-4"
        >

            <div class="search-box">

                <span class="search-icon">
                    🔍
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control custom-search-input"
                    placeholder="Cari berdasarkan kasir atau metode pembayaran..."
                >

                <button
                    class="btn-search"
                    type="submit"
                >
                    <i class="bi bi-search"></i>
                    Cari Data
                </button>

            </div>

        </form>


        {{-- =========================
             TABLE
        ========================== --}}
        <div class="table-responsive">

            <table class="table table-modern align-middle mb-0">

                <thead>

                    <tr>

                        <th
                            width="5%"
                            class="text-center"
                        >
                            #
                        </th>

                        <th width="20%">
                            TANGGAL TRANSAKSI
                        </th>

                        <th width="18%">
                            KASIR
                        </th>

                        <th width="18%">
                            TOTAL PEMBAYARAN
                        </th>

                        <th width="12%">
                            METODE
                        </th>

                        <th width="12%">
                            STATUS
                        </th>

                        <th
                            width="15%"
                            class="text-center"
                        >
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($sales as $sale)

                        <tr>

                            {{-- NOMOR --}}

                            <td class="text-center row-number">

                                {{ method_exists($sales, 'firstItem')
                                    ? $sales->firstItem() + $loop->index
                                    : $loop->iteration
                                }}

                            </td>


                            {{-- TANGGAL --}}

                            <td>

                                <div class="date-wrapper">

                                    <div class="date-icon">
                                        📅
                                    </div>

                                    <div>

                                        <div class="fw-semibold text-light">

                                            {{ $sale->created_at
                                                ? $sale->created_at->translatedFormat('d-m-Y')
                                                : '-'
                                            }}

                                        </div>

                                        <small class="time-text">

                                            {{ $sale->created_at
                                                ? $sale->created_at->translatedFormat('H:i:s')
                                                : '-'
                                            }}

                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- KASIR --}}

                            <td>

                                <div class="cashier-wrapper">

                                    <div class="cashier-avatar">
                                        👤
                                    </div>

                                    <div class="fw-semibold text-light">

                                        {{ optional($sale->user)->name ?? 'Kasir Umum' }}

                                    </div>

                                </div>

                            </td>


                            {{-- TOTAL --}}

                            <td>

                                <span class="total-payment">

                                    Rp
                                    {{ number_format(
                                        $sale->total_pembayaran,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- METODE --}}

                            <td>

                                @if(strtoupper($sale->metode_pembayaran ?? 'CASH') === 'QRIS')

                                    <span class="badge-custom badge-qris">
                                        ▣ QRIS
                                    </span>

                                @else

                                    <span class="badge-custom badge-cash">
                                        💵 CASH
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                @if(strtoupper($sale->status ?? '') == 'OPEN')

                                    <span class="badge-custom badge-warning">
                                        <span class="status-dot warning-dot"></span>
                                        OPEN
                                    </span>

                                @else

                                    <span class="badge-custom badge-success">
                                        <span class="status-dot success-dot"></span>
                                        COMPLETED
                                    </span>

                                @endif

                            </td>


                            {{-- ACTION --}}

                            <td class="text-center">

                                <div class="d-flex justify-content-center">

                                    <a
                                        href="{{ route('penjualan.show', $sale) }}"
                                        class="btn-action-continue"
                                        title="Continue"
                                    >

                                        <span>
                                            Continue
                                        </span>

                                        <i class="bi bi-arrow-right"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="empty-state">

                                    <div class="empty-icon">
                                        🧾
                                    </div>

                                    <h6 class="empty-title">
                                        Data Penjualan Kosong
                                    </h6>

                                    <p class="empty-text">
                                        Belum ada transaksi yang tercatat di sistem.
                                    </p>

                                    <a
                                        href="{{ route('penjualan.create') }}"
                                        class="empty-button"
                                    >
                                        + Tambah Penjualan
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================
             PAGINATION
        ========================== --}}
        @if(method_exists($sales, 'links'))

            <div class="pagination-wrapper">

                {{ $sales->appends(request()->query())->links() }}

            </div>

        @endif

    </div>

</div>


<style>

/* =========================================================
   MAIN CONTAINER
========================================================= */

.sales-dashboard-container {

    position: relative;

    min-height: 100vh;

    padding: 28px;

    color: #e2e8f0;

    background:
        radial-gradient(
            circle at 5% 10%,
            rgba(16, 185, 129, 0.13),
            transparent 32%
        ),
        radial-gradient(
            circle at 95% 80%,
            rgba(59, 130, 246, 0.08),
            transparent 30%
        ),
        radial-gradient(
            circle at 50% 100%,
            rgba(16, 185, 129, 0.06),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #020807 0%,
            #03120f 45%,
            #020609 100%
        );

}


/* =========================================================
   HEADER
========================================================= */

.sales-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 28px;

    position: relative;

    z-index: 2;

}


.header-content {

    display: flex;

    align-items: center;

    gap: 15px;

}


.title-icon {

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 15px;

    font-size: 23px;

    background:
        linear-gradient(
            135deg,
            rgba(16, 185, 129, 0.20),
            rgba(16, 185, 129, 0.07)
        );

    border:
        1px solid rgba(16, 185, 129, 0.22);

    box-shadow:
        0 10px 25px rgba(16, 185, 129, 0.08);

}


.header-label {

    color: #34d399;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 1.1px;

    margin-bottom: 3px;

}


.page-title {

    font-size: 27px;

    font-weight: 800;

    color: #ffffff;

    letter-spacing: -0.7px;

    margin: 0 0 4px;

}


.page-subtitle {

    color: #81918f;

    font-size: 13px;

}


/* =========================================================
   CREATE BUTTON
========================================================= */

.btn-create-new {

    background:
        linear-gradient(
            135deg,
            #10c998,
            #06a879
        );

    color: #ffffff;

    padding: 11px 19px;

    border-radius: 12px;

    font-weight: 700;

    font-size: 13px;

    text-decoration: none;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    border:
        1px solid rgba(52, 211, 153, 0.25);

    box-shadow:
        0 8px 22px rgba(0, 200, 145, 0.18);

    transition:
        all 0.25s ease;

    white-space: nowrap;

}


.btn-create-new:hover {

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 28px rgba(0, 220, 160, 0.28);

}


/* =========================================================
   STAT CARD
========================================================= */

.stat-card {

    height: 100%;

    background:
        linear-gradient(
            145deg,
            rgba(14, 32, 37, 0.88),
            rgba(8, 23, 28, 0.78)
        );

    border:
        1px solid rgba(255, 255, 255, 0.08);

    backdrop-filter:
        blur(14px);

    border-radius: 17px;

    padding: 19px;

    display: flex;

    align-items: center;

    gap: 15px;

    box-shadow:
        0 12px 32px rgba(0, 0, 0, 0.27);

    transition:
        all 0.25s ease;

}


.stat-card:hover {

    transform:
        translateY(-3px);

    border-color:
        rgba(16, 185, 129, 0.20);

    box-shadow:
        0 16px 35px rgba(0, 0, 0, 0.35);

}


.stat-icon {

    width: 49px;

    height: 49px;

    flex-shrink: 0;

    border-radius: 13px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

}


.icon-emerald {

    background:
        rgba(16, 185, 129, 0.13);

    border:
        1px solid rgba(16, 185, 129, 0.17);

}


.icon-blue {

    background:
        rgba(59, 130, 246, 0.13);

    border:
        1px solid rgba(59, 130, 246, 0.17);

}


.icon-amber {

    background:
        rgba(245, 158, 11, 0.13);

    border:
        1px solid rgba(245, 158, 11, 0.17);

}


.stat-content {

    min-width: 0;

}


.stat-label {

    font-size: 10px;

    font-weight: 800;

    color: #64748b;

    letter-spacing: 0.9px;

    display: block;

    margin-bottom: 3px;

}


.stat-value {

    font-size: 17px;

    font-weight: 800;

    color: #ffffff;

    margin: 0;

}


.stat-desc {

    display: block;

    margin-top: 2px;

    font-size: 10px;

    color: #64748b;

}


/* =========================================================
   SUCCESS ALERT
========================================================= */

.alert-custom-success {

    background:
        rgba(16, 185, 129, 0.10);

    color:
        #6ee7b7;

    border:
        1px solid rgba(16, 185, 129, 0.22);

    border-radius: 13px;

    padding: 12px 16px;

    font-size: 13px;

    display: flex;

    align-items: center;

    gap: 10px;

}


.alert-icon {

    width: 25px;

    height: 25px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background:
        rgba(16, 185, 129, 0.16);

    font-weight: 800;

}


/* =========================================================
   MAIN CARD
========================================================= */

.page-card {

    position: relative;

    z-index: 2;

    background:
        linear-gradient(
            145deg,
            rgba(10, 27, 32, 0.88),
            rgba(7, 20, 25, 0.82)
        );

    border:
        1px solid rgba(255, 255, 255, 0.08);

    backdrop-filter:
        blur(17px);

    border-radius: 21px;

    padding: 24px;

    box-shadow:
        0 22px 55px rgba(0, 0, 0, 0.40);

}


/* =========================================================
   TABLE CARD HEADER
========================================================= */

.table-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    margin-bottom: 19px;

}


.table-title {

    color: #ffffff;

    font-size: 16px;

    font-weight: 800;

    margin: 0 0 3px;

}


.table-subtitle {

    color: #64748b;

    font-size: 11px;

    margin: 0;

}


.transaction-badge {

    color: #34d399;

    background:
        rgba(16, 185, 129, 0.09);

    border:
        1px solid rgba(16, 185, 129, 0.18);

    border-radius: 30px;

    padding: 7px 12px;

    font-size: 10px;

    font-weight: 700;

    white-space: nowrap;

}


/* =========================================================
   SEARCH
========================================================= */

.search-box {

    position: relative;

    display: flex;

    align-items: center;

    background:
        rgba(16, 28, 39, 0.68);

    border:
        1px solid rgba(255, 255, 255, 0.10);

    border-radius: 13px;

    padding: 4px;

    transition:
        all 0.25s ease;

}


.search-box:focus-within {

    border-color:
        rgba(16, 185, 129, 0.42);

    box-shadow:
        0 0 0 3px rgba(16, 185, 129, 0.07);

}


.search-icon {

    padding-left: 13px;

    font-size: 14px;

    opacity: 0.55;

}


.custom-search-input {

    background:
        transparent !important;

    border:
        none !important;

    color:
        #ffffff !important;

    box-shadow:
        none !important;

    padding:
        10px 13px;

    font-size: 13px;

}


.custom-search-input::placeholder {

    color:
        #536674;

}


.btn-search {

    background:
        linear-gradient(
            135deg,
            #10c998,
            #06a879
        );

    color:
        #ffffff;

    border:
        none;

    padding:
        10px 20px;

    border-radius:
        9px;

    font-weight:
        700;

    font-size:
        12px;

    transition:
        all 0.2s ease;

    white-space:
        nowrap;

}


.btn-search:hover {

    color: #ffffff;

    filter:
        brightness(1.08);

    transform:
        translateY(-1px);

}


/* =========================================================
   TABLE
========================================================= */

.table-responsive {

    border-radius:
        13px;

    overflow-x:
        auto;

}


.table-modern {

    color:
        #cbd5e1;

    min-width:
        900px;

}


.table-modern thead th {

    background:
        rgba(255, 255, 255, 0.025);

    color:
        #81918f;

    font-size:
        10px;

    font-weight:
        800;

    letter-spacing:
        0.75px;

    padding:
        14px 15px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.08);

    white-space:
        nowrap;

}


.table-modern tbody td {

    padding:
        15px;

    border-bottom:
        1px solid rgba(255, 255, 255, 0.045);

    background:
        transparent;

}


.table-modern tbody tr {

    transition:
        background 0.2s ease;

}


.table-modern tbody tr:hover {

    background:
        rgba(16, 185, 129, 0.035);

}


.table-modern tbody tr:last-child td {

    border-bottom:
        none;

}


/* =========================================================
   ROW NUMBER
========================================================= */

.table-modern tbody td.row-number {

    color:
        #00d99a !important;

    font-weight:
        800;

    font-size:
        14px;

}


/* =========================================================
   DATE
========================================================= */

.date-wrapper {

    display:
        flex;

    align-items:
        center;

    gap:
        10px;

}


.date-icon {

    width:
        32px;

    height:
        32px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        9px;

    background:
        rgba(59, 130, 246, 0.09);

    font-size:
        13px;

}


.time-text {

    color:
        #64748b;

    font-size:
        10px;

}


/* =========================================================
   CASHIER
========================================================= */

.cashier-wrapper {

    display:
        flex;

    align-items:
        center;

    gap:
        9px;

}


.cashier-avatar {

    width:
        32px;

    height:
        32px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        50%;

    background:
        rgba(139, 92, 246, 0.10);

    border:
        1px solid rgba(139, 92, 246, 0.14);

    font-size:
        12px;

}


/* =========================================================
   TOTAL PAYMENT
========================================================= */

.total-payment {

    color:
        #34d399;

    font-size:
        13px;

    font-weight:
        800;

    white-space:
        nowrap;

}


/* =========================================================
   BADGES
========================================================= */

.badge-custom {

    padding:
        6px 10px;

    border-radius:
        8px;

    font-size:
        10px;

    font-weight:
        800;

    letter-spacing:
        0.45px;

    display:
        inline-flex;

    align-items:
        center;

    gap:
        5px;

    white-space:
        nowrap;

}


.badge-qris {

    background:
        rgba(99, 102, 241, 0.12);

    color:
        #818cf8;

    border:
        1px solid rgba(99, 102, 241, 0.22);

}


.badge-cash {

    background:
        rgba(16, 185, 129, 0.10);

    color:
        #34d399;

    border:
        1px solid rgba(16, 185, 129, 0.20);

}


.badge-warning {

    background:
        rgba(245, 158, 11, 0.11);

    color:
        #fbbf24;

    border:
        1px solid rgba(245, 158, 11, 0.22);

}


.badge-success {

    background:
        rgba(16, 185, 129, 0.11);

    color:
        #34d399;

    border:
        1px solid rgba(16, 185, 129, 0.22);

}


.status-dot {

    width:
        6px;

    height:
        6px;

    border-radius:
        50%;

    display:
        inline-block;

}


.warning-dot {

    background:
        #fbbf24;

    box-shadow:
        0 0 7px rgba(251, 191, 36, 0.55);

}


.success-dot {

    background:
        #34d399;

    box-shadow:
        0 0 7px rgba(52, 211, 153, 0.55);

}


/* =========================================================
   CONTINUE BUTTON
========================================================= */

.btn-action-continue {

    background:
        rgba(0, 217, 154, 0.09);

    color:
        #00d99a;

    border:
        1px solid rgba(0, 217, 154, 0.20);

    border-radius:
        9px;

    padding:
        8px 13px;

    font-weight:
        700;

    font-size:
        11px;

    text-decoration:
        none;

    display:
        inline-flex;

    align-items:
        center;

    gap:
        7px;

    transition:
        all 0.22s ease;

}


.btn-action-continue:hover {

    background:
        #00d99a;

    color:
        #020807;

    box-shadow:
        0 5px 16px rgba(0, 217, 154, 0.25);

    transform:
        translateX(2px);

}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {

    padding:
        35px 15px;

}


.empty-icon {

    width:
        68px;

    height:
        68px;

    margin:
        0 auto 13px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        20px;

    background:
        rgba(16, 185, 129, 0.07);

    border:
        1px solid rgba(16, 185, 129, 0.12);

    font-size:
        31px;

}


.empty-title {

    color:
        #ffffff;

    font-size:
        15px;

    font-weight:
        800;

    margin-bottom:
        5px;

}


.empty-text {

    color:
        #64748b;

    font-size:
        11px;

    margin-bottom:
        15px;

}


.empty-button {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        8px 14px;

    border-radius:
        9px;

    background:
        rgba(16, 185, 129, 0.10);

    color:
        #34d399;

    border:
        1px solid rgba(16, 185, 129, 0.20);

    font-size:
        11px;

    font-weight:
        700;

    text-decoration:
        none;

}


.empty-button:hover {

    color:
        #ffffff;

    background:
        #10b981;

}


/* =========================================================
   PAGINATION
========================================================= */

.pagination-wrapper {

    display:
        flex;

    justify-content:
        flex-end;

    margin-top:
        22px;

}


.pagination-wrapper .pagination {

    margin:
        0;

}


.pagination-wrapper .page-link {

    background:
        rgba(255, 255, 255, 0.04);

    border-color:
        rgba(255, 255, 255, 0.08);

    color:
        #94a3b8;

}


.pagination-wrapper .page-link:hover {

    background:
        rgba(16, 185, 129, 0.10);

    color:
        #34d399;

}


.pagination-wrapper .page-item.active .page-link {

    background:
        #10b981;

    border-color:
        #10b981;

    color:
        #ffffff;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .sales-dashboard-container {

        padding:
            20px;

    }


    .sales-header {

        align-items:
            flex-start;

        flex-direction:
            column;

    }


    .btn-create-new {

        width:
            100%;

    }

}


@media (max-width: 576px) {

    .sales-dashboard-container {

        padding:
            14px;

    }


    .header-content {

        align-items:
            flex-start;

    }


    .title-icon {

        width:
            45px;

        height:
            45px;

        font-size:
            20px;

    }


    .page-title {

        font-size:
            22px;

    }


    .page-subtitle {

        font-size:
            11px;

        line-height:
            1.5;

    }


    .page-card {

        padding:
            15px;

        border-radius:
            17px;

    }


    .table-card-header {

        align-items:
            flex-start;

        flex-direction:
            column;

    }


    .transaction-badge {

        display:
            none;

    }


    .search-box {

        padding:
            4px;

    }


    .search-icon {

        padding-left:
            9px;

    }


    .custom-search-input {

        padding:
            9px 8px;

        font-size:
            12px;

    }


    .btn-search {

        padding:
            9px 12px;

        font-size:
            10px;

    }


    .stat-card {

        padding:
            16px;

    }


    .stat-value {

        font-size:
            15px;

    }


    .pagination-wrapper {

        justify-content:
            center;

        overflow-x:
            auto;

    }

}

</style>

@endsection