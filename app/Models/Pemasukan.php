<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;
    protected $table = "pemasukan";

    public function search($query){
        return self::where('sumber_pemasukan', 'LIKE', "%$query%")->orWhere('jumlah', '
        LIKE', "%$query%")->paginate(10);
        
    }

    public function getById($id_pendapatan)
    {
        return $this->where('id_pemasukan',$id_pendapatan)->first();
    }
    public function getPerBranch()
    {
        return $this->where("cabang", auth()->user()->cabang)
            ->orderBy('tanggal_masuk','desc')
            ->paginate(10);
    }
    public function selectColumn($column, $key)
    {
        return $this->where("cabang", auth()->user()->cabang)
            ->where($column, $key)
            ->get();
    }
    public function getOne($tanggal_masuk){
        return $this->where('tanggal_masuk', $tanggal_masuk)
            ->first();
    }
}
