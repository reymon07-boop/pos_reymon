@extends('layouts.app')

@section('title', 'POS')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="pos-container py-3">
    <div class="container-fluid">

        @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-3" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            {{ session('errors') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif

        {{-- HEADER PAGE --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold m-0 text-dark">
                    Kasir / POS
                </h4>

                <small class="text-muted">
                    Kelola transaksi dan keranjang belanja secara real-time.
                </small>
            </div>

            @if($sale->status === 'COMPLETED')
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fs-6 fw-semibold">
                <i class="fa-solid fa-circle-check me-1"></i>
                Transaksi Selesai
            </span>
            @endif
        </div>

        <div class="row g-4">

            {{-- KATALOG PRODUK --}}
            <div class="col-lg-6">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3 border-0">

                        <div class="position-relative">

                            <form method="GET" action="{{ route('penjualan.create') }}" id="searchForm">

                                <i class="fa-solid fa-magnifying-glass search-icon"></i>

                                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                    class="form-control form-control-custom ps-5" placeholder="Cari nama produk..."
                                    autocomplete="off">

                            </form>

                        </div>

                    </div>

                    <div class="card-body p-3 product-scroll-area">

                        @forelse ($products as $product)

                        <form method="POST" action="{{ route('itempenjualan.store') }}" class="mb-2">

                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div
                                class="product-item-card p-2 rounded-3 border d-flex align-items-center justify-content-between gap-2">

                                {{-- INFO PRODUK --}}
                                <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">

                                    <div class="product-img-box flex-shrink-0">

                                        @if($product->foto)

                                        <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                            class="rounded-3 product-thumb">

                                        @else

                                        <div class="no-img-thumb rounded-3">
                                            <i class="fa-solid fa-box text-secondary"></i>
                                        </div>

                                        @endif

                                    </div>

                                    <div class="text-truncate">

                                        <h6 class="fw-semibold mb-1 text-dark text-truncate">
                                            {{ $product->nama }}
                                        </h6>

                                        <span class="text-purple fw-bold small">
                                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                                {{-- QTY DAN TAMBAH --}}
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">

                                    <input type="number" name="quantity" value="1" min="1"
                                        class="form-control text-center input-qty-catalog"
                                        {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                    <button type="submit" class="btn btn-purple"
                                        {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>

                                        <i class="fa-solid fa-plus"></i>

                                    </button>

                                </div>

                            </div>

                        </form>

                        @empty

                        <div class="text-center py-5 text-muted">

                            <i class="fa-solid fa-box-open fa-2x mb-2"></i>

                            <p class="mb-0">
                                Produk tidak ditemukan.
                            </p>

                        </div>

                        @endforelse

                    </div>

                </div>

            </div>

            {{-- KERANJANG --}}
            <div class="col-lg-6">

                <div class="card card-custom border-0 shadow-sm h-100 d-flex flex-column">

                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">

                        <i class="fa-solid fa-cart-shopping text-purple fs-5"></i>

                        <h6 class="fw-bold mb-0">
                            Keranjang Belanja
                        </h6>

                    </div>

                    <div class="card-body p-0 flex-grow-1 overflow-auto">

                        <table class="table table-hover align-middle custom-table mb-0">

                            <thead>

                                <tr>

                                    <th>Produk</th>

                                    <th>Harga</th>

                                    <th class="text-center" style="width: 100px;">
                                        Qty
                                    </th>

                                    <th class="text-end">
                                        Subtotal
                                    </th>

                                    <th class="text-center" style="width: 50px;">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($sale->itempenjualan as $item)

                                <tr>

                                    {{-- PRODUK --}}
                                    <td>

                                        <span class="fw-semibold text-dark">
                                            {{ $item->produk->nama }}
                                        </span>

                                    </td>

                                    {{-- HARGA --}}
                                    <td class="text-muted small">

                                        Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}

                                    </td>

                                    {{-- QTY --}}
                                    <td>

                                        <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">

                                            @csrf
                                            @method('PUT')

                                            <input type="number" name="quantity" value="{{ $item->kuantitas }}" min="1"
                                                class="form-control form-control-sm text-center input-qty-cart mx-auto"
                                                onchange="this.form.submit()"
                                                {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                        </form>

                                    </td>

                                    {{-- SUBTOTAL --}}
                                    <td class="text-end fw-bold text-dark">

                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                                    </td>

                                    {{-- HAPUS --}}
                                    <td class="text-center">

                                        @can('delete', $item)

                                        <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger btn-sm border-0 rounded-circle"
                                                title="Hapus">

                                                <i class="fa-solid fa-trash-can"></i>

                                            </button>

                                        </form>

                                        @endcan

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5 text-muted">

                                        <i class="fa-solid fa-basket-shopping fa-2x mb-2 text-secondary opacity-50"></i>

                                        <p class="mb-0">
                                            Keranjang masih kosong
                                        </p>

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- RINGKASAN CHECKOUT --}}
                    <div class="card-footer bg-light p-3 border-top">

                        {{-- TOTAL --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="fs-6 text-muted fw-semibold">
                                Total Pembayaran
                            </span>

                            <span class="fs-4 fw-bold text-purple">
                                Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                            </span>

                        </div>

                        {{-- FORM CHECKOUT --}}
                        <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" id="checkoutForm">

                            @csrf
                            @method('PUT')

                            <input type="hidden" id="totalPembayaran" value="{{ $sale->total_pembayaran }}">

                            {{-- METODE PEMBAYARAN --}}
                            <div class="mb-3">

                                <label class="form-label small fw-semibold text-muted">
                                    Metode Pembayaran
                                </label>

                                <select name="payment_method" id="paymentMethod" class="form-select form-select-custom"
                                    required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>

                                    <option value="">
                                        -- Pilih Pembayaran --
                                    </option>

                                    <option value="CASH" {{ $sale->metode_pembayaran === 'CASH' ? 'selected' : '' }}>
                                        CASH (Tunai)
                                    </option>

                                    <option value="QRIS" {{ $sale->metode_pembayaran === 'QRIS' ? 'selected' : '' }}>
                                        QRIS
                                    </option>

                                </select>

                            </div>

                            {{-- UANG BAYAR CASH --}}
                            <div id="cashCalculationArea" class="mb-3 p-3 bg-white rounded-3 border"
                                style="display: none;">

                                <div class="mb-2">

                                    <label class="form-label small fw-semibold text-dark">
                                        Uang Bayar (Rp)
                                    </label>

                                    <input type="number" name="bayar" id="inputBayar"
                                        class="form-control form-control-custom" placeholder="Masukkan jumlah uang..."
                                        {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">

                                    <span class="small fw-semibold text-muted">
                                        Kembalian:
                                    </span>

                                    <span id="textKembalian" class="fw-bold fs-5 text-dark">
                                        Rp 0
                                    </span>

                                </div>

                            </div>

                            {{-- QRIS --}}
                            <div id="qrisArea" class="qris-box mb-3" style="display: none;">

                                <div class="text-center">

                                    <div class="fw-semibold text-dark mb-3">
                                        Pindai Kode QRIS untuk Pembayaran
                                    </div>

                                    {{-- FILE QRIS ADA DI public/images2/qris.jpg --}}
                                    <img src="{{ asset('images2/qris.jpg') }}" alt="QRIS Code" class="qris-image">

                                </div>

                            </div>

                            {{-- CHECKOUT --}}
                            <button type="submit" id="btnCheckout"
                                class="btn btn-purple w-100 py-2 fw-bold text-uppercase"
                                {{ $sale->status === 'COMPLETED' || $sale->itempenjualan->isEmpty() ? 'disabled' : '' }}>

                                <i class="fa-solid fa-cash-register me-1"></i>
                                Checkout

                            </button>

                        </form>

                        {{-- BATALKAN TRANSAKSI --}}
                        @can('delete', $sale)

                        @if($sale->status !== 'COMPLETED')

                        <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}"
                            onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-link text-danger w-100 mt-2 text-decoration-none small">

                                <i class="fa-solid fa-xmark me-1"></i>
                                Batalkan Transaksi

                            </button>

                        </form>

                        @endif

                        @endcan

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<style>
:root {
    --purple-primary: #300596;
    --purple-hover: #22036c;
}

.text-purple {
    color: var(--purple-primary) !important;
}

.btn-purple {
    background-color: var(--purple-primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-purple:hover {
    background-color: var(--purple-hover);
    color: #fff;
}

.card-custom {
    border-radius: 12px;
    overflow: hidden;
}

.product-scroll-area {
    max-height: 65vh;
    overflow-y: auto;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.form-control-custom,
.form-select-custom {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
}

.form-control-custom:focus,
.form-select-custom:focus {
    border-color: var(--purple-primary);
    box-shadow: 0 0 0 3px rgba(48, 5, 150, 0.15);
}

.product-item-card {
    background-color: #fff;
    transition: background-color 0.2s ease;
}

.product-item-card:hover {
    background-color: #f8fafc;
}

.product-thumb,
.no-img-thumb {
    width: 45px;
    height: 45px;
    object-fit: cover;
}

.no-img-thumb {
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.input-qty-catalog {
    width: 65px !important;
    border-radius: 6px;
    padding: 5px;
}

.input-qty-cart {
    width: 60px !important;
    border-radius: 6px;
    padding: 4px;
}

.custom-table thead th {
    background-color: var(--purple-primary);
    color: #ffffff;
    font-weight: 600;
    border: none;
    padding: 12px;
}

.custom-table tbody td {
    padding: 12px;
    border-color: #f1f5f9;
}

/* QRIS */
.qris-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 18px;
}

.qris-image {
    width: 230px;
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // =====================================================
    // AUTO SEARCH
    // =====================================================

    const searchInput =
        document.getElementById('searchInput');

    const searchForm =
        document.getElementById('searchForm');

    let searchTimeout = null;

    if (searchInput) {

        searchInput.focus();

        const val =
            searchInput.value;

        searchInput.value = '';

        searchInput.value = val;

        searchInput.addEventListener(
            'input',
            function() {

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(
                    function() {

                        searchForm.submit();

                    },
                    500
                );

            }
        );

    }


    // =====================================================
    // PEMBAYARAN
    // =====================================================

    const paymentMethodSelect =
        document.getElementById('paymentMethod');

    const cashCalculationArea =
        document.getElementById('cashCalculationArea');

    const qrisArea =
        document.getElementById('qrisArea');

    const inputBayar =
        document.getElementById('inputBayar');

    const textKembalian =
        document.getElementById('textKembalian');

    const totalPembayaran =
        parseFloat(
            document.getElementById('totalPembayaran').value
        ) || 0;

    const checkoutForm =
        document.getElementById('checkoutForm');


    // =====================================================
    // CEK METODE PEMBAYARAN
    // =====================================================

    function checkPaymentMethod() {

        if (
            paymentMethodSelect.value === 'CASH'
        ) {

            // Tampilkan CASH
            cashCalculationArea.style.display =
                'block';

            // Sembunyikan QRIS
            qrisArea.style.display =
                'none';

            inputBayar.setAttribute(
                'required',
                'required'
            );

            calculateChange();

        } else if (
            paymentMethodSelect.value === 'QRIS'
        ) {

            // Sembunyikan CASH
            cashCalculationArea.style.display =
                'none';

            // Tampilkan QRIS
            qrisArea.style.display =
                'block';

            inputBayar.removeAttribute(
                'required'
            );

            inputBayar.setCustomValidity('');

        } else {

            // Sembunyikan semuanya
            cashCalculationArea.style.display =
                'none';

            qrisArea.style.display =
                'none';

            inputBayar.removeAttribute(
                'required'
            );

            inputBayar.setCustomValidity('');

        }

    }


    // =====================================================
    // HITUNG KEMBALIAN
    // =====================================================

    function calculateChange() {

        const bayar =
            parseFloat(
                inputBayar.value
            ) || 0;

        const kembalian =
            bayar - totalPembayaran;

        inputBayar.setCustomValidity('');

        if (
            inputBayar.value.trim() !== '' &&
            bayar > 0
        ) {

            if (
                kembalian >= 0
            ) {

                textKembalian.innerText =
                    'Rp ' +
                    kembalian.toLocaleString(
                        'id-ID'
                    );

                textKembalian.className =
                    'fw-bold fs-5 text-success';

            } else {

                textKembalian.innerText =
                    'Kurang Rp ' +
                    Math.abs(
                        kembalian
                    ).toLocaleString(
                        'id-ID'
                    );

                textKembalian.className =
                    'fw-bold fs-5 text-danger';

                inputBayar.setCustomValidity(
                    'Saldo tidak cukup.'
                );

            }

        } else {

            textKembalian.innerText =
                'Rp 0';

            textKembalian.className =
                'fw-bold fs-5 text-dark';

        }

    }


    // =====================================================
    // EVENT PAYMENT
    // =====================================================

    paymentMethodSelect.addEventListener(
        'change',
        checkPaymentMethod
    );

    inputBayar.addEventListener(
        'input',
        calculateChange
    );


    // Jalankan saat halaman dibuka
    checkPaymentMethod();


    // =====================================================
    // CHECKOUT
    // =====================================================

    checkoutForm.addEventListener(
        'submit',
        function(e) {

            // CASH
            if (
                paymentMethodSelect.value === 'CASH'
            ) {

                const bayar =
                    parseFloat(
                        inputBayar.value
                    ) || 0;

                if (
                    bayar < totalPembayaran
                ) {

                    e.preventDefault();

                    inputBayar.setCustomValidity(
                        'Saldo tidak cukup.'
                    );

                    inputBayar.reportValidity();

                    return false;

                }

            }


            // Konfirmasi checkout
            if (
                !confirm(
                    'Yakin ingin checkout?'
                )
            ) {

                e.preventDefault();

                return false;

            }

        }
    );

});
</script>

@endsection@extends('layouts.app')

@section('title', 'POS')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="pos-container py-3">
    <div class="container-fluid">

        @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-3" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            {{ session('errors') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>
        @endif

        {{-- HEADER PAGE --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold m-0 text-dark">
                    Kasir / POS
                </h4>

                <small class="text-muted">
                    Kelola transaksi dan keranjang belanja secara real-time.
                </small>
            </div>

            @if($sale->status === 'COMPLETED')
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fs-6 fw-semibold">
                <i class="fa-solid fa-circle-check me-1"></i>
                Transaksi Selesai
            </span>
            @endif
        </div>

        <div class="row g-4">

            {{-- KATALOG PRODUK --}}
            <div class="col-lg-6">

                <div class="card card-custom border-0 shadow-sm h-100">

                    <div class="card-header bg-white py-3 border-0">

                        <div class="position-relative">

                            <form method="GET" action="{{ route('penjualan.create') }}" id="searchForm">

                                <i class="fa-solid fa-magnifying-glass search-icon"></i>

                                <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                    class="form-control form-control-custom ps-5" placeholder="Cari nama produk..."
                                    autocomplete="off">

                            </form>

                        </div>

                    </div>

                    <div class="card-body p-3 product-scroll-area">

                        @forelse ($products as $product)

                        <form method="POST" action="{{ route('itempenjualan.store') }}" class="mb-2">

                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div
                                class="product-item-card p-2 rounded-3 border d-flex align-items-center justify-content-between gap-2">

                                {{-- INFO PRODUK --}}
                                <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">

                                    <div class="product-img-box flex-shrink-0">

                                        @if($product->foto)

                                        <img src="{{ asset('storage/' . $product->foto) }}" alt="{{ $product->nama }}"
                                            class="rounded-3 product-thumb">

                                        @else

                                        <div class="no-img-thumb rounded-3">
                                            <i class="fa-solid fa-box text-secondary"></i>
                                        </div>

                                        @endif

                                    </div>

                                    <div class="text-truncate">

                                        <h6 class="fw-semibold mb-1 text-dark text-truncate">
                                            {{ $product->nama }}
                                        </h6>

                                        <span class="text-purple fw-bold small">
                                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                        </span>

                                    </div>

                                </div>

                                {{-- QTY DAN TAMBAH --}}
                                <div class="d-flex align-items-center gap-2 flex-shrink-0">

                                    <input type="number" name="quantity" value="1" min="1"
                                        class="form-control text-center input-qty-catalog"
                                        {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                    <button type="submit" class="btn btn-purple"
                                        {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>

                                        <i class="fa-solid fa-plus"></i>

                                    </button>

                                </div>

                            </div>

                        </form>

                        @empty

                        <div class="text-center py-5 text-muted">

                            <i class="fa-solid fa-box-open fa-2x mb-2"></i>

                            <p class="mb-0">
                                Produk tidak ditemukan.
                            </p>

                        </div>

                        @endforelse

                    </div>

                </div>

            </div>

            {{-- KERANJANG --}}
            <div class="col-lg-6">

                <div class="card card-custom border-0 shadow-sm h-100 d-flex flex-column">

                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">

                        <i class="fa-solid fa-cart-shopping text-purple fs-5"></i>

                        <h6 class="fw-bold mb-0">
                            Keranjang Belanja
                        </h6>

                    </div>

                    <div class="card-body p-0 flex-grow-1 overflow-auto">

                        <table class="table table-hover align-middle custom-table mb-0">

                            <thead>

                                <tr>

                                    <th>Produk</th>

                                    <th>Harga</th>

                                    <th class="text-center" style="width: 100px;">
                                        Qty
                                    </th>

                                    <th class="text-end">
                                        Subtotal
                                    </th>

                                    <th class="text-center" style="width: 50px;">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($sale->itempenjualan as $item)

                                <tr>

                                    {{-- PRODUK --}}
                                    <td>

                                        <span class="fw-semibold text-dark">
                                            {{ $item->produk->nama }}
                                        </span>

                                    </td>

                                    {{-- HARGA --}}
                                    <td class="text-muted small">

                                        Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}

                                    </td>

                                    {{-- QTY --}}
                                    <td>

                                        <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">

                                            @csrf
                                            @method('PUT')

                                            <input type="number" name="quantity" value="{{ $item->kuantitas }}" min="1"
                                                class="form-control form-control-sm text-center input-qty-cart mx-auto"
                                                onchange="this.form.submit()"
                                                {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                        </form>

                                    </td>

                                    {{-- SUBTOTAL --}}
                                    <td class="text-end fw-bold text-dark">

                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}

                                    </td>

                                    {{-- HAPUS --}}
                                    <td class="text-center">

                                        @can('delete', $item)

                                        <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-outline-danger btn-sm border-0 rounded-circle"
                                                title="Hapus">

                                                <i class="fa-solid fa-trash-can"></i>

                                            </button>

                                        </form>

                                        @endcan

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5 text-muted">

                                        <i class="fa-solid fa-basket-shopping fa-2x mb-2 text-secondary opacity-50"></i>

                                        <p class="mb-0">
                                            Keranjang masih kosong
                                        </p>

                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- RINGKASAN CHECKOUT --}}
                    <div class="card-footer bg-light p-3 border-top">

                        {{-- TOTAL --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <span class="fs-6 text-muted fw-semibold">
                                Total Pembayaran
                            </span>

                            <span class="fs-4 fw-bold text-purple">
                                Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                            </span>

                        </div>

                        {{-- FORM CHECKOUT --}}
                        <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" id="checkoutForm">

                            @csrf
                            @method('PUT')

                            <input type="hidden" id="totalPembayaran" value="{{ $sale->total_pembayaran }}">

                            {{-- METODE PEMBAYARAN --}}
                            <div class="mb-3">

                                <label class="form-label small fw-semibold text-muted">
                                    Metode Pembayaran
                                </label>

                                <select name="payment_method" id="paymentMethod" class="form-select form-select-custom"
                                    required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>

                                    <option value="">
                                        -- Pilih Pembayaran --
                                    </option>

                                    <option value="CASH" {{ $sale->metode_pembayaran === 'CASH' ? 'selected' : '' }}>
                                        CASH (Tunai)
                                    </option>

                                    <option value="QRIS" {{ $sale->metode_pembayaran === 'QRIS' ? 'selected' : '' }}>
                                        QRIS
                                    </option>

                                </select>

                            </div>

                            {{-- UANG BAYAR CASH --}}
                            <div id="cashCalculationArea" class="mb-3 p-3 bg-white rounded-3 border"
                                style="display: none;">

                                <div class="mb-2">

                                    <label class="form-label small fw-semibold text-dark">
                                        Uang Bayar (Rp)
                                    </label>

                                    <input type="number" name="bayar" id="inputBayar"
                                        class="form-control form-control-custom" placeholder="Masukkan jumlah uang..."
                                        {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-2">

                                    <span class="small fw-semibold text-muted">
                                        Kembalian:
                                    </span>

                                    <span id="textKembalian" class="fw-bold fs-5 text-dark">
                                        Rp 0
                                    </span>

                                </div>

                            </div>

                            {{-- QRIS --}}
                            <div id="qrisArea" class="qris-box mb-3" style="display: none;">

                                <div class="text-center">

                                    <div class="fw-semibold text-dark mb-3">
                                        Pindai Kode QRIS untuk Pembayaran
                                    </div>

                                    {{-- FILE QRIS ADA DI public/images2/qris.jpg --}}
                                    <img src="{{ asset('images2/qris.jpg') }}" alt="QRIS Code" class="qris-image">

                                </div>

                            </div>

                            {{-- CHECKOUT --}}
                            <button type="submit" id="btnCheckout"
                                class="btn btn-purple w-100 py-2 fw-bold text-uppercase"
                                {{ $sale->status === 'COMPLETED' || $sale->itempenjualan->isEmpty() ? 'disabled' : '' }}>

                                <i class="fa-solid fa-cash-register me-1"></i>
                                Checkout

                            </button>

                        </form>

                        {{-- BATALKAN TRANSAKSI --}}
                        @can('delete', $sale)

                        @if($sale->status !== 'COMPLETED')

                        <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}"
                            onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-link text-danger w-100 mt-2 text-decoration-none small">

                                <i class="fa-solid fa-xmark me-1"></i>
                                Batalkan Transaksi

                            </button>

                        </form>

                        @endif

                        @endcan

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<style>
:root {
    --purple-primary: #300596;
    --purple-hover: #22036c;
}

.text-purple {
    color: var(--purple-primary) !important;
}

.btn-purple {
    background-color: var(--purple-primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-purple:hover {
    background-color: var(--purple-hover);
    color: #fff;
}

.card-custom {
    border-radius: 12px;
    overflow: hidden;
}

.product-scroll-area {
    max-height: 65vh;
    overflow-y: auto;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.form-control-custom,
.form-select-custom {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
}

.form-control-custom:focus,
.form-select-custom:focus {
    border-color: var(--purple-primary);
    box-shadow: 0 0 0 3px rgba(48, 5, 150, 0.15);
}

.product-item-card {
    background-color: #fff;
    transition: background-color 0.2s ease;
}

.product-item-card:hover {
    background-color: #f8fafc;
}

.product-thumb,
.no-img-thumb {
    width: 45px;
    height: 45px;
    object-fit: cover;
}

.no-img-thumb {
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.input-qty-catalog {
    width: 65px !important;
    border-radius: 6px;
    padding: 5px;
}

.input-qty-cart {
    width: 60px !important;
    border-radius: 6px;
    padding: 4px;
}

.custom-table thead th {
    background-color: var(--purple-primary);
    color: #ffffff;
    font-weight: 600;
    border: none;
    padding: 12px;
}

.custom-table tbody td {
    padding: 12px;
    border-color: #f1f5f9;
}

/* QRIS */
.qris-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 18px;
}

.qris-image {
    width: 230px;
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 8px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // =====================================================
    // AUTO SEARCH
    // =====================================================

    const searchInput =
        document.getElementById('searchInput');

    const searchForm =
        document.getElementById('searchForm');

    let searchTimeout = null;

    if (searchInput) {

        searchInput.focus();

        const val =
            searchInput.value;

        searchInput.value = '';

        searchInput.value = val;

        searchInput.addEventListener(
            'input',
            function() {

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(
                    function() {

                        searchForm.submit();

                    },
                    500
                );

            }
        );

    }


    // =====================================================
    // PEMBAYARAN
    // =====================================================

    const paymentMethodSelect =
        document.getElementById('paymentMethod');

    const cashCalculationArea =
        document.getElementById('cashCalculationArea');

    const qrisArea =
        document.getElementById('qrisArea');

    const inputBayar =
        document.getElementById('inputBayar');

    const textKembalian =
        document.getElementById('textKembalian');

    const totalPembayaran =
        parseFloat(
            document.getElementById('totalPembayaran').value
        ) || 0;

    const checkoutForm =
        document.getElementById('checkoutForm');


    // =====================================================
    // CEK METODE PEMBAYARAN
    // =====================================================

    function checkPaymentMethod() {

        if (
            paymentMethodSelect.value === 'CASH'
        ) {

            // Tampilkan CASH
            cashCalculationArea.style.display =
                'block';

            // Sembunyikan QRIS
            qrisArea.style.display =
                'none';

            inputBayar.setAttribute(
                'required',
                'required'
            );

            calculateChange();

        } else if (
            paymentMethodSelect.value === 'QRIS'
        ) {

            // Sembunyikan CASH
            cashCalculationArea.style.display =
                'none';

            // Tampilkan QRIS
            qrisArea.style.display =
                'block';

            inputBayar.removeAttribute(
                'required'
            );

            inputBayar.setCustomValidity('');

        } else {

            // Sembunyikan semuanya
            cashCalculationArea.style.display =
                'none';

            qrisArea.style.display =
                'none';

            inputBayar.removeAttribute(
                'required'
            );

            inputBayar.setCustomValidity('');

        }

    }


    // =====================================================
    // HITUNG KEMBALIAN
    // =====================================================

    function calculateChange() {

        const bayar =
            parseFloat(
                inputBayar.value
            ) || 0;

        const kembalian =
            bayar - totalPembayaran;

        inputBayar.setCustomValidity('');

        if (
            inputBayar.value.trim() !== '' &&
            bayar > 0
        ) {

            if (
                kembalian >= 0
            ) {

                textKembalian.innerText =
                    'Rp ' +
                    kembalian.toLocaleString(
                        'id-ID'
                    );

                textKembalian.className =
                    'fw-bold fs-5 text-success';

            } else {

                textKembalian.innerText =
                    'Kurang Rp ' +
                    Math.abs(
                        kembalian
                    ).toLocaleString(
                        'id-ID'
                    );

                textKembalian.className =
                    'fw-bold fs-5 text-danger';

                inputBayar.setCustomValidity(
                    'Saldo tidak cukup.'
                );

            }

        } else {

            textKembalian.innerText =
                'Rp 0';

            textKembalian.className =
                'fw-bold fs-5 text-dark';

        }

    }


    // =====================================================
    // EVENT PAYMENT
    // =====================================================

    paymentMethodSelect.addEventListener(
        'change',
        checkPaymentMethod
    );

    inputBayar.addEventListener(
        'input',
        calculateChange
    );


    // Jalankan saat halaman dibuka
    checkPaymentMethod();


    // =====================================================
    // CHECKOUT
    // =====================================================

    checkoutForm.addEventListener(
        'submit',
        function(e) {

            // CASH
            if (
                paymentMethodSelect.value === 'CASH'
            ) {

                const bayar =
                    parseFloat(
                        inputBayar.value
                    ) || 0;

                if (
                    bayar < totalPembayaran
                ) {

                    e.preventDefault();

                    inputBayar.setCustomValidity(
                        'Saldo tidak cukup.'
                    );

                    inputBayar.reportValidity();

                    return false;

                }

            }


            // Konfirmasi checkout
            if (
                !confirm(
                    'Yakin ingin checkout?'
                )
            ) {

                e.preventDefault();

                return false;

            }

        }
    );

});
</script>

@endsection