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
        Schema::table('arsip_rapats', function (Blueprint $table) {
            $table->string('judul_rapat')->after('id');
            $table->date('tanggal_rapat')->after('judul_rapat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip_rapats', function (Blueprint $table) {
            //
        });
    }
};
