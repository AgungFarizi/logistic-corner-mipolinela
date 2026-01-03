<?php
// File: database/migrations/xxxx_create_pakets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('no_resi')->unique();
            $table->string('nama_penerima');
            $table->string('no_whatsapp');
            $table->string('ekspedisi');
            $table->string('rak');
            $table->decimal('berat', 8, 2); // dalam kg
            $table->date('tanggal_masuk');
            $table->date('batas_pengambilan');
            $table->date('tanggal_diambil')->nullable();
            $table->enum('status', ['menunggu', 'diambil', 'dikembalikan'])->default('menunggu');
            $table->integer('hari_telat')->default(0);
            $table->decimal('denda', 10, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->boolean('notifikasi_terkirim')->default(false);
            $table->timestamp('waktu_notifikasi')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index('no_resi');
            $table->index('nama_penerima');
            $table->index('status');
            $table->index('tanggal_masuk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};