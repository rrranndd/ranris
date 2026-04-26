@extends('layout.app')

@section('title', 'Home')

@section('content')

<section class="hero">
    <div class="hero-content">
        <div class="hero-inner">
            <h1>Kue Kering Premium 250gr</h1>
            <p>Nastar, kastengel, dan berbagai kue lezat lainnya</p>

            <a href="/produk">
                <button class="btn">Lihat Produk</button>
            </a>
        </div>
    </div>
</section>

<section class="produk-unggulan">
    <h2>Produk Unggulan</h2>

    <div class="produk-grid">

        <div class="produk-item">
            <img src="/assets/img/nastar1.png" alt="Nastar">
            <h3>NASTAR</h3>
        </div>

        <div class="produk-item">
            <img src="/assets/img/kastengel.png" alt="Kastengel">
            <h3>KASTENGEL</h3>
        </div>

        <div class="produk-item">
            <img src="/assets/img/tumblertump.png" alt="Tumbprint Cookies">
            <h3>TUMBPRINT COOKIES</h3>
        </div>

    </div>
</section>

<section class="keunggulan">
    <h2>Kenapa Pilih Kami</h2>

    <div class="keunggulan-grid">

        <!-- ITEM 1 -->
        <div class="keunggulan-item">
            <div class="icon">
                <svg width="40" height="40" fill="none" stroke="#b68d40" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 2l3 7h7l-5.5 4 2 7-6.5-4.5L5.5 20l2-7L2 9h7z"/>
                </svg>
            </div>
            <h3>Bahan Premium</h3>
            <p>Menggunakan bahan berkualitas tinggi</p>
        </div>

        <!-- ITEM 2 -->
        <div class="keunggulan-item">
            <div class="icon">
                <svg width="40" height="40" fill="none" stroke="#b68d40" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <h3>Fresh</h3>
            <p>Dibuat setiap hari</p>
        </div>

        <!-- ITEM 3 -->
        <div class="keunggulan-item">
            <div class="icon">
                <svg width="40" height="40" fill="none" stroke="#b68d40" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="8" width="18" height="13" rx="2"/>
                    <path d="M3 8l9 6 9-6"/>
                    <path d="M12 2v6"/>
                </svg>
            </div>
            <h3>Cocok untuk Hampers</h3>
            <p>Desain menarik untuk hadiah</p>
        </div>

    </div>
</section>

<section class="cta">
    <div class="cta-box">
        <h2>Siap Memesan?</h2>
        <p>Nikmati kue premium buatan fresh setiap hari</p>

        <a href="/produk" class="btn-cta">
            Pesan Sekarang
        </a>
    </div>
</section>

<footer class="footer">
    <p>© 2026 RANRIS. All rights reserved.</p>
</footer>

@endsection