<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable) 
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home','Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';
        return $dataTable->render('kategori.index' ,[
            'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request) 
    { 
        $kategori = KategoriModel::all(); 

        return DataTables::of($kategori) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">' 
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
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => UserModel::all()]);
    }

    public function store(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' =>$request->kodeKategori,
            'kategori_name' =>$request->namaKategori,
        ]);
        return redirect('/kategori');
    }

    public function edit($id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Member',
            'list'  => ['Home', 'Member', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Member'
        ];

        $activeMenu = 'kategori'; 
        
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);

    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_kategori' => 'required',
            'nama_kategori' => 'required',
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kode_kategori,
            'kategori_name' => $request->nama_kategori
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);

        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/kategori')->with('/error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }
}
