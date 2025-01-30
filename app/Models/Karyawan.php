<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = "karyawan";

    protected $fillable = [
        'id_user',
        'id_karyawan',
        'nama',
        'alamat',
        'no_telp',
        'id_cabang',
        'posisi'
    ];

    public function sortByColumn($column, $by){
        return $this->where('id_cabang',auth()->user()->karyawan->cabang->id_cabang)
            ->orderBy($column, $by)->get();
    }

    public function getPerBranch()
    {
        if(auth()->user()->role === 'admin'){
            return $this->all();
        }
        return $this->where('id_cabang','=',auth()->user()->karyawan->cabang->id_cabang)
            ->get();
    }

    public function getOne($id_karyawan)
    {
        return $this->where('id_karyawan',$id_karyawan)->first();
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function cabang():BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id_cabang');
        }

}
