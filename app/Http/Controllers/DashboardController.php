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

    public function home()
    {
        switch (auth()->user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            default:
                return redirect()->route('employee.dashboard');
        }
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');
        $today = date('dmy');
        $data_pemasukan = DB::table('pemasukan')
            ->select('tanggal_masuk',DB::raw('SUM(jumlah) as total_jumlah'))
            // ->where('cabang',auth()->user()->cabang)
            ->where('tanggal_masuk','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal_masuk')
            ->orderBy('tanggal_masuk','desc')
            ->get();

        $data_pengeluaran = DB::table('pengeluaran')
            ->select('tanggal',DB::raw('SUM(jumlah) as total_jumlah'))
            // ->where('cabang',auth()->user()->cabang)
            ->where('tanggal','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal')
            ->orderBy('tanggal','desc')
            ->get();

        return view("dashboard",['data_pemasukan'=>$data_pemasukan,'data_pengeluaran'=>$data_pengeluaran]);
    }

    public function admin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('dmy');
        $data_pemasukan = DB::table('pemasukan')
            ->select('tanggal_masuk',DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('tanggal_masuk','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal_masuk')
            ->orderBy('tanggal_masuk','desc')
            ->get();

        $data_pengeluaran = DB::table('pengeluaran')
            ->select('tanggal',DB::raw('SUM(jumlah) as total_jumlah'))
            ->where('tanggal','>=',DB::raw('DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)'))
            ->groupBy('tanggal')
            ->orderBy('tanggal','desc')
            ->get();

        return view("dashboard",['data_pemasukan'=>$data_pemasukan,'data_pengeluaran'=>$data_pengeluaran]);
    }

}
