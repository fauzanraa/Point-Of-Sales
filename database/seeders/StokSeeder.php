<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'user_id' => 3,
                'stok_jumlah' => 50,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 2,
                'user_id' => 3,
                'stok_jumlah' => 36,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 3,
                'user_id' => 3,
                'stok_jumlah' => 100,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 4,
                'user_id' => 3,
                'stok_jumlah' => 25,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 5,
                'user_id' => 3,
                'stok_jumlah' => 37,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 6,
                'user_id' => 3,
                'stok_jumlah' => 44,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 7,
                'user_id' => 3,
                'stok_jumlah' => 55,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 8,
                'user_id' => 3,
                'stok_jumlah' => 70,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 9,
                'user_id' => 3,
                'stok_jumlah' => 38,
                'stok_tanggal' => now(),
            ],
            [
                'barang_id' => 10,
                'user_id' => 3,
                'stok_jumlah' => 48,
                'stok_tanggal' => now(),
            ],
        ];

        DB::table('t_stok')->insert($data);
    }
}
