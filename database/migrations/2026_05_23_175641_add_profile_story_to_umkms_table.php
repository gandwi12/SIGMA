<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('sejarah_judul')->nullable();
            $table->text('sejarah_deskripsi')->nullable();

            $table->string('filosofi_1_judul')->nullable();
            $table->text('filosofi_1_deskripsi')->nullable();

            $table->string('filosofi_2_judul')->nullable();
            $table->text('filosofi_2_deskripsi')->nullable();

            $table->string('filosofi_3_judul')->nullable();
            $table->text('filosofi_3_deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn([
                'sejarah_judul',
                'sejarah_deskripsi',
                'filosofi_1_judul',
                'filosofi_1_deskripsi',
                'filosofi_2_judul',
                'filosofi_2_deskripsi',
                'filosofi_3_judul',
                'filosofi_3_deskripsi',
            ]);
        });
    }
};