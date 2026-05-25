<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_usaha');
            $table->string('pemilik')->nullable();
            $table->string('kategori');
            $table->string('lokasi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('whatsapp');
            $table->string('jam_operasional');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};