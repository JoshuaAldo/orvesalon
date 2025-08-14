<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Jika tidak menggunakan HasFactory

class Service extends Model
{
    // use HasFactory; // Jika Anda menggunakan factory

    protected $fillable = ['name', 'price', 'promo_price'];

    public function bookings()
    {
        return $this->hasMany(Booking::class); // Asumsi Booking punya service_id
    }

    // Relasi baru
    public function hairdressers()
    {
        return $this->belongsToMany(Hairdresser::class, 'hairdresser_service');
    }

    // Relasi baru jika diperlukan untuk query dari Service ke Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
