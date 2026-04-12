@extends('layout.app')

@section('title', 'Produk')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/produk.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/produk.js') }}"></script>
@endsection

@section('content')

@if(request('status') == 'success')

<div id="toast-success" style="
    position:fixed;
    top:100px;
    right:20px;
    background:#ffffff;
    border-left:5px solid #28a745;
    padding:16px 20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    display:flex;
    align-items:center;
    gap:12px;
    z-index:9999;
    opacity:0;
    transform:translateX(50px);
    transition:all 0.4s ease;
">

    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
         stroke="#28a745" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M9 12l2 2 4-4"></path>
    </svg>

    <div>
        <div style="font-weight:600;">Berhasil</div>
        <div style="font-size:13px; color:#555;">
            Pesanan berhasil dibuat
        </div>
    </div>

</div>

<script>
    const toast = document.getElementById('toast-success');

    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }, 100);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
    }, 3000);
</script>

@endif

<section class="produk-page">
    <h1>Produk Kami</h1>

    <div class="grid">
        @foreach($produks as $item)
        <div class="card">
            <img src="{{ asset('assets/img/' . ($item->gambar ?? 'default.png')) }}">
            
            <h3>{{ $item->nama }}</h3>

            <p>250gr</p>

            <p class="harga">Rp {{ number_format($item->harga) }}</p>

            <div class="cart-control" data-id="{{ $item->id }}">
                <button class="btn tambah-btn">Tambah</button>
            </div>
        </div>
        @endforeach
    </div>

    <a href="/cart" class="btn-pesan">Pesan</a>

</section>

<script>
    const cartData = @json($cart);
</script>

@endsection