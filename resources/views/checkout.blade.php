@extends('layout.app')

@section('title', 'Checkout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')

<section class="checkout-page">

    <div class="checkout-wrapper">

        <div class="checkout-card">
            <h1>Checkout</h1>

            <form action="/checkout" method="POST">
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

                <button type="submit" class="btn-checkout">
                    Pesan Sekarang
                </button>
            </form>
        </div>

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
        </div>

    </div>

</section>

@endsection