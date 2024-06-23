<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            [
                'penjualan_id' => 1,
                'barang_id' => 1,
                'jumlah' => 4,
                'harga' => 10000,
            ],
            [
                'penjualan_id' => 1,
                'barang_id' => 2,
                'jumlah' => 3,
                'harga' => 39000,
            ],
            [
                'penjualan_id' => 1,
                'barang_id' => 3,
                'jumlah' => 100,
                'harga' => 50000,
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 4,
                'jumlah' => 6,
                'harga' => 36000,
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 5,
                'jumlah' => 3,
                'harga' => 60000,
            ],
            [
                'penjualan_id' => 2,
                'barang_id' => 6,
                'jumlah' => 100,
                'harga' => 50000,
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 7,
                'jumlah' => 5,
                'harga' => 35000,
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 8,
                'jumlah' => 2,
                'harga' => 16000,
            ],
            [
                'penjualan_id' => 3,
                'barang_id' => 9,
                'jumlah' => 2,
                'harga' => 60000,
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 10,
                'jumlah' => 5,
                'harga' => 125000,
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 1,
                'jumlah' => 3,
                'harga' => 50000,
            ],
            [
                'penjualan_id' => 4,
                'barang_id' => 2,
                'jumlah' => 1,
                'harga' => 13000,
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 3,
                'jumlah' => 20,
                'harga' => 1000,
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 4,
                'jumlah' => 4,
                'harga' => 24000,
            ],
            [
                'penjualan_id' => 5,
                'barang_id' => 5,
                'jumlah' => 3,
                'harga' => 60000,
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 6,
                'jumlah' => 20,
                'harga' => 1000,
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 7,
                'jumlah' => 4,
                'harga' => 28000,
            ],
            [
                'penjualan_id' => 6,
                'barang_id' => 8,
                'jumlah' => 5,
                'harga' => 40000,
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 9,
                'jumlah' => 1,
                'harga' => 30000,
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 10,
                'jumlah' => 2,
                'harga' => 50000,
            ],
            [
                'penjualan_id' => 7,
                'barang_id' => 1,
                'jumlah' => 3,
                'harga' => 75000,
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 2,
                'jumlah' => 5,
                'harga' => 65000,
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 3,
                'jumlah' => 30,
                'harga' => 1500,
            ],
            [
                'penjualan_id' => 8,
                'barang_id' => 4,
                'jumlah' => 10,
                'harga' => 60000,
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 5,
                'jumlah' => 2,
                'harga' => 40000,
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 6,
                'jumlah' => 50,
                'harga' => 2500,
            ],
            [
                'penjualan_id' => 9,
                'barang_id' => 7,
                'jumlah' => 2,
                'harga' => 14000,
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 8,
                'jumlah' => 4,
                'harga' => 36000,
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 9,
                'jumlah' => 30,
                'harga' => 90000,
            ],
            [
                'penjualan_id' => 10,
                'barang_id' => 7,
                'jumlah' => 2,
                'harga' => 50000,
            ],
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}
