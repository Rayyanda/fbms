<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Cabang::create([
            'id_cabang'=> Str::uuid(),
            'nama_cabang' => 'Naraseafood',
            'alamat' => 'Jl. Raya No. 2',
            'telepon' => '08123439789',
            'email' => 'naraseafood@gmail.com',
        ]);
    }
}
