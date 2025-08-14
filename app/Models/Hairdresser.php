<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hairdresser extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'hairdresser_location');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'hairdresser_service');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // Contoh jika booking terhubung ke hairdresser melalui schedule
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Schedule::class);
    }
}
