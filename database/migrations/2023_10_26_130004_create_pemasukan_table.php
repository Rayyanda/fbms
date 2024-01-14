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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->string('id_pemasukan');
            $table->unique('id_pemasukan');
            $table->string('sumber_pemasukan');
            $table->dateTime('tanggal_masuk')->nullable()->default(now());
            $table->integer('jumlah');
            $table->text('keterangan');
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
        Schema::dropIfExists('pemasukan');
    }
};
