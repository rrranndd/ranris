@extends('layout.admin')

@section('content')

<h1>Laporan Penjualan</h1>

<!-- FILTER -->
<div class="laporan-header">

    <form method="GET" class="filter-bar">
        <input type="date" name="dari" value="{{ $dari }}" onchange="this.form.submit()">
        <input type="date" name="sampai" value="{{ $sampai }}" onchange="this.form.submit()">
    </form>

    <button onclick="window.print()" class="btn-print">Print</button>

</div>

<!-- KPI -->
<div class="cards">

    <div class="card">
        <h4>Total Pendapatan</h4>
        <p>Rp {{ number_format($totalPendapatan) }}</p>
    </div>

    <div class="card">
        <h4>Total Pesanan</h4>
        <p>{{ $totalPesanan }}</p>
    </div>

    <div class="card">
        <h4>Rata-rata</h4>
        <p>Rp {{ $totalPesanan ? number_format($totalPendapatan / $totalPesanan) : 0 }}</p>
    </div>

    <div class="card">
        <h4>Hari Terbaik</h4>
        <p>
            @if($maxPendapatan)
                Rp {{ number_format($maxPendapatan->total) }}<br>
                <small>{{ $maxPendapatan->tanggal }}</small>
            @else
                -
            @endif
        </p>
    </div>

    <div class="card">
        <h4>Produk Terlaris #1</h4>
        <p>
            {{ $topProduk->nama ?? '-' }}<br>
            <small>{{ $topProduk->total_terjual ?? 0 }} terjual</small>
        </p>
    </div>

</div>

<!-- GRAFIK -->
<div class="section no-print">
    <h3>Trend Penjualan</h3>
    <canvas id="chartPenjualan"></canvas>
</div>

<!-- TOP PRODUK -->
<div class="section no-print">
    <h3>Top Produk</h3>

    @foreach($produkTerlaris->take(5) as $i => $p)
    <div class="produk-bar">
        <strong>#{{ $i+1 }} {{ $p->nama }}</strong>

        <div class="bar">
            <div style="width: {{ $p->total_terjual * 10 }}%"></div>
        </div>

        <small>{{ $p->total_terjual }} terjual</small>
    </div>
    @endforeach

</div>

<!-- TABEL -->
<h3>Laporan Detail</h3>

<table class="table">

    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($orders as $o)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $o->nama }}</td>
            <td>{{ $o->telepon }}</td>
            <td>{{ $o->created_at->format('d-m-Y') }}</td>

            <td>
                @foreach($o->items as $item)
                    • {{ $item->nama }} (x{{ $item->jumlah }})<br>
                @endforeach
            </td>

            <td>Rp {{ number_format($o->total) }}</td>

            <td>
                <span class="badge {{ $o->status }}">
                    {{ strtoupper($o->status == 'selesai' ? 'DITERIMA' : $o->status) }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

<div class="total-print">
    Total: Rp {{ number_format($totalPendapatan) }}
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const data = @json($grafik);

new Chart(document.getElementById('chartPenjualan'), {
    type: 'line',
    data: {
        labels: data.map(i => i.tanggal),
        datasets: [{
            label: 'Pendapatan',
            data: data.map(i => i.total),
            tension: 0.3
        }]
    },
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: ctx => 'Rp ' + ctx.raw.toLocaleString()
                }
            }
        }
    }
});
</script>

@endsection