<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 2px;
        }

        .header p {
            margin: 5px 0;
            color: #777;
        }

        .info {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
        }

        .info-table td {
            padding: 5px 0;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 15px 0;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items th {
            background: #f5f5f5;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table.items td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        .total-box {
            margin-top: 20px;
            text-align: right;
        }

        .total-box h2 {
            margin: 0;
            color: #c49a3a;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>INVOICE</h1>
        <p>RANRIS STORE</p>
    </div>

    <!-- INFO -->
    <div class="info">
        <table class="info-table">
            <tr>
                <td><strong>ID Pesanan</strong></td>
                <td>: #{{ $order->id }}</td>

                <td><strong>Tanggal</strong></td>
                <td>: {{ $order->created_at->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $order->nama }}</td>

                <td><strong>No HP</strong></td>
                <td>: {{ $order->telepon }}</td>
            </tr>

            <tr>
                <td><strong>Alamat</strong></td>
                <td colspan="3">: {{ $order->alamat }}</td>
            </tr>
        </table>
    </div>

    <div class="divider"></div>

    <!-- TABLE PRODUK -->
    <table class="items">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-right">Qty</th>
            </tr>
        </thead>

        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->nama }}</td>
                <td class="text-right">x{{ $item->jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total-box">
        <p>Total Pembayaran</p>
        <h2>Rp {{ number_format($order->total) }}</h2>
    </div>

    <div class="divider"></div>

    <!-- FOOTER -->
    <div class="footer">
        Terima kasih telah berbelanja di RANRIS STORE
    </div>

</div>

</body>
</html>