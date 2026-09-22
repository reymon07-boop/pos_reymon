@extends('layouts.app')

@section('title', 'Remon Thrift House - Katalog Produk')

@section('content')

@include('layouts.navbar')

<style>
:root {
    --bg-main: #090d16;
    --card-bg: rgba(17, 24, 39, 0.78);
    --card-bg-solid: #111827;
    --accent-emerald: #4310b9;
    --accent-emerald-hover: #490596;
    --accent-blue: #38bdf8;
    --accent-yellow: #fbbf24;
    --accent-red: #f87171;
    --border-color: rgba(255, 255, 255, 0.08);
    --border-hover: rgba(45, 97, 10, 0.35);
    --text-muted: #94a3b8;
}

body {
    background:
        radial-gradient(circle at 10% 10%,
            rgba(16, 185, 129, 0.08),
            transparent 28%),
        radial-gradient(circle at 90% 20%,
            rgba(56, 189, 248, 0.05),
            transparent 25%),
        linear-gradient(135deg,
            #07111c 0%,
            #0b1625 48%,
            #071c1a 100%) !important;

    min-height: 100vh;

    font-family:
        'Plus Jakarta Sans',
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        'Segoe UI',
        sans-serif;

    color: #f8fafc !important;
}

.product-page {
    padding-top: 24px;
    padding-bottom: 45px;
}

.header-box {
    position: relative;
    background:
        radial-gradient(circle at top left,
            rgba(16, 185, 129, 0.15),
            transparent 58%),
        linear-gradient(145deg,
            rgba(17, 24, 39, 0.96),
            rgba(15, 23, 42, 0.88));
    border: 1px solid var(--border-color);
    border-radius: 22px;
    padding: 28px 32px;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.30);
    overflow: hidden;
}

.header-box::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background:
        linear-gradient(90deg,
            rgba(16, 185, 129, 0.85),
            rgba(56, 189, 248, 0.60),
            transparent);
}

.brand-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(16, 185, 129, 0.12);
    color: #34aed3;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.7px;
    padding: 6px 13px;
    border-radius: 30px;
    border: 1px solid rgba(16, 185, 129, 0.28);
    margin-bottom: 10px;
}

.page-title {
    color: #ffffff;
    font-size: 27px;
    font-weight: 800;
    letter-spacing: -0.6px;
    margin-bottom: 6px;
}

.page-subtitle {
    color: #94a3b8 !important;
    font-size: 13px;
    margin: 0;
}

.btn-create {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(135deg, #1067b9, #1067b9) !important;
    color: #ffffff !important;
    border: 1px solid rgba(52, 89, 211, 0.35) !important;
    border-radius: 13px;
    font-weight: 700;
    font-size: 13px;
    padding: 11px 18px;
    transition: all 0.25s ease;
    box-shadow: 0 8px 22px rgba(16, 185, 129, 0.20);
    text-decoration: none !important;
}

.btn-create:hover {
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 13px 28px rgba(16, 185, 129, 0.30);
    filter: brightness(1.06);
}

.btn-create .plus-icon {
    width: 22px;
    height: 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    background: rgba(255, 255, 255, 0.13);
    font-size: 16px;
    line-height: 1;
}

.success-alert {
    background: rgba(16, 185, 129, 0.11) !important;
    border: 1px solid rgba(16, 185, 129, 0.23) !important;
    color: #6ee7b7 !important;
    border-radius: 13px;
    padding: 12px 16px;
}

.search-area {
    margin-top: 24px;
    margin-bottom: 24px;
}

.search-container {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 520px;
    min-height: 46px;
    background: rgba(17, 24, 39, 0.90);
    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 13px;
    padding: 5px 6px 5px 14px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.search-container:focus-within {
    background: rgba(17, 24, 39, 0.98);
    border-color: rgba(16, 185, 129, 0.48);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.07);
}

.search-icon {
    color: #64748b;
    font-size: 14px;
    flex-shrink: 0;
}

.search-input {
    flex: 1;
    min-width: 0;
    background: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    color: #ffffff !important;
    font-size: 13px;
    padding: 6px 10px;
}

.search-input::placeholder {
    color: #64748b;
}

.btn-search {
    background: #1037b9 !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 700;
    padding: 9px 16px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-search:hover {
    background: #054496 !important;
    transform: translateY(-1px);
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(255px, 1fr));
    gap: 20px;
}

.product-card {
    position: relative;
    display: flex;
    flex-direction: column;
    background: linear-gradient(145deg, rgba(25, 38, 53, 0.92), rgba(15, 23, 42, 0.94));
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid var(--border-color);
    border-radius: 19px;
    overflow: hidden;
    transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
    min-width: 0;
}

.product-card:hover {
    transform: translateY(-5px);
    border-color: var(--border-hover);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.42), 0 0 22px rgba(16, 185, 129, 0.08);
}

