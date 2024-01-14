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
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->unique('tanggal');
            $table->string('id_pendapatan');
            $table->foreign('id_pendapatan')->references('id_pemasukan')->on('pemasukan');
            $table->string('id_pengeluaran');
            $table->foreign('id_pengeluaran')->references('id_pengeluaran')->on('pengeluaran');
            $table->integer('beban_non_operasional')->nullable();
            $table->integer('laba_kotor');
            $table->integer('laba_bersih');
            $table->text('keterangan');
            $table->string('cabang');
            $table->foreign('cabang')->references('nama_cabang')->on('cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};
