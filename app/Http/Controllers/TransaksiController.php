<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\MemberModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home','Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar Transaksi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        return view('transaksi.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request) 
    { 
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_tanggal', 'penjualan_kode')->with('user', 'penjualanDetail'); 
    
        return DataTables::of($penjualan) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($penjualan) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function show(string $id)
    {
        $penjualan = PenjualanModel::with('penjualanDetail')->with('user')->find($id); 

        // dd($penjualan);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('transaksi.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $penjualan = PenjualanModel::with('penjualanDetail')->with('user'); 
        $barang = BarangModel::all();
        $user = UserModel::where('username', Auth::user()->username)->first();

        // dd($penjualan);

        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('transaksi.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'barang_nama' => 'required|array',
            'pembeli' => 'required|string|min:3',
            'jumlah' => 'required|array'
        ]);

        $diskon = 0;
        if (MemberModel::where('nama', $request->pembeli)->exists()) {
            $diskon = 0.1; // 10% diskon
        }

        $barang = BarangModel::where('barang_nama', $request->barang_nama)->first();
        $date = Carbon::now()->format('dmY');
        $dateNow = Carbon::now()->format('Y-m-d');
        $listPenjualan = DB::select("
                            SELECT COUNT(barang_kode) as total FROM `m_barang`;
                            ");
        $penjualan = collect($listPenjualan);
        $totalPenjualan = $penjualan->pluck('total')->implode(',') + 1;

        $penjualanKode = 'P' . ($totalPenjualan < 10 ? ('0' . $totalPenjualan) : $totalPenjualan) . $date;

        $penjualan = PenjualanModel::create([
            'user_id' => $request->id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $penjualanKode,
            'penjualan_tanggal' => $dateNow,
        ]);

        $dataBarang = $request->barang_nama;
        $dataJumlah = $request->jumlah;
        for($i = 0; $i < count($dataBarang); $i++){
            $barang = BarangModel::find($dataBarang[$i]);
            $harga = $request->input('total_harga') * ($diskon);
            $hargaSetelahDiskon = $request->input('total_harga') - ($harga);
            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang->barang_id,
                'harga' => $hargaSetelahDiskon,
                'jumlah' => $dataJumlah[$i],
            ]);
            $stok = StokModel::where('barang_id', $barang->barang_id)->first();

            if($stok->stok_jumlah < $dataJumlah[$i]){
                return back()->with('error', 'Stok barang tidak cukup');
            } else {
                $stok->decrement('stok_jumlah', $dataJumlah[$i]);
            }

        }

        return redirect('/penjualan')->with('success', 'Data transaksi berhasil disimpan');
    }
}
