<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\UserModel;

class DashChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $user = UserModel::all();
        $dataKasir = [
            $user->where('level_id','3')->count(),
        ];
        
        $data= [
            $user->where('gender', 'laki-laki')->count(),
            $user->where('gender', 'perempuan')->count(),
        ];

        $dataLaki = [
        ];

        return $this->chart->barChart()
            ->setTitle('Jumlah Staff Kasir')
            ->setSubtitle('Perempuan dan Laki-laki')
            ->addData([$data])
            ->setXAxis(['Laki-laki', 'Perempuan']);
    }
}
