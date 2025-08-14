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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment primary key
            $table->dateTime('available_at'); // Tanggal dan jam spesifik ketersediaan

            // Foreign key ke tabel locations
            // Pastikan tabel 'locations' sudah ada (dibuat oleh migrasi sebelumnya)
            $table->foreignId('location_id')
                ->constrained('locations')
                ->onDelete('cascade'); // Jika lokasi dihapus, jadwal terkait juga dihapus

            // Foreign key ke tabel hairdressers
            // Pastikan tabel 'hairdressers' sudah ada (dibuat oleh migrasi sebelumnya)
            $table->foreignId('hairdresser_id')
                ->constrained('hairdressers')
                ->onDelete('cascade'); // Jika hairdresser dihapus, jadwal terkait juga dihapus

            // Foreign key ke tabel services
            // Pastikan tabel 'services' sudah ada (dibuat oleh migrasi sebelumnya)
            $table->foreignId('service_id')
                ->constrained('services')
                ->onDelete('cascade'); // Jika service dihapus, jadwal terkait juga dihapus

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
