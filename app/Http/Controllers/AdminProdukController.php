<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class AdminProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::latest()->get();
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'required|image'
        ]);

        $gambar = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('assets/img'), $gambar);

        Produk::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'gambar' => $gambar
        ]);

        return redirect('/admin/produk');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('gambar')) {
            $gambar = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('assets/img'), $gambar);
            $data['gambar'] = $gambar;
        }

        $produk->update($data);

        return redirect('/admin/produk');
    }

    public function delete($id)
    {
        Produk::findOrFail($id)->delete();
        return back();
    }
}