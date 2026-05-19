<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('icon');
            $table->string('whatsapp')->nullable()->after('lokasi');
            $table->string('jam_operasional')->nullable()->after('whatsapp');
            $table->string('kategori')->nullable()->after('jam_operasional');
            $table->string('foto')->nullable()->after('kategori');
            $table->string('status')->default('active')->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'whatsapp', 'jam_operasional', 'kategori', 'foto', 'status']);
        });
    }
};
