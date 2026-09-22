```blade
@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')

<style>
.laporan-page {
    min-height: 100vh;
    padding: 30px;
    background:
        radial-gradient(circle at top right, rgba(16, 185, 129, 0.12), transparent 30%),
        radial-gradient(circle at bottom left, rgba(59, 130, 246, 0.08), transparent 30%),
        #070c12;
    color: #fff;
}

.laporan-header {
    margin-bottom: 25px;
}

.laporan-header h2 {
    font-weight: 700;
    margin-bottom: 5px;
}

.laporan-header p {
    color: #94a3b8;
    margin: 0;
}

.filter-card {
    background: #101720;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 25px;
}

.filter-card label {
    color: #cbd5e1;
    font-size: 14px;
    margin-bottom: 7px;
}

.filter-card input {
    background: #0b1118;
    border: 1px solid #263241;
    color: #fff;
    border-radius: 10px;
    padding: 10px 12px;
}

.filter-card input:focus {
    background: #0b1118;
    color: #fff;
    border-color: #10b981;
    box-shadow: none;
}

.btn-filter {
    background: #10b981;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-filter:hover {
    background: #059669;
    color: #fff;
}

.btn-reset {
    background: #1e293b;
    color: #cbd5e1;
    border: 1px solid #334155;
    border-radius: 10px;
    padding: 10px 20px;
    text-decoration: none;
}

.btn-reset:hover {
    background: #334155;
    color: #fff;
}

.btn-print {
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-print:hover {
    background: #1d4ed8;
    color: #fff;
}

.stat-card {
    background: #101720;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    padding: 22px;
    height: 100%;
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 15px;
}

.icon-green {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
}

.icon-blue {
    background: rgba(37, 99, 235, 0.15);
    color: #60a5fa;
}

.icon-yellow {
    background: rgba(245, 158, 11, 0.15);
    color: #fbbf24;
}

.stat-title {
    color: #94a3b8;
    font-size: 14px;
    margin-bottom: 5px;
}

.stat-value {
    color: #fff;
    font-size: 24px;
    font-weight: 700;
}

.table-card {
    background: #101720;
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 16px;
    overflow: hidden;
    margin-top: 25px;
}

.table-header {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h5 {
    margin: 0;
    font-weight: 700;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    margin: 0;
    color: #e2e8f0;
}

.table thead th {
    background: #0b1118;
    color: #94a3b8;
    border-bottom: 1px solid #263241;
    padding: 14px;
    font-size: 13px;
    white-space: nowrap;
}

.table tbody td {
    background: #101720;
    color: #e2e8f0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    padding: 14px;
    vertical-align: middle;
}

.table tbody tr:hover td {
    background: #141e29;
}

.badge-selesai {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.badge-payment {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.empty-data {
    text-align: center;
    padding: 50px 20px !important;
    color: #64748b !important;
}

.empty-data i {
    font-size: 45px;
    display: block;
    margin-bottom: 12px;
}

@media print {

    .no-print {
        display: none !important;
    }

    .laporan-page {
        background: #fff !important;
        color: #000 !important;
        padding: 0 !important;
    }

    .table-card,
    .stat-card {
        background: #fff !important;
        color: #000 !important;
        border: 1px solid #ddd !important;
    }

    .table,
    .table tbody td {
        background: #fff !important;
        color: #000 !important;
    }

    .table thead th {
        background: #eee !important;
        color: #000 !important;
    }

    .stat-title {
        color: #555 !important;
    }

    .stat-value {
        color: #000 !important;
    }
}
</style>


<div class="laporan-page">

    {{-- HEADER --}}
    <div class="laporan-header d-flex justify-content-between align-items-center">

        <div>
            <h2>
                <i class="bi bi-bar-chart-line me-2"></i>
                Laporan Penjualan
            </h2>

            <p>
                Laporan transaksi penjualan Remon Thrift House
            </p>
        </div>

        <div class="no-print d-flex gap-2">

            {{-- KEMBALI KE BERANDA --}}
            <a href="{{ route('dashboard') }}" class="btn-reset">

                <i class="bi bi-house-door me-2"></i>
                Kembali ke Beranda

            </a>


            {{-- CETAK LAPORAN --}}
            <button type="button" onclick="window.print()" class="btn btn-print">

                <i class="bi bi-printer me-2"></i>
                Cetak Laporan

            </button>

        </div>

    </div>


    {{-- FILTER --}}
    <div class="filter-card no-print">

        <form action="{{ route('penjualan.laporan') }}" method="GET">

            <div class="row g-3 align-items-end">

                <div class="col-md-4">

                    <label>
                        Tanggal Mulai
                    </label>

                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggalMulai ?? '' }}">

                </div>


                <div class="col-md-4">

                    <label>
                        Tanggal Akhir
                    </label>

                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $tanggalAkhir ?? '' }}">

                </div>


                <div class="col-md-4 d-flex gap-2">

                    <button type="submit" class="btn btn-filter">

                        <i class="bi bi-funnel me-1"></i>
                        Filter

                    </button>


                    <a href="{{ route('penjualan.laporan') }}" class="btn-reset">

                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- STATISTIK --}}
    <div class="row g-4">

        {{-- TOTAL TRANSAKSI --}}
        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon icon-blue">

                    <i class="bi bi-receipt"></i>

                </div>

                <div class="stat-title">
                    Total Transaksi
                </div>

                <div class="stat-value">

                    {{ number_format($totalTransaksi ?? 0, 0, ',', '.') }}

                </div>

            </div>

        </div>


        {{-- TOTAL BARANG --}}
        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon icon-yellow">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div class="stat-title">
                    Total Barang Terjual
                </div>

                <div class="stat-value">

                    {{ number_format($totalBarang ?? 0, 0, ',', '.') }}

                </div>

            </div>

        </div>


        {{-- TOTAL PENDAPATAN --}}
        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon icon-green">

                    <i class="bi bi-cash-stack"></i>

                </div>

                <div class="stat-title">
                    Total Pendapatan
                </div>

                <div class="stat-value">

                    Rp
                    {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}

                </div>

            </div>

        </div>

    </div>


    {{-- TABEL LAPORAN --}}
    <div class="table-card">

        <div class="table-header">

            <div>

                <h5>
                    <i class="bi bi-table me-2"></i>
                    Data Penjualan
                </h5>

            </div>

            <div class="text-secondary small">

                {{ $sales->count() }} transaksi

            </div>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Tanggal</th>

                        <th>Kasir</th>

                        <th>Jumlah Barang</th>

                        <th>Metode Pembayaran</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th class="no-print">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($sales as $sale)

                    <tr>

                        {{-- NOMOR --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- TANGGAL --}}
                        <td>

                            {{ $sale->created_at
                                    ? $sale->created_at->format('d/m/Y H:i')
                                    : '-' }}

                        </td>


                        {{-- KASIR --}}
                        <td>

                            {{ $sale->user->name ?? '-' }}

                        </td>


                        {{-- JUMLAH BARANG --}}
                        <td>

                            {{ number_format(
                                    $sale->itemPenjualan->sum('kuantitas'),
                                    0,
                                    ',',
                                    '.'
                                ) }}

                        </td>


                        {{-- METODE --}}
                        <td>

                            <span class="badge-payment">

                                {{ $sale->metode_pembayaran ?? '-' }}

                            </span>

                        </td>


                        {{-- TOTAL --}}
                        <td>

                            <strong>

                                Rp
                                {{ number_format(
                                        $sale->total_pembayaran ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                            </strong>

                        </td>


                        {{-- STATUS --}}
                        <td>

                            <span class="badge-selesai">

                                {{ $sale->status }}

                            </span>

                        </td>


                        {{-- AKSI --}}
                        <td class="no-print">

                            <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-sm btn-outline-light">

                                <i class="bi bi-eye"></i>

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="empty-data">

                            <i class="bi bi-inbox"></i>

                            Belum ada data penjualan.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection