<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Jika tidak menggunakan HasFactory

class Location extends Model
{
    // use HasFactory; // Jika Anda menggunakan factory

    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class); // Asumsi Booking punya location_id
    }

    // Relasi baru
    public function hairdressers()
    {
        return $this->belongsToMany(Hairdresser::class, 'hairdresser_location');
    }
}
