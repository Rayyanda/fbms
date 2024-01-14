<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = "pengeluaran";

    public function sortByColumn($column, $by){
        return $this->where('cabang',auth()->user()->cabang)
            ->orderBy($column, $by)->get();
    }


    public function getPerBranch(){
        return $this->where('cabang',auth()->user()->cabang)
            ->orderBy('tanggal','desc')
            ->paginate(10);
    }

    public function selectColumn($column, $key)
    {
        return $this->where('cabang',auth()->user()->cabang)
            ->where($column, $key)
            ->get();
    }
    
    public function getOne($tanggal){
        return $this->where('tanggal', $tanggal)
            ->first();
    }

    public function search($keyword){
        $query = $this->where('cabang',auth()->user()->cabang)
            ->where('id_pengeluaran','LIKE',"%$keyword%")
            ->orWhere('tujuan_pengeluaran','LIKE',"%$keyword%")
            ->orWhere('jumlah',"LIKE","%$keyword%")
            ->orWhere('tanggal','LIKE',"%$keyword%")
            ->orWhere('keterangan','LIKE',"%$keyword%");
        return $query->get();
    }   
}
