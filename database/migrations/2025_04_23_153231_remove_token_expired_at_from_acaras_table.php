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
        Schema::table('acaras', function (Blueprint $table) {
            $table->dropColumn('token_expired_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acaras', function (Blueprint $table) {
            $table->timestamp('token_expired_at')->nullable();
        });
    }
};
