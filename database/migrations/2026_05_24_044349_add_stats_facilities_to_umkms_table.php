<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('stat_1_value')->nullable();
            $table->string('stat_1_label')->nullable();

            $table->string('stat_2_value')->nullable();
            $table->string('stat_2_label')->nullable();

            $table->string('stat_3_value')->nullable();
            $table->string('stat_3_label')->nullable();

            $table->string('fasilitas_1')->nullable();
            $table->string('fasilitas_2')->nullable();
            $table->string('fasilitas_3')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn([
                'stat_1_value',
                'stat_1_label',
                'stat_2_value',
                'stat_2_label',
                'stat_3_value',
                'stat_3_label',
                'fasilitas_1',
                'fasilitas_2',
                'fasilitas_3',
            ]);
        });
    }
};