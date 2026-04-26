@extends('layout.app')

@section('title', 'Checkout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')

<section class="checkout-page">

    <div class="checkout-wrapper">

        <!-- FORM KIRI -->
        <div class="checkout-card">
            <h1>Checkout</h1>

            <form id="checkout-form">
                @csrf

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="telepon" required>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Catatan (opsional)</label>
                    <textarea name="catatan" rows="2"></textarea>
                </div>

            </form>
        </div>

        <!-- RINGKASAN KANAN -->
        <div class="checkout-summary">
            <h2>Ringkasan Pesanan</h2>

            @php $total = 0; @endphp

            @foreach(session('cart') as $item)
                @php 
                    $subtotal = $item['harga'] * $item['jumlah']; 
                    $total += $subtotal; 
                @endphp

                <div class="summary-item">
                    <span>{{ $item['nama'] }} x{{ $item['jumlah'] }}</span>
                    <span>Rp {{ number_format($subtotal) }}</span>
                </div>
            @endforeach

            <hr>

            <div class="summary-total">
                <strong>Total</strong>
                <strong>Rp {{ number_format($total) }}</strong>
            </div>

            <!-- PEMBAYARAN -->
            <div style="margin-top:20px;">

                <h3>Pembayaran</h3>

                <select id="payment_method" style="width:100%; padding:10px; margin-top:10px;">
                    <option value="cod">COD (Bayar di Tempat)</option>
                    <option value="midtrans">Online (QRIS / E-Wallet / Bank)</option>
                </select>

                <button type="button" id="pay-button" style="
                    margin-top:15px;
                    width:100%;
                    padding:12px;
                    background:#28a745;
                    color:white;
                    border:none;
                    border-radius:5px;
                    cursor:pointer;
                    font-size:16px;
                ">
                    Bayar Sekarang
                </button>

            </div>

        </div>

    </div>

</section>

<!-- MIDTRANS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {

    let form = document.getElementById('checkout-form');

    // VALIDASI
    if (!form.nama.value || !form.telepon.value || !form.alamat.value) {
        alert("Harap lengkapi data terlebih dahulu");
        return;
    }

    let button = document.getElementById('pay-button');
    button.disabled = true;
    button.innerHTML = "Memproses...";

    let formData = new FormData(form);

    let metode = document.getElementById('payment_method').value;
    formData.set('payment_method', metode);

    fetch('/checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        // COD
        if (metode === 'cod') {
            window.location.href = "/produk?status=success";
            return;
        }

        // MIDTRANS
        snap.pay(data.snapToken, {
            onSuccess: function(){
                window.location.href = "/produk?status=success";
            },
            onPending: function(){
                alert("Menunggu pembayaran");
                button.disabled = false;
                button.innerHTML = "Bayar Sekarang";
            },
            onError: function(){
                alert("Pembayaran gagal");
                button.disabled = false;
                button.innerHTML = "Bayar Sekarang";
            }
        });

    })
    .catch(error => {
        console.error(error);
        alert("Terjadi kesalahan");
        button.disabled = false;
        button.innerHTML = "Bayar Sekarang";
    });

};
</script>

@endsection