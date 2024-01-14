<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BahanBaku extends Model
{
    use HasFactory;
    protected $table = "bahan_baku";

    public function getPerBranch()
    {
        return $this->where('cabang',auth()->user()->cabang)
            ->orderBy("terakhir_update",'desc')
            ->paginate(10);
    }
    public function checkAvailability(string $name)
    {
        return $this->where("nama_bahan_baku", "LIKE", "%$name%")->first();
    }

    public function getByDate($date)
    {
        return $this->where("terakhir_update",$date)
            ->where('cabang',auth()->user()->cabang)
            ->get();
    }

    public function AddToExpense($date, $newValue)
    {
       
        $this->where('terakhir_update',$date)
            ->update(['id_pengeluaran'=>$newValue]);
    }
}
