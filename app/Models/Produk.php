<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    protected $fillable = ['nama', 'harga', 'gambar'];
}
