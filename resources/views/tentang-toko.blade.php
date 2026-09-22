@extends('layouts.app')

@section('title', 'Tentang Toko - Remon Thrift House')

@section('content')

<style>
.about-wrapper {
    position: relative;
    z-index: 1;
}


.brand-showcase-card {
    background: rgba(6, 78, 59, 0.85);
    border: 1px solid rgba(52, 211, 153, 0.4);
    border-radius: 24px;
    box-shadow: 0 15px 35px rgba(4, 47, 38, 0.4);
    backdrop-filter: blur(12px);
}

.product-avatar-ring {
    width: 170px;
    height: 170px;
    background: rgba(16, 185, 129, 0.2);
    border: 3px solid #34d399;
    box-shadow: 0 0 20px rgba(52, 211, 153, 0.3);
}

.feature-card-modern {
    background: rgba(6, 78, 59, 0.85);
    border: 1px solid rgba(52, 211, 153, 0.3);
    border-radius: 18px;
    backdrop-filter: blur(12px);
}

.tech-badge-clean {
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(52, 211, 153, 0.3);
    color: #ecfdf5;
    padding: 8px 16px;
    border-radius: 12px;
    font-weight: 500;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-back-modern {
    background: linear-gradient(135deg, #10b981, #34d399);
    color: #064e3b;
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}
</style>

<div class="container py-5 about-wrapper">


    <div class="brand-showcase-card p-4 p-lg-5 mb-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-3 text-center">
                <div
                    class="product-avatar-ring rounded-circle mx-auto d-flex align-items-center justify-content-center overflow-hidden p-2">
                    <img src="{{ asset('images/thrift.jpg') }}" alt="Remon Thrift House"
                        class="rounded-circle w-100 h-100" style="object-fit: cover;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-100 h-100 rounded-circle justify-content-center align-items-center"
                        style="display: none; background: #064e3b; color: #34d399;">
                        <i class="bi bi-shop display-5"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 text-center text-lg-start">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3"
                    style="background: rgba(52, 211, 153, 0.15); border: 1px solid rgba(52, 211, 153, 0.4);">
                    <i class="bi bi-bag-heart-fill" style="color: #6ee7b7;"></i>
                    <span class="fw-semibold small" style="color: #a7f3d0;">Curated Vintage & Streetwear Store</span>
                </div>

                <h1 class="display-6 fw-bold text-white mb-2">
                    Remon Thrift House
                </h1>

                <p class="text-white opacity-90 mb-3" style="max-width: 700px; line-height: 1.7;">
                    Pusat pakaian thrift pilihan berkualitas tinggi. Kami berkomitmen menyajikan fashion bekas original
                    terkurasi, siap pakai, bersih, dan higienis untuk gaya harian Anda yang makin estetik dan ramah
                    kantong.
                </p>

                <div
                    class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 text-white opacity-75 small">
                    <div><i class="bi bi-person-badge me-1" style="color: #6ee7b7;"></i> Owner: <strong>Reymon</strong>
                    </div>
                    <div>&bull;</div>
                    <div><i class="bi bi-tag-fill me-1" style="color: #6ee7b7;"></i> Kategori: <strong>Thrift & Vintage
                            Clothing</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL CARDS GRID -->
    <div class="row g-4 mb-4">

        <!-- KARTU INFORMASI & LOKASI TOKO -->
        <div class="col-lg-6">
            <div class="feature-card-modern p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 p-3"
                        style="background: rgba(52, 211, 153, 0.2); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.4);">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-white mb-0">Informasi & Lokasi Toko</h4>
                        <span class="text-white opacity-50 small">Profil dan alamat Remon Thrift House</span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3 text-white opacity-90 small">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-check2-circle mt-1 fs-5" style="color: #6ee7b7;"></i>
                        <div><strong>Produk yang Dijual:</strong> Menyediakan berbagai pakaian <i>thrift</i> pilihan
                            seperti kaos, hoodie, jaket, celana, dan aksesoris <i>secondhand</i> berkualitas tinggi.
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-check2-circle mt-1 fs-5" style="color: #6ee7b7;"></i>
                        <div><strong>Alamat Toko:</strong> Jl. Raya Utama No. 123, Kel. Sukamaju, Kec. Cibeureum, Kota
                            Tasikmalaya, Jawa Barat.</div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-check2-circle mt-1 fs-5" style="color: #6ee7b7;"></i>
                        <div><strong>Jam Operasional:</strong> Buka setiap hari Senin – Minggu, pukul 09.00 – 19.00 WIB.
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="feature-card-modern p-4 h-100">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="rounded-3 p-3"
                        style="background: rgba(52, 211, 153, 0.2); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.4);">
                        <i class="bi bi-stars fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-white mb-0">Layanan & Fasilitas</h4>
                        <span class="text-white opacity-50 small">Kenyamanan belanja untuk pelanggan</span>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <div class="tech-badge-clean"><i class="bi bi-sparkles" style="color: #6ee7b7;"></i> Pakaian Bersih
                        & Siap Pakai</div>
                    <div class="tech-badge-clean"><i class="bi bi-award-fill" style="color: #6ee7b7;"></i> Terjamin 100%
                        Original</div>
                    <div class="tech-badge-clean"><i class="bi bi-qr-code-scan" style="color: #6ee7b7;"></i> Pembayaran
                        Cash & QRIS</div>
                    <div class="tech-badge-clean"><i class="bi bi-door-open-fill" style="color: #6ee7b7;"></i> Fitting
                        Room Nyaman</div>
                    <div class="tech-badge-clean"><i class="bi bi-truck" style="color: #6ee7b7;"></i> Pengiriman Seluruh
                        Indonesia</div>
                    <div class="tech-badge-clean"><i class="bi bi-percent" style="color: #6ee7b7;"></i> Promo & Diskip
                        Mingguan</div>
                </div>
            </div>
        </div>

    </div>


    <div class="feature-card-modern p-4 mb-4">
        <div class="row text-center text-md-start align-items-center g-3">
            <div class="col-md-8">
                <h5 class="fw-bold text-white mb-1">Remon Thrift House</h5>
                <p class="text-white opacity-75 small mb-0">Belanja thrift aman, nyaman, dan ramah lingkungan. Dapatkan
                    barang langka impianmu hari ini!</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge px-3 py-2 rounded-pill"
                    style="background: rgba(52, 211, 153, 0.15); color: #a7f3d0; border: 1px solid rgba(52, 211, 153, 0.4);">
                    <i class="bi bi-circle-fill me-1" style="font-size: 8px; color: #34d399;"></i> Status Toko: Buka
                </span>
            </div>
        </div>
    </div>


    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn-back-modern">
            <i class="bi bi-arrow-left-circle-fill fs-5"></i>
            Kembali ke Dashboard
        </a>
    </div>

</div>

@endsection