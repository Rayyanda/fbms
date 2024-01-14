<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create("id_ID");
        for ($i=1; $i < 10; $i++) { 
            DB::table('karyawan')->insert([
                'id_karyawan'=> "cbt-2021000".$i,
                'nama'=> $faker->name(),
                'no_telp'=>$faker->phoneNumber(),
                'posisi'=>'staf',
                'cabang'=>'Cibitung',
            ]);
        }
    }
}