.card-img-box {
    position: relative;
    width: 100%;
    height: 235px;
    background: linear-gradient(145deg, #0b1120, #111827);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-img-box::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    height: 70px;
    background: linear-gradient(to top, rgba(7, 17, 28, 0.55), transparent);
    pointer-events: none;
}

.card-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.45s ease;
}

.product-card:hover .card-img-box img {
    transform: scale(1.045);
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    color: #64748b;
    height: 100%;
}

.no-image-icon {
    font-size: 38px;
    opacity: 0.75;
}

.no-image-text {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-float {
    position: absolute;
    z-index: 3;
    display: inline-flex;
    align-items: center;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    font-weight: 700;
    font-size: 10px;
    padding: 6px 11px;
    border-radius: 30px;
    line-height: 1;
    white-space: nowrap;
}

.stock-badge-normal {
    top: 12px;
    right: 12px;
    background: rgba(15, 23, 42, 0.82);
    color: #38bdf8;
    border: 1px solid rgba(56, 189, 248, 0.30);
}

.stock-badge-low {
    top: 12px;
    right: 12px;
    background: rgba(245, 158, 11, 0.18);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.35);
}

.stock-badge-empty {
    top: 12px;
    right: 12px;
    background: rgba(239, 68, 68, 0.18);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.35);
}

.uploader-badge {
    bottom: 12px;
    left: 12px;
    background: rgba(0, 0, 0, 0.55);
    color: #cbd5e1;
    border: 1px solid rgba(255, 255, 255, 0.13);
}

.card-body-custom {
    padding: 18px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-title {
    font-size: 15px;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 42px;
}

/* Custom CSS untuk info spesifikasi sepatu */
.product-meta {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.meta-pill {
    display: inline-flex;
    align-items: center;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    line-height: 1.2;
}

.meta-pill-size {
    background: rgba(56, 189, 248, 0.12);
    color: #38bdf8;
    border: 1px solid rgba(56, 189, 248, 0.25);
}

.meta-pill-type {
    background: rgba(251, 191, 36, 0.12);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.25);
}

.price-container {
    background: rgba(255, 255, 255, 0.035);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 13px;
    padding: 10px 13px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 17px;
}

.price-item {
    min-width: 0;
    width: 100%;
}

.price-label {
    display: block;
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-muted);
    font-weight: 700;
    margin-bottom: 2px;
}

.price-val-sell {
    font-size: 15px;
    font-weight: 800;
    color: #343ed3;
    white-space: nowrap;
}

.action-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 7px;
    margin-top: auto;
}

.action-grid form {
    margin: 0;
    width: 100%;
}

.btn-act {
    width: 100%;
    min-height: 36px;
    border: none !important;
    font-size: 10px;
    font-weight: 700;
    padding: 8px 4px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    transition: all 0.2s ease;
    text-decoration: none !important;
    cursor: pointer;
}

.btn-act:hover {
    transform: translateY(-1px);
}

.btn-act-view {
    background: rgba(99, 102, 241, 0.13) !important;
    color: #818cf8 !important;
    border: 1px solid rgba(99, 102, 241, 0.18) !important;
}

.btn-act-view:hover {
    background: #6366f1 !important;
    color: #ffffff !important;
}

.btn-act-edit {
    background: rgba(245, 158, 11, 0.13) !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(245, 158, 11, 0.18) !important;
}

.btn-act-edit:hover {
    background: #f59e0b !important;
    color: #ffffff !important;
}

.btn-act-delete {
    background: rgba(239, 68, 68, 0.13) !important;
    color: #f87171 !important;
    border: 1px solid rgba(239, 68, 68, 0.18) !important;
}

.btn-act-delete:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
}

.empty-products {
    grid-column: 1 / -1;
    text-align: center;
    background: rgba(17, 24, 39, 0.75);
    border: 1px dashed rgba(255, 255, 255, 0.12);
    border-radius: 19px;
    padding: 55px 20px;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 10px;
    opacity: 0.85;
}

.empty-title {
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 5px;
}

.empty-text {
    color: #64748b;
    font-size: 12px;
    margin: 0;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    background: rgba(255, 255, 255, 0.045);
    border-color: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
}

.pagination .page-link:hover {
    background: rgba(16, 185, 129, 0.12);
    color: #6ee7b7;
    border-color: rgba(16, 185, 129, 0.25);
}

.pagination .page-item.active .page-link {
    background: #1021b9;
    border-color: #101bb9;
    color: #ffffff;
}

@media (max-width: 768px) {
    .product-page {
        padding-top: 18px;
        padding-bottom: 35px;
    }

    .header-box {
        padding: 22px;
        border-radius: 18px;
    }

    .page-title {
        font-size: 23px;
    }

    .btn-create {
        width: 100%;
    }

    .search-container {
        max-width: 100%;
    }

    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
    }
}

