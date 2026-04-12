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

    <div class="grid">
        <div class="card">
            <img src="/assets/img/nastar1.png" alt="Nastar">
            <h3>Nastar</h3>
            <p>Lembut dengan isian nanas premium</p>
        </div>

        <div class="card">
            <img src="/assets/img/kastengel.png" alt="Kastengel">
            <h3>Kastengel</h3>
            <p>Keju gurih dan renyah</p>
        </div>

        <div class="card">
            <img src="/assets/img/tumblertump.png" alt="Tumbprint Cookies">
            <h3>Tumbprint Cookies</h3>
            <p>Lumer di mulut</p>
        </div>
    </div>
</section>

<section class="keunggulan">
    <h2>Kenapa Pilih Kami</h2>

    <div class="grid">
        <div class="card">
            <h3>Bahan Premium</h3>
            <p>Menggunakan bahan berkualitas tinggi</p>
        </div>

        <div class="card">
            <h3>Fresh</h3>
            <p>Dibuat setiap hari</p>
        </div>

        <div class="card">
            <h3>Cocok untuk Hampers</h3>
            <p>Desain menarik untuk hadiah</p>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Siap Memesan?</h2>

    <a href="/produk">
        <button class="btn">Pesan Sekarang</button>
    </a>
</section>

<footer class="footer">
    <p>© 2026 NastarKu. All rights reserved.</p>
</footer>

@endsection