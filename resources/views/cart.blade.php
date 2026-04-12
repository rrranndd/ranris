@extends('layout.app')

@section('title', 'Keranjang')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endsection

@section('content')

<section class="cart-page">

    <a href="/produk" class="btn-kembali">← Kembali ke Produk</a>

    <h2>Keranjang Belanja</h2>

    @if(session('cart') && count($cart) > 0)

        <div class="cart-container">

            <table>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>

                @php $total = 0; @endphp

                @foreach($cart as $item)
                    @php 
                        $subtotal = $item['harga'] * $item['jumlah']; 
                        $total += $subtotal; 
                    @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>Rp {{ number_format($item['harga']) }}</td>
                        <td class="qty-cell">
                            <div class="qty-control" data-id="{{ $item['id'] }}">
                                <button class="minus">-</button>
                                <span class="jumlah">{{ $item['jumlah'] }}</span>
                                <button class="plus">+</button>
                            </div>
                        </td>
                        <td>Rp {{ number_format($subtotal) }}</td>
                    </tr>
                @endforeach
            </table>

        </div>

        <div class="cart-footer">
            <h2 class="total">
                Total: Rp <span id="total-harga">{{ number_format($total) }}</span>
            </h2>
            <a href="/checkout" class="btn-checkout">Checkout</a>
        </div>
    @else
        <p class="empty">Keranjang kosong</p>
    @endif

</section>

@endsection