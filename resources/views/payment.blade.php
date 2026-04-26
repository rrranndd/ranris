@extends('layout.app')

@section('title', 'Pembayaran')

@section('content')

<section style="padding: 50px; text-align: center;">

    <h2>Pembayaran Pesanan</h2>

    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Nama:</strong> {{ $order->nama }}</p>
    <p><strong>Total:</strong> Rp {{ number_format($order->total) }}</p>

    <br>

    <button id="pay-button" style="
        padding: 12px 25px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    ">
        Bayar Sekarang
    </button>

</section>

{{-- 🔥 MIDTRANS SCRIPT --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result){
            alert("Pembayaran berhasil!");

            // nanti kita update DB di step berikutnya
            window.location.href = "/produk?status=success";
        },

        onPending: function(result){
            alert("Menunggu pembayaran...");
        },

        onError: function(result){
            alert("Pembayaran gagal!");
        }

    });
};
</script>

@endsection