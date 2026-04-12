<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $produk = Produk::find($request->id);

        $cart = session()->get('cart', []);

        if($request->jumlah <= 0) {
            unset($cart[$produk->id]);
        } else {
            $cart[$produk->id] = [
                "id" => $produk->id, // TAMBAHAN
                "nama" => $produk->nama,
                "harga" => $produk->harga,
                "gambar" => $produk->gambar,
                "jumlah" => $request->jumlah
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart')); // FIX
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }
}