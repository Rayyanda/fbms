<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan');
            $table->unique('id_karyawan');
            $table->string('nama');
            $table->string('no_telp');
            $table->text('alamat');
            $table->string('posisi');
            $table->string('cabang');
            $table->foreign('cabang')->references('cabang')->on('cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
