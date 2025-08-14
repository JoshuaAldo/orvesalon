<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partnership extends Model
{
    protected $fillable = [
        'desktop_image_path',
        'mobile_image_path',
        'alt_text',
        'is_active'
    ];


    protected static function booted()
    {
        // When a banner is set as active, deactivate all others
        static::updated(function ($banner) {
            if ($banner->isDirty('is_active') && $banner->is_active) {
                self::where('id', '!=', $banner->id)
                    ->update(['is_active' => false]);
            }
        });

        // Delete associated files when banner is deleted
        static::deleting(function ($banner) {
            if ($banner->desktop_image_path) {
                Storage::disk('public')->delete($banner->desktop_image_path);
            }
            if ($banner->mobile_image_path) {
                Storage::disk('public')->delete($banner->mobile_image_path);
            }
        });
    }

    // Accessor for desktop image URL
    public function getDesktopImageUrlAttribute()
    {
        return $this->desktop_image_path
            ? asset('storage/' . $this->desktop_image_path)
            : null;
    }

    // Accessor for mobile image URL
    public function getMobileImageUrlAttribute()
    {
        return $this->mobile_image_path
            ? asset('storage/' . $this->mobile_image_path)
            : null;
    }


    public function deleteWithFile()
    {
        if ($this->desktop_image_path) {
            Storage::disk('public')->delete($this->desktop_image_path);
        }
        if ($this->mobile_image_path) {
            Storage::disk('public')->delete($this->mobile_image_path);
        }

        return $this->delete();
    }
}
