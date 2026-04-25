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

        $this->notifAdmin($order);

        session()->forget('cart');

        return redirect('/produk?status=success');
    }

    private function formatNomor($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (substr($nomor, 0, 1) == '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        return $nomor;
    }

    private function notifAdmin($order)
    {
        $nomor = $this->formatNomor(env('ADMIN_WA'));

        $pesan = "ORDER BARU MASUK\n\n";

        $pesan .= "Nama: {$order->nama}\n";
        $pesan .= "No HP: {$order->telepon}\n";
        $pesan .= "Alamat: {$order->alamat}\n\n";

        $pesan .= "Detail Pesanan:\n";

        foreach ($order->items as $item) {
            $pesan .= "- {$item->nama} x{$item->jumlah}\n";
        }

        $pesan .= "\nTotal: Rp " . number_format($order->total);

        $pesan .= "\n\nCek di: " . url('/admin/pesanan');

        $this->kirimWhatsApp($nomor, $pesan);
    }

    private function kirimWhatsApp($nomor, $pesan)
    {
        $token = env('FONNTE_TOKEN');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $nomor,
                'message' => $pesan,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        curl_exec($curl);
        curl_close($curl);
    }
}