@extends('layouts.app')

@section('title', 'Remon Thrift House - Manajemen Users')

@section('content')

@include('layouts.navbar')

<style>
:root {
    --bg-main: #090d16;
    --card-bg: rgba(17, 24, 39, 0.75);
    --accent-emerald: #2614c4;
    --accent-emerald-hover: #310c6d;
    --border-color: rgba(255, 255, 255, 0.12);
    --text-muted: #94a3b8;
}

body {
    background:
        radial-gradient(circle at 10% 10%, rgba(16, 185, 129, 0.08), transparent 25%),
        radial-gradient(circle at 90% 20%, rgba(56, 189, 248, 0.06), transparent 25%),
        linear-gradient(135deg, #07111c 0%, #0b1625 45%, #071c1a 100%) !important;
    font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    color: #f8fafc !important;
    min-height: 100vh;
}

/* HEADER */
.header-box {
    background: radial-gradient(circle at top left, rgba(16, 185, 129, 0.14), transparent 55%), rgba(17, 24, 39, 0.92);
    border: 1px solid var(--border-color);
    border-radius: 22px;
    padding: 28px 32px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

.brand-pill {
    background: rgba(16, 185, 129, 0.12);
    color: var(--accent-emerald);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;
    padding: 5px 14px;
    border-radius: 30px;
    border: 1px solid rgba(16, 185, 129, 0.30);
    display: inline-block;
}

.header-subtitle {
    color: #cbd5e1 !important;
    font-size: 13px;
}


.btn-create {
    background: linear-gradient(135deg, #3e08d1, #3e08d1) !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 13px;
    font-weight: 700;
    font-size: 14px;
    padding: 12px 22px;
    transition: all 0.25s ease;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.22);
    text-decoration: none !important;
}

.btn-create:hover {
    transform: translateY(-2px);
    color: #ffffff !important;
    box-shadow: 0 12px 25px rgba(16, 185, 129, 0.34);
}

/* STAT CARDS */
.stat-card {
    background: linear-gradient(145deg, rgba(25, 38, 53, 0.94), rgba(17, 24, 39, 0.94));
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.10);
    border-radius: 18px;
    padding: 21px 23px;
    display: flex;
    align-items: center;
    gap: 17px;
    min-height: 105px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, rgba(16, 185, 129, 0.8), rgba(56, 189, 248, 0.65));
}

.stat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(16, 55, 185, 0.35);
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.30);
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.stat-label {
    color: #cbd5e1 !important;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 4px;
}

.stat-value {
    color: #ffffff !important;
    font-size: 22px;
    font-weight: 800;
    line-height: 1.2;
}

/* MAIN CARD */
.main-card {
    background: linear-gradient(145deg, rgba(15, 23, 42, 0.94), rgba(15, 23, 42, 0.80));
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.09);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28);
}

/* SEARCH */
.search-container {
    background: rgba(17, 24, 39, 0.92);
    border: 1px solid var(--border-color);
    border-radius: 13px;
    padding: 6px 7px 6px 15px;
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 520px;
    transition: all 0.2s ease;
}

.search-container:focus-within {
    border-color: rgba(22, 73, 212, 0.5);
    box-shadow: 0 0 15px rgba(16, 185, 129, 0.12);
}

.search-input {
    background: transparent !important;
    border: none !important;
    color: #ffffff !important;
    font-size: 13px;
    box-shadow: none !important;
    width: 100%;
    outline: none;
    padding-right: 10px;
}

.search-input::placeholder {
    color: var(--text-muted);
}

.btn-search-submit {
    background: var(--accent-emerald) !important;
    color: #ffffff !important;
    border: none !important;
    font-weight: 700;
    font-size: 12px;
    padding: 8px 17px;
    border-radius: 10px;
    white-space: nowrap;
    transition: all 0.2s ease;
}

.btn-search-submit:hover {
    background: var(--accent-emerald-hover) !important;
    transform: translateY(-1px);
}

/* TABLE */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
    scrollbar-width: thin;
}

.custom-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
    min-width: 760px;
}

.custom-table thead th {
    background: rgba(30, 41, 59, 0.95);
    color: #38bdf8 !important;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.9px;
    text-transform: uppercase;
    padding: 13px 17px;
    border: none;
}

.custom-table thead th:first-child {
    border-radius: 11px 0 0 11px;
}

.custom-table thead th:last-child {
    border-radius: 0 11px 11px 0;
}

.custom-table tbody tr {
    transition: all 0.2s ease;
}

.custom-table tbody tr:hover {
    transform: translateY(-1px);
}

.custom-table tbody td {
    background: rgba(17, 24, 39, 0.88);
    color: #f8fafc;
    padding: 14px 17px;
    border-top: 1px solid rgba(255, 255, 255, 0.07);
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    vertical-align: middle;
}

.custom-table tbody tr:hover td {
    background: rgba(30, 41, 59, 0.95);
}

.custom-table tbody td:first-child {
    border-left: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 12px 0 0 12px;
}

.custom-table tbody td:last-child {
    border-right: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 0 12px 12px 0;
}

