<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background:#f5f5f5; font-family:Arial, sans-serif;">

<div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

    <div style="background:#c89b3c; padding:20px; text-align:center; color:white;">
        <h1 style="margin:0;">NastarKu</h1>
        <p style="margin:5px 0 0;">Pesanan Baru Masuk</p>
    </div>

    <div style="padding:20px;">

        <h3 style="margin-bottom:10px;">Informasi Pelanggan</h3>

        <p><strong>Nama:</strong> {{ $order->nama }}</p>
        <p><strong>No HP:</strong> {{ $order->telepon }}</p>
        <p><strong>Alamat:</strong> {{ $order->alamat ?? '-' }}</p>
        <p><strong>Catatan:</strong> {{ $order->catatan ?? '-' }}</p>

        <hr style="margin:20px 0;">

        <h3>Detail Pesanan</h3>

        <table width="100%" style="border-collapse:collapse;">
            @foreach($items as $item)
            <tr>
                <td style="padding:8px 0;">
                    {{ $item['nama'] }} ({{ $item['jumlah'] }}x)
                </td>
                <td style="text-align:right;">
                    Rp {{ number_format($item['harga'] * $item['jumlah']) }}
                </td>
            </tr>
            @endforeach
        </table>

        <hr style="margin:20px 0;">

        <h2 style="text-align:right; color:#c89b3c;">
            Total: Rp {{ number_format($order->total) }}
        </h2>

    </div>

    <div style="background:#f0f0f0; padding:15px; text-align:center; font-size:12px;">
        <p style="margin:0;">Terima kasih telah menggunakan NastarKu</p>
    </div>

</div>

</body>
</html>