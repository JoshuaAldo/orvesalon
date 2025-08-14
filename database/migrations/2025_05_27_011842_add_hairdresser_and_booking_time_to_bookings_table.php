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
            // Tambahkan foreign key untuk hairdresser_id setelah location_id atau kolom relevan lainnya
            $table->foreignId('hairdresser_id')
                ->nullable() // Jadikan nullable jika ada booking lama yang tidak memiliki hairdresser_id
                ->after('location_id') // Sesuaikan posisi jika perlu
                ->constrained('hairdressers') // Asumsi nama tabel hairdresser adalah 'hairdressers'
                ->onDelete('set null'); // Atau onDelete('cascade') jika booking harus dihapus saat hairdresser dihapus

            // Tambahkan kolom booking_time (datetime) setelah notes atau kolom relevan lainnya
            // Ini akan menyimpan waktu pasti booking yang dipilih pengguna,
            // yang seharusnya sama dengan schedules.available_at untuk schedule_id yang terkait.
            $table->dateTime('booking_time')->nullable()->after('notes'); // Sesuaikan posisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus constraint foreign key terlebih dahulu sebelum menghapus kolom
            // Nama constraint biasanya: nama_tabel_nama_kolom_foreign
            // Laravel 8+ bisa otomatis mendeteksi jika hanya array kolom yang diberikan
            if (Schema::hasColumn('bookings', 'hairdresser_id')) {
                $table->dropForeign(['hairdresser_id']);
                $table->dropColumn('hairdresser_id');
            }
            if (Schema::hasColumn('bookings', 'booking_time')) {
                $table->dropColumn('booking_time');
            }
        });
    }
};
