<?php

namespace App\Http\Controllers;
use App\Models\LaporanKeuangan;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class KeuanganController extends Controller
{
    //menampilkan menu keuangan
    public function index(){
        //membersihkan session sort dan column untuk penyortiran tabel
        session(['sort'=>null,'column'=>null]);
        //membuka view keuangan
        return view('keuangan');
    }

    //fungsi untuk mencari di halaman pengeluaran
    public function search(Request $request){

        $q = $request->input('q');
        $query = Pengeluaran::where('cabang',auth()->user()->cabang)
        ->where('id_pengeluaran','LIKE',"%$q%")
        ->orWhere('tujuan_pengeluaran','LIKE',"%$q%")
        ->orWhere('jumlah',"LIKE","%$q%")
        ->orWhere('tanggal','LIKE',"%$q%")
        ->orWhere('keterangan','LIKE',"%$q%");
        //$model = new Pengeluaran();
        $data = $query->get();
        return view('keuangan.pengeluaran',['pengeluaran'=>$data,'edit'=>null]);
    }

    //fungsi untuk opsi, parameter pertama
    public function opsi_keuangan($opsi){
        //instansiasi (child) model
        $model = new Pengeluaran();
        $model2 = new Pemasukan();
        $model3 = new LaporanKeuangan();


        switch ($opsi){
            //jika parameter pertama berupa pendapatan
            case 'pendapatan':
                //mengambil data pemasukan sesuai cabang
                $pemasukan = $model2->getPerBranch();
                //menampilkan view pendapatan
                return view("keuangan.pendapatan",['pemasukan'=>$pemasukan, 'edit'=>null])->with('tgl',null);
            
            //jika parameter pertama adalah pengeluaran
            case 'pengeluaran':
                //memeriksa apakah masih dalam kondisi tersortir
                if(session('sort') && session('column')){
                    //jika masih ada session, maka akan menyortir data pengeluaran pada tabel
                    $pengeluaran = $model->sortByColumn(session('column'),session('sort'));
                }else{
                    //jika sudah tidak ada, maka hanya akan mengambil secara default urutan
                    $pengeluaran = $model->getPerBranch();
                }
                //menampilkan view pengeluaran
                return view('keuangan.pengeluaran',['pengeluaran'=>$pengeluaran,'edit'=>null]);

            //jika paramter pertama adalah laporan
            case 'laporan':
                //mengambil data laporan per cabang dari model
                $laporan = $model3->getPerBranch();
                //menampilkan halaman/data laporan keuangan
                return view('keuangan.laporan',['laporan'=>$laporan])->with('tgl',null);
            
             default:
             //jika parameter tidak terbaca, maka akan kembali ke menu keuangan
                return redirect('/keuangan');   
        }
    }

    //fungsi jika parameter 2 atau 3 parameter terpenuhi
    public function action_data($opsi, $param, $detail = null ){
        //instansiasi model
        $model = new Pemasukan();
        $model_laporan = new LaporanKeuangan();
        $model_pengeluaran = new Pengeluaran();
        //variabel untuk menyimpan pesan
        $flash_log = "";
        //aksi untuk pendapatan
        if($opsi == 'pendapatan'){
            switch ($param){
                //untuk menampilkan tampilan/form add untuk menambah data pendapatan
                case 'add':
                    //menampilkan form tambah pendapatan
                    return view('keuangan.pendapatan',['pemasukan'=>null,'edit'=>null]);

                //untuk menampilkan tampilan/form edit data pendapatan
                case 'edit':
                    //mengambil data pendapatan berdasarkan id pendapatan
                    $data = DB::table('pemasukan')->where('id_pemasukan',$detail)->first();
                    //menampilkan data yang telah diambil untuk di edit
                    return view('keuangan.pendapatan',['pemasukan'=>null,'edit'=>$data]);
                
                //untuk menghapus data pendapatan
                case 'hapus':
                    //blok try untuk track kesalahan
                    try {
                        //menghapus data pemsaukan berdasarkan id pendapatan
                        DB::table('pemasukan')->where('id_pemasukan',$detail)->delete();
                        //mengisi variabel pesan singkat
                        $flash_log = 'Data berhasil di hapus';
                        //membuat flash session sementara
                        Session::flash('log',$flash_log);

                     //menagkap eksepsi   
                    } catch (Exception $th) {
                        //membuat flash session
                        $flash_log = 'Data gagal di hapus';
                        Session::flash('err',$flash_log);
                    }
                    //kembali ke halaman pendapatan
                    return redirect('/keuangan/pendapatan');
                //mengambil paramter khusus untuk menampikan data berdasarkan tanggal yang telah di pilih
                case 'tanggal_masuk':
                    //mengambil data pendapatan berdasarkan tanggal
                    $pemasukan = $model->selectColumn($param, $detail);
                    if($detail != null){
                        //menampilkan data yang berhasil di ambil
                        return view('keuangan.pendapatan',['pemasukan'=>$pemasukan,'edit'=>null])->with('tgl',$detail);
                    }else{
                        //jika gagal, maka akan kembali ke halaman pendapatan
                        return redirect('keuangan/pendapatan');
                    }
                //untuk parameter search
                case 'q':
                    $pemasukan = $model->search($detail);
                    return view('keuangan.pendapatan',['pemasukan'=>$pemasukan,'edit'=>null]);

                //jika parameter kedua tidak ada, maka akan melakukan refresh
                default:
                    //membersihkan sesi
                    session(['sort'=>null,'column'=>null]);
                    //kembali ke halaman pendapatan
                    return redirect('/keuangan/pendapatan');
            }
            //untuk parameter search
            // if($param == "q" && $detail != null){
            //    //query search berdasarkan key yang diinput
            //     $pemasukan = DB::table('pemasukan')->where('sumber_pemasukan','like',"%$detail%")->where('cabang',auth()->user()->cabang)->paginate(10);
            //     Session::flash('log',$detail . $pemasukan);
            //     return view('keuangan.pendapatan',['pemasukan'=>$pemasukan,'edit'=>null]);

            // }
            
        }
        if($opsi == "pengeluaran"){
            $model = new Pengeluaran();
            switch ($param) {
                case 'add':
                    return view('keuangan.pengeluaran',['pengeluaran'=>null,'edit'=>null]);

                case 'edit':
                    $data = DB::table('pengeluaran')->where('id_pengeluaran',$detail)->first();
                    return view('keuangan.pengeluaran',['pengeluaran'=>null,'edit'=>$data]);

                case 'sort':
                    session(['column'=>$detail]);
                    if(session('sort') == 'desc'){
                        session(['sort'=>'asc']);
                    }else{
                        session(['sort'=> 'desc']);
                    }
                    return redirect('/keuangan/'.$opsi);
                
                case 'hapus':
                    try {
                        DB::table('pengeluaran')->where('id_pengeluaran',$detail)->delete();
                        $flash_log = 'Data berhasil di hapus';
                        Session::flash('log',$flash_log);
                    } catch (Exception $th) {
                        $flash_log = 'Data gagal di hapus';
                        Session::flash('err',$flash_log);
                    }
                    return redirect('/keuangan/pengeluaran');

                case 'tanggal':
                    $pengeluaran = $model->selectColumn($param,$detail);
                    if($detail != null){
                        return view('keuangan.pengeluaran',['pengeluaran'=>$pengeluaran,'edit'=>null])->with('tgl',$detail);
                    }else{
                        return redirect('/keuangan/pengeluaran');
                    }


                default:
                    session(['sort'=>null,'column'=>null]);
                    return redirect('/keuangan/pengeluaran');
            }
        }
        if($opsi == "laporan"){
            $flash_log = "";
            switch ($param){
                case 'add':
                    date_default_timezone_set('Asia/Jakarta');
                    switch ($detail){
                        case 'today':
                            $data = $model_laporan->getOne(date('Y-m-d'));
                            $pemasukan = $model->getOne(date('Y-m-d'));
                            $pengeluaran = $model_pengeluaran->getOne(date('Y-m-d'));
                            if(isset($data)){
                                //jika data laporan sudah ada, maka hanya bisa mengeditnya
                                return redirect('/keuangan/laporan')->with('err','Laporan hari ini sudah masuk');

                            }else{
                                if(isset($pemasukan) && isset($pengeluaran)){
                                    //membuat data laporan baru
                                    try {
                                        $model_laporan->tanggal = date("Y-m-d");
                                        $model_laporan->id_pendapatan = $pemasukan->id_pemasukan;
                                        $model_laporan->id_pengeluaran = $pengeluaran->id_pengeluaran;
                                        $model_laporan->beban_non_operasional = 0;
                                        $model_laporan->laba_kotor = $pemasukan->jumlah - $pengeluaran->jumlah;
                                        $model_laporan->laba_bersih = $pemasukan->jumlah - $pengeluaran->jumlah - $model_laporan->beban_non_operasional;
                                        $model_laporan->cabang = auth()->user()->cabang;
                                        $model_laporan->save();
                                        $flash_log = "Data Berhasil ditambahkan.";
                                    } catch (Exception $th) {
                                        $flash_log = "Data gagal ditambahkan karena $th";
                                    }
                                    return redirect('/keuangan/laporan')->with('log',$flash_log);
                                }else{
                                    $info = "Data pemasukan / pengeluaran hari ini belum ada, silahkan masukkan terlebih dahulu.";
                                    return redirect('/keuangan/laporan')->with('err',$info);
                                }
                                
                            }
                            
                            default:
                                $data = $model_laporan->getOne($detail);
                                $pemasukan = $model->getOne(date($detail));
                                $pengeluaran = $model_pengeluaran->getOne($detail);
                                if(isset($data)){
                                    //jika data laporan sudah ada, maka hanya bisa mengeditnya
                                    return redirect('/keuangan/laporan')->with('err',"Laporan tanggal $detail sudah masuk");

                                }else{
                                    if(isset($pemasukan) && isset($pengeluaran)){
                                        //membuat data laporan baru
                                        try {
                                            $model_laporan->tanggal = $detail;
                                            $model_laporan->id_pendapatan = $pemasukan->id_pemasukan;
                                            $model_laporan->id_pengeluaran = $pengeluaran->id_pengeluaran;
                                            $model_laporan->beban_non_operasional = 0;
                                            $model_laporan->laba_kotor = $pemasukan->jumlah - $pengeluaran->jumlah;
                                            $model_laporan->laba_bersih = $pemasukan->jumlah - $pengeluaran->jumlah - $model_laporan->beban_non_operasional;
                                            $model_laporan->cabang = auth()->user()->cabang;
                                            $model_laporan->save();
                                            $flash_log = "Data Berhasil ditambahkan.";
                                        } catch (Exception $th) {
                                            $flash_log = "Data gagal ditambahkan karena $th";
                                        }
                                        return redirect('/keuangan/laporan')->with('log',$flash_log);
                                    }else{
                                        $info = "Data pemasukan / pengeluaran hari ini belum ada, silahkan masukkan terlebih dahulu.";
                                        return redirect('/keuangan/laporan')->with('err',$info);
                                    }
                                    
                                }
                    }

                case "edit":
                    //mengambil data laporan per cabang dari model
                    $edit = $model_laporan->getOneDetail($detail);
                //menampilkan halaman/data laporan keuangan
                    return view('keuangan.laporan',['laporan'=>null, 'edit'=>$edit]);

                case "tanggal":
                    if(isset($detail)){
                        $laporan = $model_laporan->getPerDate($detail);
                        return view('keuangan.laporan',['laporan'=>$laporan,'edit'=>null])->with('tgl',$detail);
                    }else{
                        return redirect('/keuangan/laporan');
                    }
                    case "bulan":
                        if(isset($detail)){
                            $laporan = $model_laporan->getPerMonth($detail);
                            return view('keuangan.laporan',['laporan'=>$laporan,'edit'=>null])->with('tgl',$detail);
                        }

                default:
                    return redirect('/keuangan/laporan');
            }
        }
    }


    public function update_data(Request $request, $opsi, $param, $detail = null){
        $flash_log = "";
        $model2 = new Pemasukan();
        $model1 = new LaporanKeuangan();
        if($opsi == 'pendapatan'){
            if($param == "add"){
                date_default_timezone_set('Asia/Jakarta');
                $today = date('dmy');
                $new = new Pemasukan();
                $new->id_pemasukan = auth()->user()->kode_cabang . "_" . $today . $request->input('idPemasukan') ;
                $new->sumber_pemasukan = $request->input('sumberPemasukan');
                $new->tanggal_masuk = $request->input('tanggalPemasukan');
                $new->jumlah = $request->input('jumlahPemasukan');
                $new->keterangan = $request->input('keterangan');
                $new->cabang = auth()->user()->cabang;
                try {
                    $new->save();
                    $flash_log = 'Data berhasil di tambahkan';
                  Session::flash('log',$flash_log);
                } catch (Exception $th) {
                    
                    $flash_log = 'Data gagal di tambahkan. Silahkan cek ID Pemasukan atau Tanggal Pemasukan ';
                    Session::flash('err',$flash_log);
                }
            }
            if($param == "edit"){
                $id_lama = $request->input('idPemasukanLama');
                $getDataBefore = $model2->getById($id_lama);
                $id = substr($getDataBefore->id_pemasukan, 0, -4) . $request->input('idPemasukan');
                $sumber_pemasukan = $request->input('sumberPemasukan');
                $tanggal_pemasukan = $request->input('tanggalPemasukan');
                $jumlah = $request->input('jumlahPemasukan');
                $keterangan = $request->input('keterangan');
                try {
                    
                    DB::table('pemasukan')
                        ->where('id_pemasukan',$id_lama)
                        ->update(['id_pemasukan'=>$id,'sumber_pemasukan'=>$sumber_pemasukan,'tanggal_masuk'=>$tanggal_pemasukan,'jumlah'=>$jumlah,'keterangan'=>$keterangan]);
                    $data_laporan = $model1->getOne($tanggal_pemasukan);
                    isset($data_laporan) ? $model1->updateLaba($tanggal_pemasukan) : $flash_log = "";
                    $flash_log = 'Data berhasil di edit';
                  Session::flash('log',$flash_log);
                } catch (Exception $th) {
                    $flash_log = 'Data gagal di edit ';
                    Session::flash('err',$flash_log);
                }
            }
            if($param == "s"){
                $search = $request->input('q');
                return redirect("/keuangan/pendapatan/s/".$search);
            }
            return redirect ('/keuangan/pendapatan');
        }
        if($opsi == "pengeluaran"){
            if($param == "add"){
                $newData = new Pengeluaran();
                date_default_timezone_set('Asia/Jakarta');
                $today = date('dmy');
                $newData->id_pengeluaran = auth()->user()->kode_cabang . "_" . $today . $request->input('idPengeluaran');
                $newData->tujuan_pengeluaran = $request->input('tujuan_pengeluaran');
                $newData->tanggal = $request->input('tanggal');
                $newData->jumlah = $request->input('jumlah');
                $newData->keterangan = $request->input('keterangan');
                $newData->cabang = auth()->user()->cabang;
                
                try {
                    $newData->save();
                    $flash_log = 'Data berhasil di tambahkan';
                    Session::flash('log',$flash_log);
                } catch (\Throwable $th) {
                    $flash_log = "Data Gagal ditambahkan. Silahkan cek ID Pengeluaran atau Tanggal Pengeluaran";
                    Session::flash('err',$flash_log);
                }
            }
            if($param == "edit"){
                $id_lama = $request->input('idPengeluaranLama');
                $id = $request->input('idPengeluaran');
                $tujuan_pengeluaran = $request->input('tujuan_pengeluaran');
                $tanggal = $request->input('tanggal');
                $jumlah = $request->input('jumlah');
                $keterangan = $request->input('keterangan');
                try {
                    DB::table('pengeluaran')->where('id_pengeluaran',$id_lama)
                        ->update(['id_pengeluaran'=>$id,'tujuan_pengeluaran'=>$tujuan_pengeluaran,'tanggal'=>$tanggal,'jumlah'=>$jumlah,'keterangan'=>$keterangan]);
                    $data_laporan = $model1->getOne($tanggal);
                    isset($data_laporan) ? $model1->updateLaba($tanggal) : $flash_log = "";
                    $flash_log = 'Data Berhasil di Edit';
                    Session::flash('log',$flash_log);
                    } catch (\Throwable $th) {
                        $flash_log = '';
                        Session::flash('err',$flash_log . $th);
                    }
            }
            return redirect('/keuangan/pengeluaran');
        }
        if($opsi == "laporan")
        {
            if($param == 'update')
            {
                $tanggal = $request->input('tanggal');
                $beban_non_operasional = $request->input('beban_non_operasional');
                $keterangan = $request->input('keterangan');
                try {
                    DB::table('laporan_keuangan')->where('tanggal',$tanggal)
                        ->update(['beban_non_operasional'=>$beban_non_operasional,'keterangan'=>$keterangan]);
                    $data_laporan = $model1->getOne($tanggal);
                    isset($data_laporan) ? $model1->updateLaba($tanggal) : $flash_log = "";
                        $flash_log = "Laporan berhasil di update";
                        return redirect('/keuangan/laporan')->with('log',$flash_log);
                    } catch (Exception $th) {
                    $flash_log = "Data gagal di update $th";
                    return redirect('/keuangan/laporan')->with('err',$flash_log);
                }
            }
        }
        
    }
}
