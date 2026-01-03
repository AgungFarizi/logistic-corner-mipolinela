<?php
// File: database/migrations/xxxx_create_raks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rak')->unique(); // A1, A2, B1, dst
            $table->string('lokasi');
            $table->integer('kapasitas')->default(50);
            $table->integer('terisi')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raks');
    }
};