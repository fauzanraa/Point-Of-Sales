<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        return view('register');
    }

    public function simpanRegistrasi(Request $request){
        $image = $request->file('file_foto');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('img'), $imageName);
        $data = [
            [
                'nama' => $request->name,
                'level_id' => 3,
                'username' => $request->username,
                'gender' => $request->gender,
                'username_verified' => 'Menunggu',
                'password' => Hash::make($request->password),
                'foto' => 'img/' . $imageName,
            ],
        ];

        // $file = $request->file_foto;
        // $file->move(public_path().'/img');
        
        DB::table('m_user')->insert($data);
        
        return redirect(route('login'))->with('success', 'Tunggu akun anda dikonfirmasi');
    }
}
