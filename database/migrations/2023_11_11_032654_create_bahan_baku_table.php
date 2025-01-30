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
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('id_bahan_baku');
            $table->unique('id_bahan_baku');
            $table->string('nama_bahan_baku');
            $table->string('satuan');
            $table->integer('harga_satuan');
            $table->integer('stok');
            $table->dateTime('terakhir_update');
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
        Schema::dropIfExists('bahan_baku');
    }
};
