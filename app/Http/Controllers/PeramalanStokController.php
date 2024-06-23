<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;

class PeramalanStokController extends Controller
{
    public function peramalan(){
        $stockData = StokModel::orderBy('date')->pluck('stok_jumlah', 'stok_tanggal');

        // Lakukan prediksi stok
        $alpha = 0.2; // Koefisien smoothing
        $forecastData = $this->exponentialSmoothing($stockData, $alpha, 5);

        // Kirim hasil prediksi sebagai respons
        return view('welcome', ['forecastHasil' => $forecastData]);
        // return response()->json(['forecast' => $forecastData]);
    }

    private function exponentialSmoothing($data, $alpha, $periods)
    {
        $result = [];
        $values = array_values($data);
        $count = count($values);

        // Inisialisasi nilai awal
        $result[] = $values[0];

        // Proses prediksi
        for ($i = 1; $i <= $count + $periods - 1; $i++) {
            if ($i < $count) {
                $result[] = $alpha * $values[$i] + (1 - $alpha) * $result[$i - 1];
            } else {
                // Prediksi untuk periode selanjutnya
                $result[] = $alpha * $result[$i - 1] + (1 - $alpha) * $result[$i - 2];
            }
        }

        // Mengembalikan hasil prediksi
        return array_slice($result, $count);
    }
}
