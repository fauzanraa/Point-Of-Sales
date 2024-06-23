<?php

namespace App\Http\Controllers;

use App\Charts\PeramalanChart;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class WelcomeController extends Controller
{
    public function index(PeramalanChart $chart) {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $member = DB::select("
            SELECT COUNT(username_verified) as notif FROM `m_user` WHERE username_verified LIKE 'Menunggu'
        ");
        $notif = collect($member);

        $activeMenu = 'dashboard';

        return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'chart' => $chart->build(), 'notif' => $notif] );
    }

    public function list() 
    { 
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id', 'username_verified') ->with('level')->where('level_id', '3'); 

        return DataTables::of($users) 
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
                if($user->username_verified == 'Menunggu'){
                    $btn  = '<a href="'.url('/user/' . $user->user_id. '/konfirmasi').'" class="btn btn-success btn-sm">Konfirmasi</a> '; 
                    return $btn; 
                } if($user->username_verified == 'Dikonfirmasi'){
                    $btn  = '<a href="'.url('/user/' . $user->user_id. '/konfirmasi').'" class="btn btn-success btn-sm disabled">Konfirmasi</a> '; 
                    return $btn;
                }
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function user(){
        $data = Usermodel::where('nama', Auth::user()->nama)->first();

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Detail user'    
        ];

        $activeMenu = 'dashboard';

        return view('welcomeUser', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'activeMenu' => $activeMenu,
            'data' => $data
        ]);
    }
}
