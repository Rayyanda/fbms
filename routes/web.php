<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PersediaanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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
//route ke dashboard
Route::get('/', [DashboardController::class,'index'])->name('home')->middleware('auth');


//route ke halaman login
Route::get('/login',[DashboardController::class,'login'])->name('login');

Route::post('/login',[DashboardController::class,'login_user'])->name('login_user');
Route::get('/logout',[DashboardController::class,'logout'])->name('logout');


//halaman
Route::get('/keuangan',[KeuanganController::class,'index'])->name('halaman-keuangan')->middleware('auth');
Route::get('/keuangan/{opsi}',[KeuanganController::class,'opsi_keuangan'])->name("opsi_keuangan")->middleware('auth');
Route::get('/keuangan/{opsi}/{param}/{detail?}',[KeuanganController::class,'action_data'])->name('add_data_keuangan')->middleware('auth');
Route::post('/keuangan/{opsi}/{param}/{detail?}',[KeuanganController::class,'update_data'])->name('update_data_keu')->middleware('auth');
Route::get('/keuangan/pengeluaran?q',[KeuanganController::class, 'search'])->name('search_test');


Route::get('/karyawan',[KaryawanController::class,'index'])->name('halaman_karyawan')->middleware('auth');
Route::get('/karyawan/{opsi}',[KaryawanController::class,'data'])->name('data_karyawan')->middleware('auth');
Route::get('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'action_data'])->name('action_data_kr')->middleware('auth');
Route::post('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'update_data'])->name('update_data_kr')->middleware('auth');
Route::get('/absensi-karyawan',[KaryawanController::class,'absensi'])->name('absensi_karyawan');
Route::post('/isi-absensi',[KaryawanController::class,'isi_absensi'])->name('isi_absensi');


//persediaan
Route::get('/persediaan',[PersediaanController::class,'index'])->name('halaman_persediaan')->middleware('auth');
//Route::get('/persediaan/{opsi}',[PersediaanController::class,'opsi_persediaan'])->name('opsi_persediaan')->middleware('auth');
Route::get('/persediaan/{opsi}/{param?}/{detail?}',[PersediaanController::class, 'opsi_persediaan'])->name('opsi_persediaan')->middleware('auth');
Route::post('/persediaan/{opsi}/{param}/{detail?}',[PersediaanController::class, 'update_data'])->name('update_inv')->middleware('auth');


//Inventaris
Route::get('/inventaris',[InventarisController::class,'index'])->name('halaman_inventaris')->middleware('auth');
//Route::get('/inventaris/{opsi}',[InventarisController::class, 'opsi_inv'])->name('opsi_inventaris')->middleware('auth');
Route::get('/inventaris/{opsi}/{param?}/{detail?}',[InventarisController::class, 'action_inv'])->name('action_inv')->middleware('auth');
Route::post('/inventaris/{opsi}/{param}/{detail?}',[InventarisController::class, 'update_inv'])->name('update_inv')->middleware('auth');



//wild card
Route::get('{any}',function(){
    $message = "url not found";
    return view('error',['message'=>$message]);
});