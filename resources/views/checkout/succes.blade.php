@extends('layout.app')

@section('title', 'Pesanan Berhasil')

@section('content')

@if(session('success'))
<script>
    alert('Terima kasih, pesanan berhasil dibuat.');
</script>
@endif

<div style="display:flex; justify-content:center; align-items:center; height:80vh; background:#f5f5f5;">

    <div style="
        background:white;
        padding:40px;
        border-radius:16px;
        box-shadow:0 10px 25px rgba(0,0,0,0.08);
        text-align:center;
        max-width:420px;
        width:100%;
    ">

        <svg width="60" height="60" viewBox="0 0 24 24" fill="none"
             stroke="#c89b3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="margin-bottom:15px;">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M9 12l2 2 4-4"></path>
        </svg>

        <h1 style="color:#c89b3c; margin-bottom:10px;">
            Pesanan Berhasil
        </h1>

        <p style="margin-bottom:5px;">
            Pesanan Anda telah kami terima.
        </p>

        <p style="font-size:14px; color:#666;">
            Tim kami akan segera memproses pesanan Anda.
        </p>

        <a href="/produk" style="
            display:inline-block;
            margin-top:25px;
            padding:12px 22px;
            background:#c89b3c;
            color:white;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        "
        onmouseover="this.style.background='#a07c35'"
        onmouseout="this.style.background='#c89b3c'"
        >
            Kembali ke Produk
        </a>

    </div>

</div>

@endsection