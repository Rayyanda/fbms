<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;
use App\Models\Karyawan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KaryawanController extends Controller
{
    public function index(){
        return view('karyawan');
    }

    public function data($opsi){
        $model = new Karyawan();
        $model2 = new AbsensiKaryawan();
        switch ($opsi) {
            case 'd':
                if(session('sort') && session('column')){
                    $data = $model->sortByColumn(session('column'),session('sort'));
                }else{
                    $data = $model->getPerBranch();
                }
                return view('karyawan.data_kr',['data'=>$data]);
            case 'e':
                $data = $model->getPerBranch();
                return view('karyawan.edit',['data'=>$data,'selected'=>null]);

            case 'a':
                return view('karyawan.tambah');
            
            case 'absensi':
                $data = $model2->getPresenceToday();
                return view('karyawan.absensi',['data'=>$data,'rekap'=>null]);

            case 'penggajian':
                return view('karyawan.penggajian');
            
            default:
                return redirect('/karyawan');
        }
        
    }

    public function action_data($opsi, $param, $detail = null)
    {
        $model = new Karyawan();
        $model2 = new AbsensiKaryawan();
        switch ($opsi){
            case 'd':
                if($param == "refresh"){
                    session(['sort'=>null,'column'=>null]);
                    return redirect('/karyawan/d');
                }
        
                if($param == "sort"){
                    session(['column'=>$detail]);
                    if(session('sort') == 'desc'){
                        session(['sort'=>'asc']);
                    }else{
                        session(['sort'=>'desc']);
                    }
                    return redirect("/karyawan/$opsi");
                }
            case 'e':
                if($param == "id")
                {
                    $data = $model->getPerBranch();
                    $selected = $model->getOne($detail);
                    return view('karyawan.edit',['data'=>$data,'selected'=>$selected]);
                }
                if($param == "refresh"){
                    return redirect('/karyawan/e');
                }
            case 'a':
                if($param == "refresh")
                {
                    return redirect('karyawan/a');
                }
            case 'del':
                if($param == "id")
                {
                    $model->where('id_karyawan',$detail)->delete();
                    return redirect('/karyawan/d')->with('log','Berhasil dihapus');
                }
            case 'absensi':
                switch ($param) {
                    case 'rekap':
                        $data_kr = $model->getPerBranch();
                        if(isset($detail)){
                            $edit = $model2->getOneByIdAbs($detail);
                            if(isset($edit)){
                                return view('karyawan.absensi',['data'=>null,'rekap'=>null,'data_kr'=>$data_kr,'edit'=>$edit,'persentase'=>null])->with('tgl',$detail)->with('nama',$detail);
                            }else{
                                $rekap = $model2->getPresenceAll($detail);
                                count($rekap) > 0 ? $rekap : 
                                $rekap = $model2->selectByName($detail);
                                if(count($rekap) <= 0){
                                    $rekap = $model2->selectByMonth($detail);
                                }
                            return view('karyawan.absensi',['data'=>null,'rekap'=>$rekap,'data_kr'=>$data_kr])->with('tgl',$detail)->with('nama',$detail);
                            }
                        }else{
                            $rekap = $model2->getPresenceAll();
                            return view('karyawan.absensi',['data'=>null,'rekap'=>$rekap,'data_kr'=>$data_kr])->with('tgl',$detail)->with('nama',$detail);
                        }
        
                    case 'persentase':
                        if(isset($detail))
                        {
                            $persentase = $model2->getPercentageCurrentMonth($detail);
                        }else{
                            $persentase = $model2->getPercentageThisMonth();
                        }
                        return view('karyawan.absensi',['data'=>null,'rekap'=>null,'persentase'=>$persentase])->with('tgl',$detail);
        
                    default:
                        return redirect('/karyawan/absensi');
                }
            default :
                return redirect("/karyawan");
        }          
    }

    public function update_data(Request $request,$opsi, $param, $detail = null)
    {
        $flash_log = "";
        date_default_timezone_set('Asia/Jakarta');
        $tyear = date('Y');
        $model = new Karyawan();
        $model_absen = new AbsensiKaryawan();
        switch ($opsi){
            case 'abs':
                try {
                    $id_absensi = $detail;
                    $jam_keluar = $request->input('jam_keluar');
                    $data_absensi = $model_absen->where('id_absensi',$id_absensi);
                    if(isset($data_absensi)){
                        $model_absen->where('id_absensi',$detail)->update(['jam_keluar'=>$jam_keluar,'status'=>"Done"]);
                        $flash_log = "Data berhasil diubah";
                    }
                } catch (\Throwable $th) {
                    $flash_log = "Data gagal diubah";
                }
                return redirect('/karyawan/absensi/rekap')->with('log',$flash_log);

            case 'e':
                $new_id = $request->input('id_karyawan');
                $nama = $request->input('nama');
                $alamat = $request->input('alamat');
                $no_telp = $request->input('no_telp');
                $posisi = $request->input('posisi');
                try 
                {
                    $model->where('id_karyawan',$detail)->update(['id_karyawan'=>$new_id,'nama'=>$nama,'alamat'=>$alamat,'no_telp'=>$no_telp,'posisi'=>$posisi]);
                    Session::flash('log','Berhasil Edit Data');
                } catch (Exception $th) {
                    Session::flash('err','Gagal Edit Data' . $th);
                }
                return redirect('/karyawan/e');
            case 'a':
                if($param == "new")
                {
                    $model->id_karyawan = auth()->user()->kode_cabang . "-" . $tyear . $request->input('id_karyawan');
                    $model->nama = $request->input('nama');
                    $model->alamat = $request->input('alamat');
                    $model->no_telp = $request->input('no_telp');
                    $model->posisi = $request->input('posisi');
                    $model->cabang = auth()->user()->cabang;
                    try
                    {
                        $model->save();
                        
                        $flash_log = "Data Berhasil di tambahkan";
                    }catch(Exception $th){
                       $flash_log = "Data gagal ditambahkan karena $th";
                    }
                }
                return redirect('/karyawan/a')->with('log',$flash_log);
          
            default:
                return redirect('/karyawan/absensi');
        }
    }

    public function absensi()
    {
        if(Auth::check()){
            return redirect('/karyawan/absensi')->with('log','Anda masih login. Silahkan Logout untuk keamanan');
        }else{
            $cabang = DB::table('cabang')->get();
            return view('karyawan.form_absensi',['cabang'=>$cabang]);
        }
    }

    public function isi_absensi(Request $request){
        $flash_log="";
        date_default_timezone_set('Asia/Jakarta');
        $time_now = date('H:i:s');
        $date = date("Y-m-d");
        $model = new Karyawan();
        $newDataAbsen = new AbsensiKaryawan();
        $id_input = $request->input('id_karyawan');
        $check_available = $newDataAbsen->getOne($id_input);
        $cabang_input = $request->input('cabang');
        if($cabang_input == "wrong")
        {
            $flash_log = "Gagal mengisi absensi. Anda belum memilih cabang" ;
            return redirect('/absensi-karyawan')->with('err',$flash_log);
        }
        if($check_available != null && $check_available->tanggal == $date)
        {
            DB::table('absensi_karyawan')->where('id_absensi',$check_available->id_absensi)
                ->update(['jam_keluar'=>$time_now,'status'=>'Done']);
            $flash_log = 'Terimakasih untuk hari ini. Selamat Beristirahat';
            return redirect('/absensi-karyawan')->with('log',$flash_log);
        }else{
            try {
                $karyawan = $model->getOne($id_input);
                $newDataAbsen->id_absensi = "abs-" . $cabang_input . "_" . date("Ymd-") . $id_input;
                $newDataAbsen->id_karyawan = $id_input;
                $newDataAbsen->tanggal = $date;
                $newDataAbsen->jam_masuk = $time_now;
                $newDataAbsen->status = "working";
                $newDataAbsen->save();
                $flash_log = "Anda berhasil mengisi absen. Terimakasih";
                return redirect('/absensi-karyawan')->with('log',$flash_log);
            } catch (Exception $th) {
                $flash_log = "Gagal mengisi absensi. Periksa kembali id dan cabang $th" ;
                return redirect('/absensi-karyawan')->with('err',$flash_log);
            }
        }
    }


}
