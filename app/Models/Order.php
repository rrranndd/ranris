<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'alamat',
        'catatan',
        'total'
    ];
    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
}
