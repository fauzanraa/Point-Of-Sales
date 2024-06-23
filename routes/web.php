<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeramalanStokController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WelcomeController;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/postLogin', [LoginController::class, 'postLogin'])->name('postLogin');
Route::get('/logout', [LoginController::class, 'logOut'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('registrasi');
Route::post('/simpanRegistrasi', [RegisterController::class, 'simpanRegistrasi'])->name('simpanRegistrasi');

Route::group(['middleware' => ['auth', 'ceklevel:1,2']], function() {
    Route::get('/', [WelcomeController::class, 'index'])->name('homeIndex');
    Route::post('/list', [WelcomeController::class, 'list']);
});

Route::group(['middleware' => ['auth', 'ceklevel:3']], function() {
    Route::get('/staff', [WelcomeController::class, 'user'])->name('homeStaff');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'ceklevel:1,2']], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [PeramalanStokController::class, 'peramalan']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::get('/{id}/konfirmasi', [UserController::class, 'konfirmasi']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
    Route::get('/level', [LevelController::class, 'index']);
    Route::get('/level/list', [LevelController::class, 'list']);
});

Route::group(['prefix' => 'level' , 'middleware' => ['auth', 'ceklevel:1,2']], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/list', [LevelController::class, 'list']);
    Route::get('/create', [LevelController::class, 'create']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori', 'middleware' => ['auth', 'ceklevel:1,2,3']], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang', 'middleware' => ['auth', 'ceklevel:1,2,3']], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'stok', 'middleware' => ['auth', 'ceklevel:1,2,3']], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
});

Route::group(['prefix' => 'penjualan', 'middleware' => ['auth', 'ceklevel:1,2,3']], function () {
    Route::get('/', [TransaksiController::class, 'index']);
    Route::post('/list', [TransaksiController::class, 'list']);
    Route::get('/create', [TransaksiController::class, 'create']);
    Route::post('/', [TransaksiController::class, 'store']);
    Route::get('/{id}', [TransaksiController::class, 'show']);
});

Route::group(['prefix' => 'member', 'middleware' => ['auth', 'ceklevel:1,2,3']], function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/list', [MemberController::class, 'list']);
    Route::get('/create', [MemberController::class, 'create']);
    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{id}', [MemberController::class, 'show']);
    Route::get('/{id}/edit', [MemberController::class, 'edit']);
    Route::put('/{id}', [MemberController::class, 'update']);
    Route::delete('/{id}', [MemberController::class, 'destroy']);
});


