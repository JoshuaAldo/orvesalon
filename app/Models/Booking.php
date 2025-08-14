<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->uuid = Str::uuid();
        });
    }
    protected $fillable = [
        'uuid',
        'name', // Ganti menjadi 'name' jika nama kolom di tabel adalah 'name'
        'phone', // Ganti menjadi 'phone' jika nama kolom di tabel adalah 'phone'
        'email', // Ganti menjadi 'email' jika nama kolom di tabel adalah 'email'
        'address',
        'service_id',
        'price',   // Ganti menjadi 'price' jika nama kolom di tabel adalah 'price'
        'status',
        'schedule_id',
        'location_id',
        'hairdresser_id', // Kolom baru
        'booking_time',   // Kolom baru
        'notes',
        'payment_token',  // Kolom baru
        'payment_url',    // Kolom baru
    ];

    protected $casts = [
        'booking_time' => 'datetime',
        'price' => 'decimal:2', // Sesuaikan jika tipe data harga berbeda
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class);
    }
}
