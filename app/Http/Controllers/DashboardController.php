<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        date_default_timezone_set('Asia/Jakarta');
        $today = date('dmy');
        $data_pemasukan = DB::table('pemasukan')
            ->select('tanggal_masuk',DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('cabang',auth()->user()->cabang)
            ->where('tanggal_masuk','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal_masuk')
            ->orderBy('tanggal_masuk','desc')
            ->get();
        
        $data_pengeluaran = DB::table('pengeluaran')
            ->select('tanggal',DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('cabang',auth()->user()->cabang)
            ->where('tanggal','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal')
            ->orderBy('tanggal','desc')
            ->get();

        return view("dashboard",['data_pemasukan'=>$data_pemasukan,'data_pengeluaran'=>$data_pengeluaran]);
    }

    

    public function login()
    {
        if (Auth::check()) {
            

            return redirect('/');
        }else{
            return view('login');
        }
    }
    public function login_user(Request $request){
        $email = $request->input('email');
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        session(['email'=>$email]);
        if (Auth::Attempt($data)) {
            $user = DB::table('users')->where('email',$email)->get();
            
            return redirect('/');
        }else{
            Session::flash('err', 'Email atau Password Salah');
            return redirect('/login');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
