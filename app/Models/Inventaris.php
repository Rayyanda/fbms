<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;
    protected $table = 'inventaris';

    public function getPerBranch()
    {
        return $this->where('cabang',auth()->user()->cabang)
            ->get();
    }
    public function getOne($id_inventaris)
    {
        return $this->where('id_inventaris',$id_inventaris)
            ->first();
    }

}
