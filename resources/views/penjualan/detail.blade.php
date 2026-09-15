@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')

@include('layouts.navbar')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="sales-dashboard-container">

    <div class="container py-3">

        {{-- HEADER --}}
        <div class="page-header">

            <div class="page-header-text">

                <div class="title-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>

                <div>
                    <h1 class="page-title">
                        Detail Penjualan
                    </h1>

                    <p class="page-subtitle">
                        Rincian informasi transaksi dan item produk yang dibeli.
                    </p>
                </div>

            </div>

            <div class="header-actions">

                {{-- Kembali --}}
                <a href="{{ route('penjualan.index') }}" class="btn-action-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>

                {{-- Cetak Struk --}}
                <button type="button" onclick="window.print()" class="btn-action-print">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Struk</span>
                </button>

                {{-- Hapus --}}
                <form action="{{ route('penjualan.destroy', $sale) }}"
                      method="POST"
                      class="m-0"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Data yang dihapus tidak dapat dikembalikan.')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-action-delete">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Hapus</span>
                    </button>

                </form>

            </div>

        </div>


        {{-- INFORMASI TRANSAKSI --}}
        <div class="transaction-card">

            {{-- Kasir --}}
            <div class="info-group">

                <span class="info-label">
                    Kasir
                </span>

                <span class="info-value">

                    <span class="info-icon">
                        <i class="fa-solid fa-user-tie"></i>
                    </span>

                    {{ optional($sale->user)->name ?? 'Kasir Umum' }}

                </span>

            </div>


            {{-- Tanggal --}}
            <div class="info-group">

                <span class="info-label">
                    Tanggal Transaksi
                </span>

                <span class="info-value">

                    <span class="info-icon">
                        <i class="fa-regular fa-calendar-days"></i>
                    </span>

                    {{ $sale->created_at ? $sale->created_at->translatedFormat('d M Y, H:i') : '-' }}

                </span>

            </div>


            {{-- Metode Pembayaran --}}
            <div class="info-group">

                <span class="info-label">
                    Metode Pembayaran
                </span>

                <div>

                    <span class="badge-custom badge-indigo">

                        <i class="fa-solid fa-wallet"></i>

                        {{ strtoupper($sale->metode_pembayaran ?? 'CASH') }}

                    </span>

                </div>

            </div>


            {{-- Status --}}
            <div class="info-group">

                <span class="info-label">
                    Status
                </span>

                <div>

                    @if(strtoupper($sale->status ?? '') === 'OPEN')

                        <span class="badge-custom badge-warning">
                            <span class="status-dot"></span>
                            OPEN
                        </span>

                    @else

                        <span class="badge-custom badge-success">
                            <span class="status-dot"></span>
                            COMPLETED
                        </span>

                    @endif

                </div>

            </div>


            {{-- Total --}}
            <div class="total-group">

                <div>

                    <span class="info-label">
                        Total Pembayaran
                    </span>

                    <div class="total-caption">
                        Total transaksi
                    </div>

                </div>

                <span class="total-price">
                    Rp {{ number_format($sale->total_pembayaran ?? 0, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- TABEL DETAIL PRODUK --}}
        <div class="white-table-card">

            <div class="table-heading">

                <div class="table-heading-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>

                <div>

                    <h5>
                        Detail Produk
                    </h5>

                    <p>
                        Daftar produk yang terdapat dalam transaksi ini.
                    </p>

                </div>

            </div>


            <div class="table-responsive">

                <table class="custom-white-table">

                    <colgroup>
                        <col style="width: 10%;">
                        <col style="width: 15%;">
                        <col style="width: 50%;">
                        <col style="width: 25%;">
                    </colgroup>


                    <thead>

                        <tr>

                            <th class="header-no">
                                NO
                            </th>

                            <th class="header-photo">
                                FOTO
                            </th>

                            <th class="header-name">
                                NAMA PRODUK
                            </th>

                            <th class="header-price">
                                HARGA
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($sale->itempenjualan as $item)

                            <tr>

                                {{-- NO --}}
                                <td class="cell-no">

                                    <span class="row-number">
                                        {{ $loop->iteration }}
                                    </span>

                                </td>


                                {{-- FOTO --}}
                                <td class="cell-photo">

                                    @if(isset($item->produk) && $item->produk->foto)

                                        <div class="product-image-wrapper">

                                            <img src="{{ asset('storage/' . $item->produk->foto) }}"
                                                 alt="{{ $item->produk->nama }}"
                                                 class="product-img">

                                        </div>

                                    @elseif(isset($item->foto) && $item->foto)

                                        <div class="product-image-wrapper">

                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                 alt="Foto Produk"
                                                 class="product-img">

                                        </div>

                                    @else

                                        <div class="no-img-placeholder">

                                            <i class="fa-solid fa-image"></i>

                                            <span>No Image</span>

                                        </div>

                                    @endif

                                </td>


                                {{-- NAMA PRODUK --}}
                                <td class="cell-name">

                                    <span class="product-name">
                                        {{ $item->produk->nama ?? $item->nama_produk ?? $item->nama ?? 'ADIDAS BALI' }}
                                    </span>

                                </td>


                                {{-- HARGA --}}
                                <td class="cell-price">

                                    <span class="product-price">

                                        Rp {{ number_format(
                                            $item->harga
                                            ?? $item->produk->harga_jual
                                            ?? $item->subtotal
                                            ?? 0,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="empty-cell">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            <i class="fa-solid fa-box-open"></i>
                                        </div>

                                        <h6>
                                            Tidak ada detail produk
                                        </h6>

                                        <p>
                                            Transaksi ini belum memiliki item produk terdaftar.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- AREA STRUK (KHUSUS PRINT THERMAL 80MM) --}}
<div id="thermal-receipt-area">

    <div class="receipt-header">
        <h2>TOKO ANDA</h2>
        <p>Jl. Contoh Alamat Store No. 123</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="receipt-divider">--------------------------------</div>

    <table class="receipt-meta">
        <tr>
            <td>No. Transaksi</td>
            <td class="text-right">#{{ $sale->id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ $sale->created_at ? $sale->created_at->format('d/m/Y H:i') : '-' }}</td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td class="text-right">{{ optional($sale->user)->name ?? 'Kasir' }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="text-right">{{ strtoupper($sale->metode_pembayaran ?? 'CASH') }}</td>
        </tr>
    </table>

    <div class="receipt-divider">--------------------------------</div>

    <table class="receipt-items">
        @foreach($sale->itempenjualan as $item)
            <tr>
                <td colspan="2" class="item-name">
                    {{ $item->produk->nama ?? $item->nama_produk ?? $item->nama ?? 'Produk' }}
                </td>
            </tr>
            <tr>
                <td>1 x Rp {{ number_format($item->harga ?? $item->produk->harga_jual ?? $item->subtotal ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal ?? $item->harga ?? $item->produk->harga_jual ?? 0, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="receipt-divider">--------------------------------</div>

    <table class="receipt-total">
        <tr>
            <td><strong>TOTAL</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($sale->total_pembayaran ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="receipt-divider">--------------------------------</div>

    <div class="receipt-footer">
        <p>-- TERIMA KASIH --</p>
        <p>Barang yang sudah dibeli</p>
        <p>tidak dapat ditukar/dikembalikan</p>
    </div>

</div>


<style>

/* Area Struk Thermal HIDE by default di web screen */
#thermal-receipt-area {
    display: none;
}

/* =========================================================
   BACKGROUND
========================================================= */

.sales-dashboard-container {
    position: relative;
    min-height: 100vh;
    padding: 24px 0 50px;
    color: #e2e8f0;
    background:
        radial-gradient(
            circle at 10% 20%,
            rgba(0, 190, 140, .12),
            transparent 40%
        ),
        radial-gradient(
            circle at 90% 80%,
            rgba(59, 130, 246, .10),
            transparent 40%
        ),
        linear-gradient(
            135deg,
            #020807 0%,
            #03120f 50%,
            #020609 100%
        );
}


/* =========================================================
   HEADER
========================================================= */

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.page-header-text {
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 14px;
}

.title-icon {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00d99a;
    background: rgba(0,217,154,.12);
    border: 1px solid rgba(0,217,154,.22);
    border-radius: 13px;
    box-shadow: 0 8px 25px rgba(0,217,154,.10);
}

.title-icon i {
    font-size: 20px;
}

.page-title {
    margin: 0 0 5px;
    color: #ffffff;
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -.5px;
}

.page-subtitle {
    margin: 0;
    color: #81918f;
    font-size: 14px;
}


/* =========================================================
   HEADER BUTTONS
========================================================= */

.header-actions {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-shrink: 0;
}

.btn-action-back,
.btn-action-print,
.btn-action-delete {
    min-height: 42px;
    padding: 10px 17px;
    border-radius: 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition:
        transform .2s ease,
        background .2s ease,
        box-shadow .2s ease;
}

.btn-action-back {
    color: #e2e8f0;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
}

.btn-action-back:hover {
    color: #ffffff;
    background: rgba(255,255,255,.14);
    transform: translateY(-1px);
}

.btn-action-print {
    color: #00d99a;
    background: rgba(0,217,154,.12);
    border: 1px solid rgba(0,217,154,.25);
    cursor: pointer;
}

.btn-action-print:hover {
    color: #ffffff;
    background: #00d99a;
    box-shadow: 0 5px 18px rgba(0,217,154,.30);
    transform: translateY(-1px);
}

.btn-action-delete {
    color: #fb7185;
    background: rgba(225,29,72,.13);
    border: 1px solid rgba(225,29,72,.30);
    cursor: pointer;
}

.btn-action-delete:hover {
    color: #ffffff;
    background: #e11d48;
    box-shadow: 0 5px 18px rgba(225,29,72,.30);
    transform: translateY(-1px);
}


/* =========================================================
   TRANSACTION CARD
========================================================= */

.transaction-card {
    width: 100%;
    margin-bottom: 20px;
    padding: 22px 24px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    background:
        linear-gradient(
            145deg,
            rgba(10,25,30,.82),
            rgba(7,20,24,.72)
        );
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    backdrop-filter: blur(16px);
    box-shadow: 0 18px 45px rgba(0,0,0,.32);
}

.info-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
    min-width: 0;
}

.info-label {
    color: #64748b;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
}

.info-value {
    display: flex;
    align-items: center;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    min-width: 0;
}

.info-icon {
    width: 30px;
    height: 30px;
    margin-right: 8px;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #00d99a;
    background: rgba(0,217,154,.09);
    border-radius: 8px;
}

.info-icon i {
    font-size: 12px;
}


/* =========================================================
   BADGES
========================================================= */

.badge-custom {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .4px;
}

.badge-indigo {
    color: #818cf8;
    background: rgba(99,102,241,.15);
    border: 1px solid rgba(99,102,241,.25);
}

.badge-warning {
    color: #fbbf24;
    background: rgba(245,158,11,.15);
    border: 1px solid rgba(245,158,11,.25);
}

.badge-success {
    color: #34d399;
    background: rgba(16,185,129,.15);
    border: 1px solid rgba(16,185,129,.25);
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}


/* =========================================================
   TOTAL
========================================================= */

.total-group {
    grid-column: 1 / -1;
    padding-top: 17px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px dashed rgba(255,255,255,.10);
}

.total-caption {
    margin-top: 3px;
    color: #64748b;
    font-size: 11px;
}

.total-price {
    color: #00d99a;
    font-size: 22px;
    font-weight: 800;
    text-shadow: 0 0 12px rgba(0,217,154,.22);
}


/* =========================================================
   WHITE TABLE CARD
========================================================= */

.white-table-card {
    width: 100%;
    padding: 12px;
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 12px 35px rgba(0,0,0,.22);
}


/* =========================================================
   TABLE HEADING
========================================================= */

.table-heading {
    min-height: 70px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #ffffff;
}

.table-heading-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #059669;
    background: #ecfdf5;
    border: 1px solid #d1fae5;
    border-radius: 10px;
}

.table-heading-icon i {
    font-size: 16px;
}

.table-heading h5 {
    margin: 0 0 3px;
    color: #0f172a;
    font-size: 15px;
    font-weight: 800;
}

.table-heading p {
    margin: 0;
    color: #64748b;
    font-size: 12px;
}


/* =========================================================
   TABLE
========================================================= */

.custom-white-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
}


/* =========================================================
   TABLE HEADER
========================================================= */

.custom-white-table thead th {
    height: 58px;
    padding: 0 18px;
    background: #10182d;
    color: #ffffff;
    border: none;
    vertical-align: middle;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .5px;
}

.header-no {
    text-align: center;
    border-radius: 9px 0 0 9px;
}

.header-photo {
    text-align: center;
}

.header-name {
    text-align: center;
}

.header-price {
    text-align: right;
    border-radius: 0 9px 9px 0;
}


/* =========================================================
   TABLE BODY
========================================================= */

.custom-white-table tbody tr {
    height: 125px;
    transition: background .2s ease;
}

.custom-white-table tbody td {
    height: 125px;
    padding: 14px 18px;
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.custom-white-table tbody tr:hover td {
    background: #f8fafc;
}

.custom-white-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   NOMOR
========================================================= */

.cell-no {
    text-align: center;
}

.row-number {
    width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: #0f172a;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    font-size: 14px;
    font-weight: 800;
}


/* =========================================================
   FOTO
========================================================= */

.cell-photo {
    text-align: center;
}

.product-image-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.product-img {
    width: 82px !important;
    height: 82px !important;
    display: block;
    margin: 0 auto;
    object-fit: cover;
    border-radius: 13px;
    border: 1px solid #dfe5eb;
    background: #f1f5f9;
    box-shadow: 0 5px 14px rgba(0,0,0,.09);
    transition:
        transform .2s ease,
        box-shadow .2s ease;
}

.product-img:hover {
    transform: scale(1.04);
    box-shadow: 0 8px 20px rgba(0,0,0,.14);
}


/* =========================================================
   NO IMAGE
========================================================= */

.no-img-placeholder {
    width: 82px;
    height: 82px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    color: #64748b;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 13px;
    font-size: 10px;
}

.no-img-placeholder i {
    color: #94a3b8;
    font-size: 21px;
}


/* =========================================================
   NAMA PRODUK
========================================================= */

.cell-name {
    text-align: center;
    padding-left: 18px !important;
    padding-right: 18px !important;
}

.product-name {
    display: block;
    color: #0f172a !important;
    font-size: 16px;
    font-weight: 800;
    line-height: 1.35;
    text-align: center;
    white-space: normal;
    word-break: break-word;
}


/* =========================================================
   HARGA
========================================================= */

.cell-price {
    text-align: right;
    padding-right: 22px !important;
}

.product-price {
    display: inline-block;
    color: #059669 !important;
    font-size: 16px;
    font-weight: 800;
    white-space: nowrap;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-cell {
    height: 210px !important;
    text-align: center;
}

.empty-state {
    padding: 40px 15px;
    text-align: center;
}

.empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 15px;
    font-size: 25px;
}

.empty-state h6 {
    margin: 0 0 5px;
    color: #0f172a;
    font-size: 15px;
    font-weight: 800;
}

.empty-state p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}


/* =========================================================
   RESPONSIVE LAYOUT
========================================================= */

@media (max-width: 900px) {
    .transaction-card {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .sales-dashboard-container {
        padding: 18px 0 35px;
    }
    .page-header {
        align-items: flex-start;
        flex-direction: column;
    }
    .page-header-text {
        width: 100%;
    }
    .header-actions {
        width: 100%;
    }
    .btn-action-back,
    .btn-action-print,
    .btn-action-delete {
        flex: 1;
    }
    .page-title {
        font-size: 22px;
    }
    .page-subtitle {
        font-size: 13px;
    }
    .transaction-card {
        grid-template-columns: repeat(2, 1fr);
        padding: 18px;
        gap: 18px;
    }
    .total-group {
        align-items: flex-start;
        flex-direction: column;
        gap: 8px;
    }
    .white-table-card {
        padding: 7px;
        border-radius: 14px;
    }
    .table-heading {
        padding: 12px 10px;
    }
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .custom-white-table {
        min-width: 700px;
    }
    .custom-white-table thead th {
        height: 58px;
        padding: 0 14px;
        font-size: 12px;
    }
    .custom-white-table tbody td {
        height: 105px;
        padding: 12px 14px;
    }
    .product-img,
    .no-img-placeholder {
        width: 70px !important;
        height: 70px !important;
    }
    .product-name {
        font-size: 14px;
    }
    .product-price {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .page-header-text {
        align-items: flex-start;
    }
    .title-icon {
        width: 42px;
        height: 42px;
    }
    .title-icon i {
        font-size: 17px;
    }
    .transaction-card {
        grid-template-columns: 1fr;
    }
    .total-group {
        grid-column: auto;
    }
    .header-actions {
        gap: 7px;
    }
    .btn-action-back,
    .btn-action-print,
    .btn-action-delete {
        padding: 9px 12px;
        font-size: 12px;
    }
    .table-heading p {
        display: none;
    }
}


/* =========================================================
   PRINT MEDIA STYLES (PRINTER THERMAL)
========================================================= */

@media print {
    body * {
        visibility: hidden;
    }

    #thermal-receipt-area, #thermal-receipt-area * {
        visibility: visible;
    }

    #thermal-receipt-area {
        display: block !important;
        position: absolute;
        left: 0;
        top: 0;
        width: 80mm;
        padding: 10px;
        font-family: 'Courier New', Courier, monospace;
        font-size: 11px;
        color: #000000;
        background: #ffffff;
    }

    #thermal-receipt-area .receipt-header {
        text-align: center;
        margin-bottom: 5px;
    }

    #thermal-receipt-area .receipt-header h2 {
        font-size: 14px;
        font-weight: bold;
        margin: 0;
    }

    #thermal-receipt-area .receipt-header p {
        margin: 0;
        font-size: 10px;
    }

    #thermal-receipt-area .receipt-divider {
        text-align: center;
        margin: 4px 0;
        font-size: 10px;
    }

    #thermal-receipt-area table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    #thermal-receipt-area td {
        padding: 2px 0;
        vertical-align: top;
    }

    #thermal-receipt-area .text-right {
        text-align: right;
    }

    #thermal-receipt-area .item-name {
        font-weight: bold;
    }

    #thermal-receipt-area .receipt-footer {
        text-align: center;
        margin-top: 8px;
        font-size: 10px;
    }

    #thermal-receipt-area .receipt-footer p {
        margin: 0;
    }
}

</style>

@endsection