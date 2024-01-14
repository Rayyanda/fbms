<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbsensiKaryawan extends Model
{
    use HasFactory;
    protected $table = "absensi_karyawan";

    public function getPresenceToday()
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date('d');
        return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
            ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
            ->where('karyawan.cabang',auth()->user()->cabang)
            ->whereRaw("DATE_FORMAT(tanggal, '%d') = $today")
            ->get();
    }

    public function getPresenceAll($tanggal = null)
    {
        if($tanggal != null){
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                ->where('karyawan.cabang',auth()->user()->cabang)
                ->where('tanggal',$tanggal)
                ->paginate(10);
        }else{
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                ->where('karyawan.cabang',auth()->user()->cabang)
                ->orderBy('tanggal','desc')
                ->paginate(18);
        }
    }
    public function selectByMonth($month = null){
        date_default_timezone_set('Asia/Jakarta');
        $this_month = date('m');
        if($month != null){
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                    ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                    ->where('karyawan.cabang',auth()->user()->cabang)
                    ->whereRaw("DATE_FORMAT(absensi_karyawan.tanggal, '%Y-%m') = ?", [$month])
                    ->orderBy('absensi_karyawan.tanggal', 'desc')
                    ->paginate(18);
        }else{
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                    ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                    ->where('karyawan.cabang',auth()->user()->cabang)
                    ->paginate(18);
        }
    }

    public function selectByName($nama = null)
    {
        if($nama != null){
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                    ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                    ->where('karyawan.cabang',auth()->user()->cabang)
                    ->where('karyawan.nama',$nama)
                    ->paginate(10);
        }else{
            return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
                    ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
                    ->where('karyawan.cabang',auth()->user()->cabang)
                    ->paginate(10);
        }
    }

    public function getOne($id_karyawan)
    {
        //Carbon::create(2023,1,1)->daysInMonth;
        date_default_timezone_set('Asia/Jakarta');
        return $this->where('id_karyawan',$id_karyawan)
            ->where('tanggal',date('Y-m-d'))
            ->first();
    }

    public function getOneByIdAbs($id_absensi)
    {
        return $this->join('karyawan','absensi_karyawan.id_karyawan','=','karyawan.id_karyawan')
        ->select('absensi_karyawan.*','karyawan.nama','karyawan.posisi')
        ->where('absensi_karyawan.id_absensi',$id_absensi)
        ->first();
    }
    public function getPercentageThisMonth()
    {
        
        date_default_timezone_set('Asia/Jakarta');
        $this_month = date('m');
        $total_days = Carbon::create(date('Y'),date('m'),1)->daysInMonth;
        return $this->select(
            'absensi_karyawan.id_karyawan',
            'karyawan.nama',
            'karyawan.posisi',
            DB::raw('DATE_FORMAT(absensi_karyawan.tanggal, "%Y-%m") AS Bulan'),
            DB::raw("(COUNT(absensi_karyawan.id_karyawan) * 100)/$total_days AS JumlahAbsensi")
        )
        ->join('karyawan', 'absensi_karyawan.id_karyawan', '=', 'karyawan.id_karyawan')
        ->where('karyawan.cabang', auth()->user()->cabang)
        ->whereRaw("DATE_FORMAT(tanggal, '%m') = $this_month")
        ->groupBy('absensi_karyawan.id_karyawan', 'karyawan.nama', 'karyawan.posisi', 'Bulan')
        ->get();
    }

    public function getPercentageCurrentMonth($month)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode("-",$month);
        $total_days = Carbon::create($date[0],$date[1],1)->daysInMonth;
        return $this->select(
            'absensi_karyawan.id_karyawan',
            'karyawan.nama',
            'karyawan.posisi',
            DB::raw('DATE_FORMAT(absensi_karyawan.tanggal, "%Y-%m") AS Bulan'),
            DB::raw("(COUNT(absensi_karyawan.id_karyawan) * 100)/$total_days AS JumlahAbsensi")
        )
        ->join('karyawan', 'absensi_karyawan.id_karyawan', '=', 'karyawan.id_karyawan')
        ->where('karyawan.cabang', auth()->user()->cabang)
        ->whereRaw("DATE_FORMAT(tanggal, '%m') = $date[1]")
        ->groupBy('absensi_karyawan.id_karyawan', 'karyawan.nama', 'karyawan.posisi', 'Bulan')
        ->get();
    }
}
