<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = "karyawan";

    public function sortByColumn($column, $by){
        return $this->where('cabang',auth()->user()->cabang)
            ->orderBy($column, $by)->get();
    }

    public function getPerBranch()
    {
        return $this->where('cabang',auth()->user()->cabang)
            ->get();
    }

    public function getOne($id_karyawan)
    {
        return $this->where('id_karyawan',$id_karyawan)->first();
    }

    
}
