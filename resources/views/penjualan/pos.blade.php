@extends('layouts.app')

@section('title', 'POS')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="pos-container py-3">
    <div class="container-fluid">

        {{-- ALERT ERROR --}}
        @if(session('errors'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-3" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('errors') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- HEADER PAGE --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold m-0 text-dark">Kasir / POS</h4>
                <small class="text-muted">Kelola transaksi dan keranjang belanja secara real-time.</small>
            </div>
            @if($sale->status === 'COMPLETED')
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fs-6 fw-semibold">
                    <i class="fa-solid fa-circle-check me-1"></i> Transaksi Selesai
                </span>
            @endif
        </div>

        <div class="row g-4">

            {{-- ===== SEKSI KATALOG PRODUK ===== --}}
            <div class="col-lg-6">
                <div class="card card-custom border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="position-relative">
                            <form method="GET" action="{{ route('penjualan.create') }}">
                                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control form-control-custom ps-5"
                                    placeholder="Cari nama produk..."
                                    onkeyup="this.form.submit()">
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-3 product-scroll-area">
                        @forelse ($products as $product)
                            <form method="POST" action="{{ route('itempenjualan.store') }}" class="mb-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="product-item-card p-2 rounded-3 border d-flex align-items-center justify-content-between gap-2">
                                    {{-- info produk --}}
                                    <div class="d-flex align-items-center gap-3 flex-grow-1 min-w-0">
                                        <div class="product-img-box flex-shrink-0">
                                            @if($product->foto)
                                                <img src="{{ asset('storage/'.$product->foto) }}" alt="{{ $product->nama }}" class="rounded-3 product-thumb">
                                            @else
                                                <div class="no-img-thumb rounded-3">
                                                    <i class="fa-solid fa-box text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-truncate">
                                            <h6 class="fw-semibold mb-1 text-dark text-truncate">{{ $product->nama }}</h6>
                                            <span class="text-success fw-bold small">
                                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- input qty & tambah --}}
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                                        <input
                                            type="number"
                                            name="quantity"
                                            value="1"
                                            min="1"
                                            class="form-control text-center input-qty-catalog"
                                            {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>

                                        <button
                                            type="submit"
                                            class="btn btn-emerald"
                                            {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-box-open fa-2x mb-2"></i>
                                <p class="mb-0">Produk tidak ditemukan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ===== SEKSI KERANJANG ===== --}}
            <div class="col-lg-6">
                <div class="card card-custom border-0 shadow-sm h-100 d-flex flex-column">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-2">
                        <i class="fa-solid fa-cart-shopping text-emerald fs-5"></i>
                        <h6 class="fw-bold mb-0">Keranjang Belanja</h6>
                    </div>

                    <div class="card-body p-0 flex-grow-1 overflow-auto">
                        <table class="table table-hover align-middle custom-table mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th class="text-center" style="width: 100px;">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center" style="width: 50px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sale->itempenjualan as $item)
                                    <tr>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item->produk->nama }}</span>
                                        </td>
                                        <td class="text-muted small">
                                            Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input
                                                    type="number"
                                                    name="quantity"
                                                    value="{{ $item->kuantitas }}"
                                                    min="1"
                                                    class="form-control form-control-sm text-center input-qty-cart mx-auto"
                                                    onchange="this.form.submit()"
                                                    {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @can('delete', $item)
                                                <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm border-0 rounded-circle" title="Hapus">
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
                                            <p class="mb-0">Keranjang masih kosong</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- RINGKASAN & CHECKOUT --}}
                    <div class="card-footer bg-light p-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fs-6 text-muted fw-semibold">Total Pembayaran</span>
                            <span class="fs-4 fw-bold text-emerald">
                                Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('penjualan.update', $sale->id) }}" id="checkoutForm">
                            @csrf
                            @method('PUT')

                            {{-- Hidden Field Total --}}
                            <input type="hidden" id="totalPembayaran" value="{{ $sale->total_pembayaran }}">

                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Metode Pembayaran</label>
                                <select name="payment_method" id="paymentMethod" class="form-select form-select-custom" required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Pembayaran --</option>
                                    <option value="CASH" {{ $sale->metode_pembayaran === 'CASH' ? 'selected' : '' }}>CASH (Tunai)</option>
                                    <option value="QRIS" {{ $sale->metode_pembayaran === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                </select>
                            </div>

                            {{-- INPUT UANG BAYAR & KEMBALIAN (KHUSUS CASH) --}}
                            <div id="cashCalculationArea" class="mb-3 p-3 bg-white rounded-3 border" style="display: none;">
                                <div class="mb-2">
                                    <label class="form-label small fw-semibold text-dark">Uang Bayar (Rp)</label>
                                    <input type="number" name="bayar" id="inputBayar" class="form-control form-control-custom" placeholder="Masukkan jumlah uang..." min="{{ $sale->total_pembayaran }}" {{ $sale->status === 'COMPLETED' ? 'readonly' : '' }}>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="small fw-semibold text-muted">Kembalian:</span>
                                    <span id="textKembalian" class="fw-bold fs-5 text-dark">Rp 0</span>
                                </div>
                            </div>

                            <button type="submit" id="btnCheckout" class="btn btn-emerald w-100 py-2 fw-bold text-uppercase" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cash-register me-1"></i> Checkout
                            </button>
                        </form>

                        @can('delete', $sale)
                            @if($sale->status !== 'COMPLETED')
                                <form method="POST" action="{{ route('penjualan.destroy', $sale->id) }}" onsubmit="return confirm('Yakin ingin membatalkan transaksi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link text-danger w-100 mt-2 text-decoration-none small">
                                        <i class="fa-solid fa-xmark me-1"></i> Batalkan Transaksi
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
    --emerald-primary: #059669;
    --emerald-hover: #047857;
}

.text-emerald { color: var(--emerald-primary) !important; }

.btn-emerald {
    background-color: var(--emerald-primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-emerald:hover {
    background-color: var(--emerald-hover);
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

.form-control-custom, .form-select-custom {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
}

.form-control-custom:focus, .form-select-custom:focus {
    border-color: var(--emerald-primary);
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
}

.product-item-card {
    background-color: #fff;
    transition: background-color 0.2s ease;
}

.product-item-card:hover {
    background-color: #f8fafc;
}

.product-thumb, .no-img-thumb {
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
    background-color: #059669;
    color: #ffffff;
    font-weight: 600;
    border: none;
    padding: 12px;
}

.custom-table tbody td {
    padding: 12px;
    border-color: #f1f5f9;
}
</style>

{{-- JAVASCRIPT HITUNG KEMBALIAN --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodSelect = document.getElementById('paymentMethod');
    const cashCalculationArea = document.getElementById('cashCalculationArea');
    const inputBayar = document.getElementById('inputBayar');
    const textKembalian = document.getElementById('textKembalian');
    const totalPembayaran = parseFloat(document.getElementById('totalPembayaran').value) || 0;
    const checkoutForm = document.getElementById('checkoutForm');

    // Tampilkan / Sembunyikan Input Bayar berdasarkan Metode
    function checkPaymentMethod() {
        if (paymentMethodSelect.value === 'CASH') {
            cashCalculationArea.style.display = 'block';
            inputBayar.setAttribute('required', 'required');
        } else {
            cashCalculationArea.style.display = 'none';
            inputBayar.removeAttribute('required');
        }
    }

    // Hitung Kembalian Otomatis
    function calculateChange() {
        const bayar = parseFloat(inputBayar.value) || 0;
        const kembalian = bayar - totalPembayaran;

        if (bayar > 0) {
            if (kembalian >= 0) {
                textKembalian.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                textKembalian.className = 'fw-bold fs-5 text-success';
            } else {
                textKembalian.innerText = 'Kurang Rp ' + Math.abs(kembalian).toLocaleString('id-ID');
                textKembalian.className = 'fw-bold fs-5 text-danger';
            }
        } else {
            textKembalian.innerText = 'Rp 0';
            textKembalian.className = 'fw-bold fs-5 text-dark';
        }
    }

    paymentMethodSelect.addEventListener('change', checkPaymentMethod);
    inputBayar.addEventListener('input', calculateChange);
    
    // Inisialisasi awal saat load
    checkPaymentMethod();

    checkoutForm.addEventListener('submit', function(e) {
        if (paymentMethodSelect.value === 'CASH') {
            const bayar = parseFloat(inputBayar.value) || 0;
            if (bayar < totalPembayaran) {
                e.preventDefault();
                alert('Uang bayar kurang dari total pembayaran!');
                return false;
            }
        }
        return confirm('Yakin ingin checkout?');
    });
});
</script>

@endsection