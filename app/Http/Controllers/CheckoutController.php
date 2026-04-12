<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (!$cart || count($cart) == 0) {
            return redirect('/produk');
        }

        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $order = Order::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'catatan' => $request->catatan,
            'total' => $total
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah']
            ]);
        }

        Mail::to('cobacobadulu148@gmail.com')->send(new OrderMail($order, $cart));

        session()->forget('cart');

        return redirect('/produk?status=success');
    }
}