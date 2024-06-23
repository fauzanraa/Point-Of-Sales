<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            // 10 penjualan data
            [
                'user_id' => 3,
                'pembeli' => 'Rusli',
                'penjualan_kode' => 'P001',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Asep',
                'penjualan_kode' => 'P002',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Morgan',
                'penjualan_kode' => 'P003',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Isna',
                'penjualan_kode' => 'P004',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Hari',
                'penjualan_kode' => 'P005',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Sumarni',
                'penjualan_kode' => 'P006',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Resti',
                'penjualan_kode' => 'P007',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Bagus',
                'penjualan_kode' => 'P008',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Bilqis',
                'penjualan_kode' => 'P009',
                'penjualan_tanggal' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Ratna',
                'penjualan_kode' => 'PK010',
                'penjualan_tanggal' => now(),
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
