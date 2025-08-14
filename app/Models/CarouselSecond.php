<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselSecond extends Model
{
    use HasFactory;

    // Tentukan field yang dapat diisi
    protected $fillable = ['title', 'image', 'description'];
    protected $table = 'carousel_second';
}
