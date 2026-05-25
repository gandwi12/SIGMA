<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->nullable()->constrained('umkms')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->integer('harga');
            $table->integer('kalori')->default(0);
            $table->integer('protein')->default(0);
            $table->integer('lemak')->default(0);
            $table->integer('karbo')->default(0);
            $table->string('tag')->nullable();
            $table->string('gambar')->nullable();
            $table->decimal('rating', 2, 1)->default(4.8);
            $table->string('jarak')->default('0.5 km');
            $table->string('waktu')->default('12 mnt');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};