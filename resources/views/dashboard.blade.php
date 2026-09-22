@extends('layouts.app')

@section('title', 'Dashboard POS')

@section('content')

@include('layouts.navbar')

<style>
body {
    background:
        radial-gradient(circle at 10% 10%, rgba(16, 185, 129, 0.08), transparent 25%),
        radial-gradient(circle at 90% 20%, rgba(56, 189, 248, 0.06), transparent 25%),
        linear-gradient(135deg, #07111c 0%, #0b1625 45%, #071c1a 100%);
    min-height: 100vh;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #fff;
}

.dashboard-wrapper {
    padding: 32px 28px 45px;
}


.dashboard-header {
    margin-bottom: 32px;
}

.dashboard-title {
    color: #ffffff;
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -0.8px;
    margin-bottom: 6px;
}

.dashboard-subtitle {
    color: #94a3b8;
    font-size: 14px;
    margin: 0;
}

.dashboard-subtitle strong {
    color: #e2e8f0 !important;
}

.system-status {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: #f8fafc;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.18);
    padding: 10px 17px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    backdrop-filter: blur(12px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.18);
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #4ade80;
    box-shadow: 0 0 12px rgba(74, 222, 128, 0.8);
}


.dashboard-section {
    margin-bottom: 30px;
}

.section-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #ffffff;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 14px;
}

.section-heading .heading-icon {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.1);
}



.stat-card {
    position: relative;
    height: 100%;
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 18px;
    overflow: hidden;
    color: #fff;
    background:
        linear-gradient(135deg,
            rgba(255, 255, 255, 0.075),
            rgba(255, 255, 255, 0.035));
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    box-shadow:
        0 12px 30px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.04);
    transition:
        transform 0.25s ease,
        border-color 0.25s ease,
        box-shadow 0.25s ease;
}

.stat-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg,
            rgba(16, 185, 129, 0.8),
            rgba(56, 189, 248, 0.7));
    opacity: 0.65;
}

.stat-card:hover {
    transform: translateY(-4px);
    border-color: rgba(16, 185, 129, 0.35);
    box-shadow:
        0 18px 38px rgba(0, 0, 0, 0.30),
        0 0 20px rgba(16, 185, 129, 0.06);
}

.stat-card .card-body {
    padding: 22px 24px !important;
}

.stat-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.9px;
    color: #94a3b8;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 26px;
    font-weight: 800;
    line-height: 1.2;
    letter-spacing: -0.5px;
    color: #ffffff;
}

.stat-value .transaction-label {
    font-size: 13px;
    font-weight: 500;
    color: #94a3b8 !important;
}

.icon-box {
    flex-shrink: 0;
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 15px;
    font-size: 25px;
    background: rgba(255, 255, 255, 0.07);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
}


.table-box {
    height: 100%;
    background:
        linear-gradient(145deg,
            rgba(15, 23, 42, 0.94),
            rgba(15, 23, 42, 0.78));
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 22px;
    border: 1px solid rgba(255, 255, 255, 0.09);
    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.25),
        inset 0 1px 0 rgba(255, 255, 255, 0.025);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 9px;
    color: #ffffff !important;
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 17px;
}

.table-modern {
    width: 100%;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0 7px;
}

.table-modern thead th {
    background: rgba(255, 255, 255, 0.055) !important;
    color: #38bdf8 !important;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 10px;
    letter-spacing: 1px;
    padding: 12px 15px;
    border: none;
}

.table-modern thead th:first-child {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}

.table-modern thead th:last-child {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}

.table-modern tbody tr {
    background: rgba(255, 255, 255, 0.035) !important;
    transition:
        background 0.2s ease,
        transform 0.2s ease;
}

.table-modern tbody tr:hover {
    background: rgba(255, 255, 255, 0.075) !important;
}

.table-modern tbody td {
    padding: 12px 15px;
    color: #f8fafc !important;
    font-size: 13px;
    border: none;
    vertical-align: middle;
}

