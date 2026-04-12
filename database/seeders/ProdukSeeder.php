<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::insert([
            ['nama'=>'Nastar','harga'=>50000,'kategori'=>'satuan'],
            ['nama'=>'Kue Salju','harga'=>45000,'kategori'=>'satuan'],
            ['nama'=>'Kue Kacang','harga'=>40000,'kategori'=>'satuan'],
            ['nama'=>'Kastengel','harga'=>60000,'kategori'=>'satuan'],
            ['nama'=>'Thumbprint Cookies','harga'=>55000,'kategori'=>'satuan'],
            ['nama'=>'Strawberry Cookies','harga'=>50000,'kategori'=>'satuan'],
            ['nama'=>'Paket A','harga'=>120000,'kategori'=>'paket'],
            ['nama'=>'Paket B','harga'=>200000,'kategori'=>'paket'],
        ]);
    }
}
