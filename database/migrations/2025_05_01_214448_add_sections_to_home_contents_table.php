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
        Schema::table('home_contents', function (Blueprint $table) {
            $table->string('section1')->nullable();
            $table->string('section2')->nullable();
            $table->string('section3')->nullable();
            $table->string('section4')->nullable();
            $table->string('section5')->nullable();
            $table->string('section6')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_contents', function (Blueprint $table) {
            $table->dropColumn([
                'section1', 'section2', 'section3',
                'section4', 'section5', 'section6'
            ]);
        });
    }
};
