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
        Schema::table('bookings', function (Blueprint $table) {
            Schema::table('bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('bookings', 'payment_token')) {
                    $table->string('payment_token')->nullable()->after('notes'); // Atau sesuaikan posisi
                }
                if (!Schema::hasColumn('bookings', 'payment_url')) {
                    $table->text('payment_url')->nullable()->after('payment_token'); // Atau sesuaikan posisi
                }
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            Schema::table('bookings', function (Blueprint $table) {
                if (Schema::hasColumn('bookings', 'payment_token')) {
                    $table->dropColumn('payment_token');
                }
                if (Schema::hasColumn('bookings', 'payment_url')) {
                    $table->dropColumn('payment_url');
                }
            });
        });
    }
};
