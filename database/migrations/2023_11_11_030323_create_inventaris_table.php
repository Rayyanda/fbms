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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('id_inventaris');
            $table->unique('id_inventaris');
            $table->string('nama_inventaris');
            $table->string('jenis_inventaris');
            $table->string('satuan');
            $table->integer('harga_satuan');
            $table->integer('stok_minimum');
            $table->integer('stok_maksimum');
            $table->string('lokasi_penyimpanan');
            $table->string('kondisi');
            $table->string('cabang');
            $table->foreignUuid('id_cabang')->references('id_cabang')->on('cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
