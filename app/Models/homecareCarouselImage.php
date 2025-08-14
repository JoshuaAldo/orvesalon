<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homecareCarouselImage extends Model
{
    use HasFactory;

    // Tentukan field yang dapat diisi
    protected $fillable = ['title', 'image'];
    protected $table = 'homecare_carousel_images';
}
