<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "name"=> "Mr. Han",
            "email"=> "ydrs.cbt@gmail.com",
            "password"=> Hash::make("satu2tiga4_"),
            "cabang"=> "Cibitung",
        ];
        DB::table("users")->insert($data);
    }
}
