<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\MemberModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Member',
            'list' => ['Home','User']
        ];

        $page = (object) [
            'title' => 'Daftar Member yang terdaftar dalam sistem'
        ];

        $activeMenu = 'member';

        return view('member.index',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) 
    { 
         $member = MemberModel::all();
    
        // if($request->level_id){
        //     $users->where('level_id',$request->level_id);
        // }
        return DataTables::of($member) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($member) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('member/' . $member->member_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/member/' . $member->member_id . '/edit').'"class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/member/'.$member->member_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Member',
            'list' => ['Home', 'Member', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah member baru'
        ];

        $activeMenu = 'member';

        return view('member.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            // level_kode harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'nama' => 'required|string|min:3',
            'ttl'     => 'required', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'alamat'     => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);

        MemberModel::create([
            'nama' => $request->nama_member,
            'ttl'     => $request->ttl_member,
            'alamat'     => $request->alamat_member,
        ]);

        return redirect('/member')->with('success', 'Data level berhasil disimpan');
    }

    public function show(string $id)
    {
        $member = MemberModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Member',
            'list' => ['Home', 'Member', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Member'    
        ];

        $activeMenu = 'user';

        return view('member.show', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'member' => $member,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id) {
        $member = MemberModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Member',
            'list'  => ['Home', 'Member', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Member'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('member.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'member' => $member, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'nama_member'     => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'ttl_member'      => 'required',          // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'alamat_member'   => 'required|string|min:5'         // alamat harus diisi dan berupa angka
        ]);

        MemberModel::find($id)->update([
            'nama'     => $request->nama_member,
            'ttl'      => $request->ttl_member,
            'alamat' => $request->alamat_member
        ]);

        return redirect('/member')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id) {
        $check = MemberModel::find($id);
        if (!$check) {      // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/member')->with('error', 'Data member tidak ditemukan');
        }

        try {
            MemberModel::destroy($id);   // Hapus data level

            return redirect('/member')->with('success', 'Data member berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/member')->with('error', 'Data member gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}


