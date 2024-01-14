<?php

namespace App\Http\Controllers;


use App\Models\BahanBaku;
use App\Models\Pengeluaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PersediaanController extends Controller
{
    public function index()
    {
        return view("persediaan");
    }
    public function opsi_persediaan($opsi, $param = null, $detail = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        $bahan_baku = new BahanBaku();
        $pengeluaran = new Pengeluaran();
        switch ($opsi)
        {
            case 'bahan':

                switch($param)
                {
                    case 'a' :
                        return view('persediaan.tambah');

                    case 'del':
                        $id = $detail;
                        DB::table('bahan_baku')->where('id_bahan_baku','=',$detail)->delete();
                        Session::flash('log', 'Data berhasil dihapus');
                        return redirect('/persediaan/bahan');
                    
                    case 'tgl':
                        $data = $bahan_baku->getByDate($detail);
                        return view('persediaan.bahan', ['data'=>$data,'tgl'=>$detail]);

                    case 'ajukan':
                        $today = date('dmy');
                        $checkExpense = $pengeluaran->getOne($detail);
                        if($checkExpense == null){
                            try {
                                //code...
                                $expense = new Pengeluaran();
                                $id = auth()->user()->kode_cabang . "_" . $today . "0001";
                                $total = DB::table('bahan_baku')->where('cabang',auth()->user()->cabang)->sum('total');
                                $expense->id_pengeluaran = $id;
                                $expense->tujuan_pengeluaran = "Pembelian Bahan Baku";
                                $expense->tanggal = $detail;
                                $expense->jumlah = $total;
                                $expense->cabang = auth()->user()->cabang;
                                $expense->save();

                            } catch (Exception $th) {
                                return redirect('/persediaan/bahan')->with('err','eror pada : ' . $th);
                                
                            }
                            $bahan_baku->AddToExpense($detail,$id);
                            return redirect('/persediaan/bahan')->with('log',"Berhasil memasukkan ke data pengeluaran");
                        }else{
                            return redirect('/persediaan/bahan')->with('err','Data pengeluaran tanggal ' . $detail . ' sudah ada');
                        }

                    default:
                        $data = $bahan_baku->getPerBranch();
                        return view('persediaan.bahan', ['data'=>$data,'tgl'=>null]);
                }

            default :
                return redirect('/persediaan/bahan')->with('tgl',null);
        }
    }

    public function update_data(Request $request, $opsi, $param, $detail = null)
    {
        $bahan_model = new BahanBaku();
        date_default_timezone_set('Asia/Jakarta');
        switch($opsi)
        {
            case 'bahan':
                switch ($param)
                {
                    case 'a':
                        // Validasi data yang diterima
                        try {
                            $nama_bahan = $request->input('nama_bahan_baku');
                            $available = $bahan_model->checkAvailability($nama_bahan);
                            if(isset($available))
                            {
                                return redirect('/persediaan/bahan/a')->with('err','Bahan tersebut sudah ada, silahkan isi dengan benar atau edit data');
                            }else{
                                $bahan_model->id_bahan_baku = auth()->user()->kode_cabang . "-bhn_" . $nama_bahan;
                                $bahan_model->nama_bahan_baku = $nama_bahan;
                                $bahan_model->satuan = $request->input('satuan');
                                $bahan_model->harga_satuan = $request->input('harga_satuan');
                                $bahan_model->stok = $request->input('stok');
                                $bahan_model->total = $request->input('stok') * $request->input('harga_satuan');
                                $bahan_model->terakhir_update = date('Y-m-d') ;
                                $bahan_model->jam = date('H:i:s');
                                $bahan_model->cabang = auth()->user()->cabang;
                                $bahan_model->save();
                                Session::flash('log','berhasil');
                                return redirect('/persediaan/bahan/a')->with('log','Bahan baku berhasil diajukan');
                            }
                            
                        } catch (Exception $th) {
                            Session::flash('err',$th);
                            return redirect('/persediaan/bahan/a')->with('err','gagal menambahkan' . $th);
                        }
                }
        }
    }
}
