<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scanner_results', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nama_makanan');
            $table->string('estimasi_kalori');
            $table->string('confidence')->default('95%');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scanner_results');
    }
};