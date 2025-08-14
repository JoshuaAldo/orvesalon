<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Jika tidak menggunakan HasFactory

class Schedule extends Model
{
    // use HasFactory; // Jika Anda menggunakan factory

    // PENTING: Update $fillable sesuai kolom baru
    protected $fillable = [
        'available_at',
        'location_id',
        'hairdresser_id', // Baru
        'service_id',     // Baru
    ];

    protected $casts = [
        'available_at' => 'datetime'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    // Relasi baru
    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class);
    }

    // Relasi baru
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class); // Asumsi Booking punya schedule_id
    }
}
