<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Models\StokModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home','Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';

        return view('barang.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) 
    { 
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'image', 'harga_beli', 'harga_jual') ->with('kategori'); 

        return DataTables::of($barang) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($barang) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $kategori = KategoriModel::all();

        $activeMenu = 'barang';

        return view('barang.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg',
            'kategori_id' => 'required|integer',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric|gt:harga_beli',
            'stok' => 'required|numeric'
        ]);

        $image = $request->file('image');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('imgBarang'), $imageName);

        $dateNow = Carbon::now()->format('dmY');
        $barangKategori = DB::select("
                            SELECT COUNT(barang_kode) as total FROM `m_barang`;
                            ");
        $barang = collect($barangKategori);
        $totalBarang = $barang->pluck('total')->implode(',') + 1;

        $barangKode = 'BRG' . ($totalBarang < 10 ? ('0' . $totalBarang) : $totalBarang) . $dateNow;

        $barang = BarangModel::create([
            'barang_kode' => $barangKode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'image' => $imageName,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        StokModel::create([
            'barang_id' => $barang->barang_id,
            'user_id' => Auth::user()->user_id,
            'stok_tanggal' => now(),
            'stok_jumlah' => $request->stok,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => UserModel::all(),
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);

        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang',
        ];

        $activeMenu = 'barang';

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'user' => UserModel::all(),
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric|gt:harga_beli',
            'image' => 'nullable|image|mimes:png,jpg',
        ]);

        $oldBarang = BarangModel::find($id);

        if ($oldBarang->kategori_id != $request->kategori_id) {
            $kategori = KategoriModel::find($request->kategori_id);
            $dateNow = Carbon::now()->format('dmY');
            $barangKategori = (BarangModel::where('kategori_id', $request->kategori_id)->where('barang_id', '<>', $request->id)->count()) + 1;

            $barangKode = $kategori->kategori_kode . ($barangKategori < 10 ? ('0' . $barangKategori) : $barangKategori) . '/' . $dateNow;
        } else {
            $barangKode = $oldBarang->barang_kode;
        }

        if ($request->image) {
            $barangName = $request->image->hashName();
            $imgFile = $request->image;


            $imgFile->storeAs('/public/barangImg/', $barangName);

            $oldBarang->update([
                'barang_kode' => $barangKode,
                'barang_nama' => $request->barang_nama,
                'kategori_id' => $request->kategori_id,
                'image' => $barangName,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);
        } else {
            $oldBarang->update([
                'barang_kode' => $barangKode,
                'barang_nama' => $request->barang_nama,
                'kategori_id' => $request->kategori_id,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
            ]);
        }


        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);

        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/barang')->with('/error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
