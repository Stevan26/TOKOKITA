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
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // Primary Key, Auto Increment, BigInt
            $table->string('nama_produk'); // VARCHAR — teks pendek
            $table->integer('harga'); // INT — angka nominal/harga
            $table->text('deskripsi')->nullable(); // TEXT — boleh dikosongkan
            $table->integer('stok')->default(0); // INT — default 0 jika tidak diisi
            $table->timestamps(); // created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
