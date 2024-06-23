<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function postLogin(Request $request){
        if(Auth::attempt($request->only('username','password'))){
            if(auth()->user()->level_id == 1 && 2){
                return redirect(route('homeIndex'));
            }
            if(auth()->user()->level_id == 3 && auth()->user()->username_verified == 'Dikonfirmasi'){
                return redirect(route('homeStaff'));
            }
            // dd(auth()->user()->level_user);
        }
        return redirect(route('login'));
    }

    public function logOut(){
        Auth::logout();
        return redirect(route('login'));
    }
}