.table-modern tbody tr td:first-child {
    border-top-left-radius: 9px;
    border-bottom-left-radius: 9px;
}

.table-modern tbody tr td:last-child {
    border-top-right-radius: 9px;
    border-bottom-right-radius: 9px;
}

.product-title {
    color: #ffffff !important;
    font-weight: 700;
}

.empty-state-text {
    color: #64748b !important;
    font-size: 13px;
}


.badge-custom {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    font-weight: 700;
    padding: 6px 11px;
    font-size: 10px;
    letter-spacing: 0.2px;
    white-space: nowrap;
}

.badge-warning-custom {
    background: rgba(245, 158, 11, 0.12);
    color: #fcd34d !important;
    border: 1px solid rgba(245, 158, 11, 0.28);
}

.badge-danger-custom {
    background: rgba(239, 68, 68, 0.12);
    color: #fca5a5 !important;
    border: 1px solid rgba(239, 68, 68, 0.28);
}

.badge-success-custom {
    background: rgba(16, 185, 129, 0.12);
    color: #6ee7b7 !important;
    border: 1px solid rgba(16, 185, 129, 0.28);
}

.table-box .pagination {
    margin-bottom: 0;
}

.table-box .pagination .page-link {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
}

.table-box .pagination .page-item.active .page-link {
    background: #10b981;
    border-color: #10b981;
    color: #ffffff;
}

.table-box .pagination .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.025);
    color: #475569;
}


@media (max-width: 991px) {

    .dashboard-wrapper {
        padding: 26px 20px 40px;
    }

    .dashboard-title {
        font-size: 26px;
    }

    .stat-value {
        font-size: 23px;
    }

    .table-box {
        padding: 18px;
    }
}

@media (max-width: 576px) {

    .dashboard-wrapper {
        padding: 22px 14px 35px;
    }

    .dashboard-title {
        font-size: 24px;
    }

    .dashboard-subtitle {
        font-size: 13px;
    }

    .system-status {
        font-size: 12px;
        padding: 8px 13px;
    }

    .section-heading {
        font-size: 16px;
    }

    .stat-card .card-body {
        padding: 18px !important;
    }

    .stat-value {
        font-size: 21px;
    }

    .icon-box {
        width: 46px;
        height: 46px;
        font-size: 21px;
    }

    .table-box {
        padding: 15px;
        border-radius: 16px;
    }

    .table-modern {
        min-width: 500px;
    }

    .table-responsive {
        border-radius: 10px;
    }
}
</style>


