<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaporanKeuangan extends Model
{
    use HasFactory;
    protected $table = 'laporan_keuangan';
      
    public function getPerBranch(){
        return $this->join('pemasukan','pemasukan.id_pemasukan','=','laporan_keuangan.id_pendapatan')
            ->join('pengeluaran','laporan_keuangan.id_pengeluaran','=','pengeluaran.id_pengeluaran')
            ->select('laporan_keuangan.*','pemasukan.jumlah AS pendapatan','pengeluaran.jumlah AS pengeluaran')
            ->where('laporan_keuangan.cabang',auth()->user()->cabang)
            ->orderBy('laporan_keuangan.tanggal','desc')
            ->paginate(10);
        }
        public function getOneDetail($tanggal){
            return $this->join('pemasukan','pemasukan.id_pemasukan','=','laporan_keuangan.id_pendapatan')
                ->join('pengeluaran','laporan_keuangan.id_pengeluaran','=','pengeluaran.id_pengeluaran')
                ->select('laporan_keuangan.*','pemasukan.jumlah AS pendapatan','pengeluaran.jumlah AS pengeluaran')
                ->where('laporan_keuangan.tanggal',$tanggal)
                ->first();
        }

    public function getPerDate($tanggal)
    {
        return $this->join('pemasukan','pemasukan.id_pemasukan','=','laporan_keuangan.id_pendapatan')
            ->join('pengeluaran','laporan_keuangan.id_pengeluaran','=','pengeluaran.id_pengeluaran')
            ->select('laporan_keuangan.*','pemasukan.jumlah AS pendapatan','pengeluaran.jumlah AS pengeluaran')
            ->where('laporan_keuangan.cabang',auth()->user()->cabang)
            ->where('laporan_keuangan.tanggal',$tanggal)
            ->get();
        }
        
        public function updateLaba($tgl)
        {
        $model = new Pemasukan();
        $model_pengeluaran = new Pengeluaran();
        $pendapatan = $model->getOne($tgl);
        $pengeluaran = $model_pengeluaran->getOne($tgl);
        $laba_kotor = $pendapatan->jumlah - $pengeluaran->jumlah;
        $laba_bersih_data = $this->getOne($tgl);
        $fix_laba_bersih = $laba_kotor - $laba_bersih_data->beban_non_operasional;
        $this->where('tanggal',$tgl)
            ->update(['laba_kotor'=>$laba_kotor,'laba_bersih'=>$fix_laba_bersih]);
    }
    
    public function getPerMonth($month)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode("-",$month);
        return $this->join('pemasukan','pemasukan.id_pemasukan','=','laporan_keuangan.id_pendapatan')
            ->join('pengeluaran','laporan_keuangan.id_pengeluaran','=','pengeluaran.id_pengeluaran')
            ->select('laporan_keuangan.*','pemasukan.jumlah AS pendapatan','pengeluaran.jumlah AS pengeluaran')
            ->where('laporan_keuangan.cabang',auth()->user()->cabang)
            ->whereRaw("DATE_FORMAT(laporan_keuangan.tanggal, '%m') = $date[1]")
            ->get();
            
        }
        //belum
        public function getCurrentMonth($month){
            date_default_timezone_set('Asia/Jakarta');
            $date = explode("-",$month);
            return $this
                ->select(
                    DB::raw("DATE_FORMAT(laporan_keuangan.tanggal, $month) AS Bulan"),
                    DB::raw("SUM(pengeluaran.jumlah) AS pengeluaran")
                )
                ->join('pemasukan','pemasukan.id_pemasukan','=','laporan_keuangan.id_pendapatan')
                ->join('pengeluaran','laporan_keuangan.id_pengeluaran','=','pengeluaran.id_pengeluaran')
                ->select('laporan_keuangan.*','pemasukan.jumlah AS pendapatan','pengeluaran.jumlah AS pengeluaran')
                ->where('laporan_keuangan.cabang',auth()->user()->cabang)
                ->whereRaw("DATE_FORMAT(laporan_keuangan.tanggal, '%m') = $date[1]")
                ->get();

        }

    public function getOne($tanggal)
    {
        return $this->where('tanggal',$tanggal)
            ->first();
    }
}
