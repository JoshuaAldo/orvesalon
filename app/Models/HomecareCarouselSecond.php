<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomecareCarouselSecond extends Model
{
    use HasFactory;

    // Tentukan field yang dapat diisi
    protected $fillable = [
        'title',
        'image',
        'testimoni',
        'nama',
        'lokasi_tinggal'
    ];
    protected $table = 'homecare_second_carousels';
}
