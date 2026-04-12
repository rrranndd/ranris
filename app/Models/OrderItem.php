<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'nama',
        'harga',
        'jumlah'
    ];
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
