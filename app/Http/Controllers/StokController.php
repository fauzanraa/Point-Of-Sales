<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home','Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';

        return view('stok.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    
    public function list(Request $request) 
    { 
        $stok = StokModel::select('stok_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah') ->with('barang', 'user'); 
    
        return DataTables::of($stok) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($stok) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function show(string $id)
    {
        $stok = stokModel::with('barang')->with('user')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Stok',
            'list' => ['Home', 'Stok', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok';

        return view('stok.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => UserModel::all(),
            'stok' => $stok,
            'activeMenu' => $activeMenu
        ]);
    }

     public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah stok baru'
        ];

        $barang = BarangModel::all();
        $user = UserModel::all();
        $activeMenu = 'stok';

        return view('stok.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'user' => userModel::all(),
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'stok_jumlah' => 'required|numeric',
        ]);

        stokModel::find($request->barang_id)->increment('stok_jumlah', $request->stok_jumlah);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    public function edit(string $id)
    {
        $stok = stokModel::with('barang')->with('user')->find($id);

        $barang = BarangModel::all();
        $user = UserModel::all();
        $tanggal = Carbon::now()->format('Y-m-d');

        $breadcrumb = (object) [
            'title' => 'Edit stok',
            'list' => ['Home', 'stok', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit stok',
        ];

        $activeMenu = 'stok';

        return view('stok.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => userModel::all(),
            'stok' => $stok,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu,
            'tanggal' => $tanggal
        ]);
    }

    public function update(Request $request, string $id)
    {

        // dd($request->all(), $id);
        $request->validate([
            'barang_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'stok_tanggal' => 'nullable|date',
            'stok_jumlah' => 'nullable|numeric',
        ]);

        StokModel::find($id)->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => Carbon::now(),
            'stok_jumlah' => $request->stok_jumlah,
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = StokModel::find($id);

        if (!$check) {
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StokModel::destroy($id);

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
