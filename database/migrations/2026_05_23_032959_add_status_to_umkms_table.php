<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('umkms');

        Schema::table('umkms', function (Blueprint $table) use ($columns) {
            if (!in_array('status', $columns)) {
                $table->string('status')->default('pending');
            }

            if (!in_array('catatan_admin', $columns)) {
                $table->text('catatan_admin')->nullable();
            }
        });

        DB::table('umkms')
            ->whereNull('status')
            ->update(['status' => 'pending']);
    }

    public function down(): void
    {
        $columns = Schema::getColumnListing('umkms');

        Schema::table('umkms', function (Blueprint $table) use ($columns) {
            if (in_array('catatan_admin', $columns)) {
                $table->dropColumn('catatan_admin');
            }

            // status jangan di-drop dulu biar aman karena kemungkinan sudah dipakai migration lama
        });
    }
};