<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ url('css/admin.css') }}">
</head>

<body>

<div class="container">

    <div class="sidebar">
        <h2>RANRIS</h2>
        <a href="/admin">Dashboard</a>
        <a href="/admin/pesanan">
            Kelola Pesanan 
            <span class="badge">{{ $totalPending ?? '' }}</span>
        </a>
        <a href="/admin/produk">Kelola Produk</a>
        <a href="/admin/laporan">Laporan</a>
    </div>

    <div class="main">
        @yield('content')
    </div>

</div>

</body>
</html>