/* USER AVATAR */
.user-avatar {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 13px;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.15);
}

/* ROLE BADGE */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 6px 12px;
    border-radius: 30px;
    background: rgba(16, 185, 129, 0.12);
    border: 1px solid rgba(16, 185, 129, 0.28);
    color: #2e39db !important;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.role-badge::before {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--accent-emerald);
    box-shadow: 0 0 8px rgba(27, 16, 185, 0.65);
}

/* ACTION BUTTONS */
.btn-act {
    border: none !important;
    font-size: 11px;
    font-weight: 700;
    padding: 8px 13px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: all 0.2s ease;
    text-decoration: none !important;
    white-space: nowrap;
}

.btn-act:hover {
    transform: translateY(-1px);
}

.btn-act-edit {
    background: rgba(245, 158, 11, 0.13) !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(245, 158, 11, 0.22) !important;
}

.btn-act-edit:hover {
    background: #f59e0b !important;
    color: #ffffff !important;
}

.btn-act-delete {
    background: rgba(239, 68, 68, 0.12) !important;
    color: #f87171 !important;
    border: 1px solid rgba(239, 68, 68, 0.22) !important;
}

.btn-act-delete:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
}

/* PAGINATION */
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
}

.pagination .page-link:hover {
    background: rgba(16, 185, 129, 0.12);
    color: #6ee7b7;
    border-color: rgba(16, 185, 129, 0.25);
}

.pagination .page-item.active .page-link {
    background: #2910b9;
    border-color: #4310b9;
    color: #ffffff;
}

.pagination .page-item.disabled .page-link {
    background: rgba(255, 255, 255, 0.025);
    color: #475569;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .header-box {
        padding: 22px;
    }

    .main-card {
        padding: 18px;
    }

    .search-container {
        max-width: 100%;
    }

    .btn-create {
        width: 100%;
    }

    .stat-card {
        min-height: 92px;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    .header-box {
        border-radius: 17px;
        padding: 20px;
    }

    .main-card {
        border-radius: 16px;
        padding: 14px;
    }

    .stat-card {
        padding: 17px;
        border-radius: 15px;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 13px;
    }

    .stat-value {
        font-size: 20px;
    }

    .search-container {
        padding-left: 12px;
    }

    .btn-search-submit {
        padding: 8px 12px;
    }
}
</style>

<div class="container-fluid py-4 px-md-4">

    {{-- HEADER --}}
    <div class="header-box d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <span class="brand-pill mb-2">👥 REMON THRIFT HOUSE</span>
            <h2 class="fw-bold text-white mb-1" style="font-size: 24px;">Manajemen Users</h2>
            <p class="header-subtitle mb-0">Kelola hak akses dan akun pengguna aplikasi POS dengan mudah dan aman.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-create d-inline-flex align-items-center gap-2">
                <span class="fs-5">+</span> Tambah User Baru
            </a>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="stat-card">
                <div class="stat-icon"
                    style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.30);">
                    👥
                </div>
                <div>
                    <span class="stat-label">Total Pengguna</span>
                    <div class="stat-value">
                        {{ method_exists($users, 'total') ? $users->total() : (is_countable($users) ? count($users) : 0) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="main-card">

        {{-- SEARCH FORM --}}
        <div class="mb-4">
            <form action="{{ route('admin.users') }}" method="GET">
                <div class="search-container">
                    <span class="me-2" style="color: #64748b; font-size: 14px;">🔍</span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control search-input"
                        placeholder="Cari berdasarkan nama atau email pengguna...">
                    <button type="submit" class="btn btn-search-submit">Cari Data</button>
                </div>
            </form>
        </div>

        {{-- TABLE DATA --}}
        <div class="table-wrapper">
            <table class="custom-table align-middle">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="35%">Nama Lengkap</th>
                        <th width="25%">Email</th>
                        <th width="15%">Role Akses</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        {{-- NOMOR --}}
                        <td class="text-center fw-bold" style="color: #cbd5e1; font-size: 13px;">
                            {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                        </td>

                        {{-- NAMA & AVATAR --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-white" style="font-size: 14px;">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size: 11px;">Terdaftar ID: #{{ $user->id }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- EMAIL --}}
                        <td>
                            <span style="font-size: 13px; color: #cbd5e1 !important;">
                                {{ $user->email }}
                            </span>
                        </td>

                        {{-- ROLE --}}
                        <td>
                            <span class="role-badge">
                                {{ is_object($user->role) ? $user->role->name : ($user->role ?? 'admin') }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-act btn-act-edit"
                                    title="Edit Pengguna">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                    class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-delete"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                        title="Hapus Pengguna">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="py-3">
                                <div style="font-size: 48px;" class="mb-2">👥</div>
                                <h6 class="text-white fw-bold mb-1">Belum Ada Data User Ditemukan</h6>
                                <p class="text-muted small mb-0">Klik "+ Tambah User Baru" untuk menambahkan pengguna
                                    baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if(method_exists($users, 'links'))
        <div class="d-flex justify-content-end mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>

@endsection