@media (max-width: 500px) {
    .container-fluid.product-page {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    .header-box {
        padding: 19px;
        border-radius: 16px;
    }

    .brand-pill {
        font-size: 9px;
    }

    .page-title {
        font-size: 21px;
    }

    .page-subtitle {
        font-size: 11px;
    }

    .search-container {
        padding-left: 11px;
    }

    .search-input {
        font-size: 12px;
    }

    .btn-search {
        padding: 8px 11px;
        font-size: 10px;
    }

    .product-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .card-img-box {
        height: 245px;
    }

    .card-body-custom {
        padding: 16px;
    }

    .product-title {
        font-size: 14px;
    }

    .price-container {
        padding: 10px 11px;
    }

    .price-val-sell {
        font-size: 14px;
    }

    .btn-act {
        font-size: 10px;
        min-height: 35px;
    }
}
</style>

<div class="container-fluid product-page px-md-4">


    <div class="header-box d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="brand-pill">👕 REMON THRIFT HOUSE</span>
            <h2 class="page-title">Katalog Produk</h2>
            <p class="page-subtitle">Kelola stok dan daftar harga koleksi thrift secara real-time.</p>
        </div>

        <div>
            <a href="{{ route('produk.create') }}" class="btn btn-create">
                <span class="plus-icon">+</span> Tambah Produk Baru
            </a>
        </div>
    </div>


    @if(session('success'))
    <div class="alert success-alert border-0 fade show mb-4 d-flex align-items-center gap-2" role="alert">
        <span>✓</span>
        <div>{{ session('success') }}</div>
    </div>
    @endif


    <div class="search-area">
        <form action="{{ route('produk.index') }}" method="GET">
            <div class="search-container">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control search-input"
                    placeholder="Cari nama produk thrift...">
                <button type="submit" class="btn btn-search">Cari</button>
            </div>
        </form>
    </div>


    <div class="product-grid">

        @forelse($produk as $item)

        @php
        $stok = $item->stok ?? $item->stock ?? 0;
        $namaProduk = $item->nama_produk ?? $item->nama ?? 'NAMA PRODUK';
        $hargaJual = $item->harga_jual ?? $item->harga ?? 0;
        $ukuran = $item->ukuran ?? $item->size ?? '40'; // Default jika kolom DB belum ada
        $jenis = $item->jenis ?? $item->kategori ?? 'Impor'; // Default jika kolom DB belum ada
        @endphp

        <div class="product-card">

            {{-- IMAGE --}}
            <div class="card-img-box">
                @if($item->foto)
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $namaProduk }}" loading="lazy" onerror="
                                this.onerror=null;
                                this.style.display='none';
                                this.nextElementSibling.style.display='flex';
                            ">
                <div class="no-image" style="display: none;">
                    <div class="no-image-icon">👕</div>
                    <div class="no-image-text">Foto tidak tersedia</div>
                </div>
                @else
                <div class="no-image">
                    <div class="no-image-icon">👕</div>
                    <div class="no-image-text">Tanpa Foto</div>
                </div>
                @endif

                {{-- STOCK BADGE --}}
                @if($stok == 0)
                <span class="badge-float stock-badge-empty">✕ Habis</span>
                @elseif($stok <= 3) <span class="badge-float stock-badge-low">⚠ Sisa {{ $stok }}</span>
                    @else
                    <span class="badge-float stock-badge-normal">✓ Stok {{ $stok }}</span>
                    @endif

                    {{-- UPLOADER --}}
                    <span class="badge-float uploader-badge">
                        👤 {{ optional($item->user)->name ?? 'Admin' }}
                    </span>
            </div>


            <div class="card-body-custom">

                {{-- PRODUCT NAME --}}
                <h3 class="product-title" title="{{ $namaProduk }}">
                    {{ $namaProduk }}
                </h3>


                <div class="product-meta">
                    <span class="meta-pill meta-pill-size">
                        📏 Size: {{ $ukuran }}
                    </span>
                    <span class="meta-pill meta-pill-type">
                        🏷️ {{ $jenis }}
                    </span>
                </div>


                <div class="price-container">
                    <div class="price-item">
                        <span class="price-label">Harga Jual</span>
                        <div class="price-val-sell">
                            Rp {{ number_format($hargaJual, 0, ',', '.') }}
                        </div>
                    </div>
                </div>


                <div class="action-grid">
                    <a href="{{ route('produk.show', $item) }}" class="btn-act btn-act-view"
                        title="Lihat Detail Produk">
                        👁️ Detail
                    </a>

                    <a href="{{ route('produk.edit', $item) }}" class="btn-act btn-act-edit" title="Edit Produk">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('produk.destroy', $item) }}" method="POST" class="d-inline m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-act btn-act-delete"
                            onclick="return confirm('Yakin ingin menghapus produk ini?')" title="Hapus Produk">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>

            </div>

        </div>

        @empty


        <div class="empty-products">
            <div class="empty-icon">🛍️</div>
            <h5 class="empty-title">Belum Ada Koleksi Produk</h5>
            <p class="empty-text">
                Klik "+ Tambah Produk Baru" untuk menambahkan koleksi thrift baru.
            </p>
        </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if(method_exists($produk, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $produk->links() }}
    </div>
    @endif

</div>

@endsection