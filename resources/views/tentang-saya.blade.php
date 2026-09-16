@extends('layouts.app')

@section('title', 'Tentang Saya')

@section('content')

@include('layouts.navbar')

<div class="about-me-container">
    <div class="page-card text-center">
        
        {{-- FOTO / AVATAR PROFIL --}}
        <div class="profile-avatar-wrapper">
            <div class="profile-avatar">
                👨‍💻
            </div>
        </div>

        {{-- NAMA & ROLE --}}
        <h2 class="developer-name">Remon</h2>
        <p class="developer-role">Web Developer / Software Engineer</p>

        <hr class="divider">

        {{-- DESKRIPSI SINGKAT --}}
        <p class="bio-text">
            Halo! Saya adalah pengembang aplikasi <strong>Remon Thrift House POS</strong>. 
            Sistem ini dirancang untuk mempermudah pencatatan transaksi, pengelolaan stok produk, 
            dan pemantauan riwayat penjualan toko secara efisien.
        </p>

        {{-- KARTU INFORMASI PROFIL --}}
        <div class="row g-3 justify-content-center mt-3">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon">🎓</div>
                    <div class="info-title">Pendidikan</div>
                    <div class="info-value">SMKN 4 Tasikmalaya</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon">🛠️</div>
                    <div class="info-title">Tech Stack</div>
                    <div class="info-value">Laravel 11, Bootstrap 5, MySQL</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon">✉️</div>
                    <div class="info-title">Kontak</div>
                    <div class="info-value">reymon@gmail.com</div>
                </div>
            </div>
        </div>

        {{-- TOMBOL KEMBALI --}}
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn-back">
                ← Kembali ke Dashboard
            </a>
        </div>

    </div>
</div>

<style>
.about-me-container {
    position: relative;
    min-height: 100vh;
    padding: 40px 20px;
    background:
        radial-gradient(circle at 5% 10%, rgba(16, 185, 129, 0.13), transparent 32%),
        radial-gradient(circle at 95% 80%, rgba(59, 130, 246, 0.08), transparent 30%),
        linear-gradient(135deg, #020807 0%, #03120f 45%, #020609 100%);
    color: #e2e8f0;
}

.page-card {
    max-width: 800px;
    margin: 0 auto;
    background: linear-gradient(145deg, rgba(10, 27, 32, 0.88), rgba(7, 20, 25, 0.82));
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(17px);
    border-radius: 21px;
    padding: 35px 25px;
    box-shadow: 0 22px 55px rgba(0, 0, 0, 0.40);
}

.profile-avatar-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: rgba(16, 185, 129, 0.15);
    border: 2px solid rgba(52, 211, 153, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
}

.developer-name {
    color: #ffffff;
    font-weight: 800;
    font-size: 24px;
    margin-bottom: 4px;
}

.developer-role {
    color: #34d399;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 0;
}

.divider {
    border-color: rgba(255, 255, 255, 0.1);
    margin: 20px auto;
    width: 60%;
}

.bio-text {
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.6;
    max-width: 650px;
    margin: 0 auto;
}

.info-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 12px;
    padding: 15px;
    height: 100%;
}

.info-icon {
    font-size: 20px;
    margin-bottom: 5px;
}

.info-title {
    font-size: 11px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    margin-top: 3px;
}

.btn-back {
    display: inline-block;
    background: rgba(16, 185, 129, 0.1);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.25);
    padding: 9px 20px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-back:hover {
    background: #10b981;
    color: #ffffff;
}
</style>

@endsection