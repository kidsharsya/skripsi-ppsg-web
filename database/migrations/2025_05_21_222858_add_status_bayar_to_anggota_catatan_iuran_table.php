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
        Schema::table('anggota_catatan_iuran', function (Blueprint $table) {
            $table->boolean('status_bayar')->default(false)->after('catatan_iuran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota_catatan_iuran', function (Blueprint $table) {
            $table->dropColumn('status_bayar');
        });
    }
};