<div class="container-fluid dashboard-wrapper">


    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

        <div>

            <h1 class="dashboard-title">
                Dashboard POS
            </h1>

            <p class="dashboard-subtitle">
                Ringkasan aktivitas toko hari ini
                &bull;
                <strong class="text-light">
                    {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
                </strong>
            </p>

        </div>

        <div>

            <span class="system-status">
                <span class="status-dot"></span>
                Sistem Aktif & Normal
            </span>

        </div>

    </div>




    @can('viewAny', App\Models\User::class)

    <div class="dashboard-section">

        <h3 class="section-heading">
            <span class="heading-icon">📊</span>
            Penjualan Hari Ini
        </h3>


        <div class="row g-3">

            {{-- TOTAL PENJUALAN --}}
            <div class="col-md-6">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-title">
                                    Total Penjualan
                                </div>

                                <div class="stat-value">
                                    Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                                </div>

                            </div>

                            <div class="icon-box">
                                💰
                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-6">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-title">
                                    Jumlah Transaksi
                                </div>

                                <div class="stat-value">

                                    {{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }}

                                    <span class="transaction-label">
                                        Struk
                                    </span>

                                </div>

                            </div>

                            <div class="icon-box">
                                🧾
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="dashboard-section">

        <h3 class="section-heading">
            <span class="heading-icon">💳</span>
            Status Pembayaran
        </h3>


        <div class="row g-3">


            <div class="col-md-6">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-title">
                                    Pembayaran Tunai (Cash)
                                </div>

                                <div class="stat-value">
                                    Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                                </div>

                            </div>

                            <div class="icon-box">
                                💵
                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <div class="col-md-6">

                <div class="card stat-card">

                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="stat-title">
                                    Pembayaran Non Tunai
                                </div>

                                <div class="stat-value">
                                    Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                                </div>

                            </div>

                            <div class="icon-box">
                                💳
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endcan


    {{-- =====================================================
         STOK RENDAH & STOK HABIS
    ====================================================== --}}

    <div class="row g-4 mb-4">

        {{-- PRODUK STOK RENDAH --}}
        <div class="col-md-6">

            <div class="table-box h-100 d-flex flex-column justify-content-between">

                <div>

                    <h3 class="section-title">
                        ⚠️
                        Produk Stok Rendah
                    </h3>


                    <div class="table-responsive">

                        <table class="table-modern">

                            <thead>

                                <tr>

                                    <th width="15%">
                                        #
                                    </th>

                                    <th>
                                        Nama Produk
                                    </th>

                                    <th width="30%">
                                        Stok
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($produkStokRendah as $index => $produk)

                                <tr>

                                    <td class="fw-bold" style="color: #64748b;">
                                        {{ $produkStokRendah->firstItem() + $index }}
                                    </td>

                                    <td class="product-title">
                                        {{ $produk->nama }}
                                    </td>

                                    <td>

                                        <span class="badge badge-custom badge-warning-custom">
                                            ⚠️ {{ $produk->stok }} Unit
                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="3" class="text-center py-4 empty-state-text">
                                        Stok aman, tidak ada produk menipis
                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                <div class="mt-3">

                    {{ $produkStokRendah->links() }}

                </div>

            </div>

        </div>


        {{-- PRODUK HABIS --}}
        <div class="col-md-6">

            <div class="table-box h-100 d-flex flex-column justify-content-between">

                <div>

                    <h3 class="section-title">
                        ❌
                        Produk Habis Stok
                    </h3>


                    <div class="table-responsive">

                        <table class="table-modern">

                            <thead>

                                <tr>

                                    <th width="15%">
                                        #
                                    </th>

                                    <th>
                                        Nama Produk
                                    </th>

                                    <th width="30%">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($produkStokHabis as $index => $produk)

                                <tr>

                                    <td class="fw-bold" style="color: #64748b;">
                                        {{ $produkStokHabis->firstItem() + $index }}
                                    </td>

                                    <td class="product-title">
                                        {{ $produk->nama }}
                                    </td>

                                    <td>

                                        <span class="badge badge-custom badge-danger-custom">
                                            Habis Total
                                        </span>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="3" class="text-center py-4 empty-state-text">
                                        Tidak ada produk yang habis
                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                <div class="mt-3">

                    {{ $produkStokHabis->links() }}

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         PRODUK TERLARIS
    ====================================================== --}}

    <div class="row">

        <div class="col-12">

            <div class="table-box">

                <h3 class="section-title">
                    🔥
                    Produk Terlaris Bulan Ini
                </h3>


                <div class="table-responsive">

                    <table class="table-modern">

                        <thead>

                            <tr>

                                <th>
                                    Nama Produk
                                </th>

                                <th width="20%">
                                    Stok Tersisa
                                </th>

                                <th width="25%">
                                    Total Terjual
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($produkTerlaris as $produk)

                            <tr>

                                <td class="product-title">
                                    {{ $produk->nama }}
                                </td>

                                <td style="
                                            color: #cbd5e1;
                                            font-weight: 600;
                                        ">
                                    {{ $produk->stok }} Unit
                                </td>

                                <td>

                                    <span class="badge badge-custom badge-success-custom">
                                        🔥 {{ $produk->total_terjual }} Unit Terjual
                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center py-4 empty-state-text">
                                    Belum ada data penjualan produk bulan ini
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection