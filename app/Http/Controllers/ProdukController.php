<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        $cart = session()->get('cart', []);

        return view('produk', compact('produks', 'cart'));
    }
}