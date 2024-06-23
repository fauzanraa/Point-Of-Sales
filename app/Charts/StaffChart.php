<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\UserModel;

class StaffChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $user = UserModel::all();
        $dataKasir = [
            $user->where('level_id','3')->count(),
        ];
        
        $dataPerempuan = [
            $user->where('gender', 'perempuan')->count(),
        ];

        $dataLaki = [
            $user->where('gender', 'laki-laki')->count(),
        ];

        return $this->chart->pieChart()
            ->setTitle('Daftar Staff Kasir')
            ->setSubtitle('Kasir Laki-laki dan Perempuan')
            ->addData([$dataKasir])
            ->setLabels([$dataLaki, $dataPerempuan]);
    }
}
