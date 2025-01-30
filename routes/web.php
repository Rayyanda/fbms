<?php

use App\Http\Controllers\Auth\AuthController;
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
//route ke home
Route::get('/', [DashboardController::class,'home'])->name('home')->middleware('auth');


//Route dengan syarat sudah login dan login sebagai admin
Route::middleware(['auth','role:admin'])->group(function(){

    //prefix route untuk admin
    Route::prefix('admin')->group(function(){

        //route ke halaman dashboard untuk admin
        Route::get('/',[DashboardController::class,'admin'])->name('admin.dashboard');

        //Route untuk ke halaman register
        Route::get('/register',[AuthController::class,'register_page'])->name('register');

        //route untuk melakukan register
        Route::post('/register',[AuthController::class,'register'])->name('user.register');

        //route ke halaman data karyawan
        Route::get('/karyawan/{opsi}',[KaryawanController::class,'data'])->name('data_karyawan');

        //route untuk melihat detail data karyawan
        Route::get('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'action_data'])->name('action_data_kr');

        //Route untuk mengupdate data karyawan
        Route::post('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'update_data'])->name('update_data_kr');

        //Route untuk ke halaman absensi karyawan
        Route::get('/absensi-karyawan',[KaryawanController::class,'absensi'])->name('absensi_karyawan');


        Route::post('/isi-absensi',[KaryawanController::class,'isi_absensi'])->name('isi_absensi');

    });

});

//Route dengan syarat sudah login dan role adalah admin dan karyawan
Route::middleware(['auth','role:admin,karyawan'])->group(function(){

    //route ke halaman index karyawan
    Route::get('/karyawan',[KaryawanController::class,'index'])->name('karyawan.index');

});

//route dengan syarat sudah login dan login sebagai karyawan
Route::middleware(['auth','role:karyawan'])->group(function(){

    //route ke halaman dashboard untuk karyawan
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('employee.dashboard');


    //route dengan syarat posisi karyawan adalah HRD
    Route::middleware(['division:hr'])->group(function(){

        //Route untuk ke halaman register
        Route::get('/register',[AuthController::class,'register_page'])->name('register');

        //route untuk melakukan register
        Route::post('/register',[AuthController::class,'register'])->name('user.register');

        // //route ke halaman index karyawan
        // Route::get('/karyawan',[KaryawanController::class,'index'])->name('hr.index');

        //route ke halaman data karyawan
        Route::get('/karyawan/{opsi}',[KaryawanController::class,'data'])->name('data_karyawan');

        //route untuk melihat detail data karyawan
        Route::get('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'action_data'])->name('action_data_kr');

        //Route untuk mengupdate data karyawan
        Route::post('/karyawan/{opsi}/{param}/{detail?}',[KaryawanController::class, 'update_data'])->name('update_data_kr');

        //Route untuk ke halaman absensi karyawan
        Route::get('/absensi-karyawan',[KaryawanController::class,'absensi'])->name('absensi_karyawan');


        Route::post('/isi-absensi',[KaryawanController::class,'isi_absensi'])->name('isi_absensi');

    });

});


//route ke halaman login
Route::get('/login',[AuthController::class,'login_page'])->name('login');

//route untuk melakukan login
Route::post('/login',[AuthController::class,'login'])->name('user.login');

//route untuk melakukan logout
Route::get('/logout',[AuthController::class,'logout'])->name('logout');




//halaman
Route::get('/keuangan',[KeuanganController::class,'index'])->name('halaman-keuangan');
Route::get('/keuangan/{opsi}',[KeuanganController::class,'opsi_keuangan'])->name("opsi_keuangan")->middleware('auth');
Route::get('/keuangan/{opsi}/{param}/{detail?}',[KeuanganController::class,'action_data'])->name('add_data_keuangan')->middleware('auth');
Route::post('/keuangan/{opsi}/{param}/{detail?}',[KeuanganController::class,'update_data'])->name('update_data_keu')->middleware('auth');
Route::get('/keuangan/pengeluaran?q',[KeuanganController::class, 'search'])->name('search_test');





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
})->name('error');
