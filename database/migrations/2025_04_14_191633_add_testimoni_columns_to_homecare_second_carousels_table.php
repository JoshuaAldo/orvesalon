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
        Schema::table('homecare_second_carousels', function (Blueprint $table) {
            $table->text('testimoni')->nullable()->after('image');
            $table->string('nama')->nullable()->after('testimoni');
            $table->string('lokasi_tinggal')->nullable()->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homecare_second_carousels', function (Blueprint $table) {
            $table->dropColumn(['testimoni', 'nama', 'lokasi_tinggal']);
        });
    }
};
