<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'id_user' => Str::uuid(),
            "name"=> "Mr. Han",
            "email"=> "admin@gmail.com",
            "password"=> Hash::make("satu2tiga4_"),
            "role"=>"admin"
        ];
        DB::table("users")->insert($data);
    }
}
