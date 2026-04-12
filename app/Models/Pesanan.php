<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
