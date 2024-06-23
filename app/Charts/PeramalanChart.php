<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class PeramalanChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $dataTransaksi = DB::select('
        SELECT detail.penjualan_id,
        SUM(detail.harga * detail.jumlah) AS total, 
        (penjualan.penjualan_tanggal) AS tanggal  
        FROM t_penjualan_detail AS detail  
        INNER JOIN t_penjualan AS penjualan
        ON detail.penjualan_id = penjualan.penjualan_id
        GROUP BY detail.penjualan_id');
        $dataTotalTransaksi = collect($dataTransaksi);

        // dd($dataTotalTransaksi);

        $dataStok = DB::select('
        SELECT stok_id,
        stok_jumlah,
        stok_tanggal
        FROM `t_stok`
        ');
        $dataTotalStok = collect($dataStok);

        // dd($dataTotalStok);

        return $this->chart->lineChart()
            ->setTitle('Detail Penjualan')
            ->setSubtitle('Total Penjualan')
            ->addData('Data Transaksi', $dataTotalTransaksi->pluck('total')->toArray())
            ->setXAxis($dataTotalTransaksi->pluck('tanggal')->toArray());
    }
}
