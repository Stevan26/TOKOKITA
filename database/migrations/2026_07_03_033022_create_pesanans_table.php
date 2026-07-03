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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke pelanggan
            $table->string('paket'); // reguler, deep_clean, premium
            $table->integer('jumlah_sepatu');
            $table->json('layanan_tambahan')->nullable(); // Menyimpan banyak add-ons sekaligus
            $table->integer('total_biaya');
            $table->string('status')->default('Menunggu Pembayaran'); // Status awal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
