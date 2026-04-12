<h2>Pesanan Baru</h2>

<p><strong>Nama:</strong> {{ $order->nama }}</p>
<p><strong>Telepon:</strong> {{ $order->telepon }}</p>

<hr>

<h3>Detail Pesanan:</h3>

<ul>
@foreach($items as $item)
    <li>
        {{ $item['nama'] }} 
        ({{ $item['jumlah'] }}x) 
        - Rp {{ number_format($item['harga']) }}
    </li>
@endforeach
</ul>

<hr>

<h3>Total: Rp {{ number_format($order->total) }}</h3>