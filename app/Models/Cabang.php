<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $fillable = [
        'id_cabang',
        'nama_cabang',
        'alamat',
        'telepon',
        'email',
        // 'id_kota',
        // 'id_provinsi',
        // 'id_negara',
        // 'id_kabupaten',
        // 'id_kecamatan',
        // 'id_desa',
        // 'id_kelurahan',
        // 'id_wilayah',
        // 'id_jenis_cabang',
        // 'id_jenis_cabang_lain',
        // 'id_jenis_cabang_lain2',
        // 'id_jenis_cabang_lain3',
    ];
}
