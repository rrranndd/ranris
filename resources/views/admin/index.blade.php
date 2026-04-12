@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('content')

<h1>Dashboard</h1>

<div class="cards">

    <div class="card">
        <h3>Total Pesanan Hari Ini</h3>
        <p>{{ $totalOrderHariIni }}</p>
        <small>Order masuk hari ini</small>
    </div>

    <div class="card">
        <h3>Total Pendapatan Hari Ini</h3>
        <p>Rp {{ number_format($totalPendapatan) }}</p>
        <small>Pemasukan hari ini</small>
    </div>

</div>

<div class="section">

    <div class="cards">

        <div class="card">
            <h3>Rata-rata Order</h3>
            <p>
                Rp {{ $totalOrderHariIni > 0 
                    ? number_format($totalPendapatan / $totalOrderHariIni) 
                    : 0 }}
            </p>
            <small>Per transaksi</small>
        </div>

        <div class="card">
            <h3>Status Hari Ini</h3>
            <p>{{ $totalOrderHariIni > 0 ? 'Aktif ' : 'Sepi ' }}</p>
            <small>Kondisi penjualan</small>
        </div>

    </div>

</div>

<!-- LAYOUT 2 KOLOM -->
<div class="section" style="display:grid; grid-template-columns: 2fr 1fr; gap:20px;">

    <!-- RECENT ORDERS -->
    <div class="card">

        <h3>Pesanan Terbaru</h3>

        <table class="table">
            <tr>
                <th>Nama</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            @foreach($recentOrders as $o)
            <tr>
                <td>{{ $o->nama }}</td>
                <td>Rp {{ number_format($o->total) }}</td>
                <td>
                    @if($o->status == 'selesai')
                        <span class="status selesai">DITERIMA</span>
                    @elseif($o->status == 'pending')
                        <span class="status pending">PENDING</span>
                    @else
                        <span class="status ditolak">DITOLAK</span>
                    @endif
                </td>
            </tr>
            @endforeach

        </table>

    </div>

    <!-- PRODUK TERLARIS -->
    <div class="card">

        <h3>Produk Terlaris</h3>

        @foreach($produkTerlaris as $p)
        <div style="margin-bottom:10px;">

            <strong>{{ $p->nama }}</strong>
            <div style="font-size:13px; color:#777;">
                {{ $p->total_terjual }} terjual
            </div>

            <!-- BAR -->
            <div style="background:#eee; height:6px; border-radius:5px; margin-top:5px;">
                <div style="
                    width: {{ $p->total_terjual * 20 }}%;
                    background:#c89b3c;
                    height:6px;
                    border-radius:5px;
                "></div>
            </div>

        </div>
        @endforeach

    </div>

</div>

@endsection