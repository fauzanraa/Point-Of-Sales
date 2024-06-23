<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_kode' => 'BRG01',
                'barang_nama' => 'Palu',
                'kategori_id' => '4',
                'harga_beli' => 15000,
                'harga_jual' => 25000,
            ],
            [
                'barang_kode' => 'BRG02',
                'barang_nama' => 'Tang',
                'kategori_id' => '4',
                'harga_beli' => 10000,
                'harga_jual' => 13000,
            ],
            [
                'barang_kode' => 'BRG03',
                'barang_nama' => 'Paku',
                'kategori_id' => '1',
                'harga_beli' => 25,
                'harga_jual' => 50,
            ],
            [
                'barang_kode' => 'BRG04',
                'barang_nama' => 'Meteran',
                'kategori_id' => '2',
                'harga_beli' => 3000,
                'harga_jual' => 6000,
            ],
            [
                'barang_kode' => 'BRG05',
                'barang_nama' => 'Gergaji',
                'kategori_id' => '5',
                'harga_beli' => 15000,
                'harga_jual' => 20000,
            ],
            [
                'barang_kode' => 'BRG06',
                'barang_nama' => 'Kawat',
                'kategori_id' => '1',
                'harga_beli' => 25,
                'harga_jual' => 50,
            ],
            [
                'barang_kode' => 'BRG07',
                'barang_nama' => 'Pisau',
                'kategori_id' => '5',
                'harga_beli' => 3000,
                'harga_jual' => 7000,
            ],
            [
                'barang_kode' => 'BRG08',
                'barang_nama' => 'Kemoceng',
                'kategori_id' => '3',
                'harga_beli' => 4000,
                'harga_jual' => 8000,
            ],
            [
                'barang_kode' => 'BRG09',
                'barang_nama' => 'Ampere Meter',
                'kategori_id' => '2',
                'harga_beli' => 15000,
                'harga_jual' => 30000,
            ],
            [
                'barang_kode' => 'BRG10',
                'barang_nama' => 'Sapu',
                'kategori_id' => '3',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
