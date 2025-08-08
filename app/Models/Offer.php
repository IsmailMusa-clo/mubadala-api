<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'location',
        'user_id',
        'product_id',
        'status'
    ];

    protected static function booted()
    {
        static::deleting(function ($offer) {
            foreach ($offer->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
                $image->delete();
            }
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function exchange()
    {
        return $this->hasOne(Exchange::class);
    }

    public function images()
    {
        return $this->hasMany(OfferImage::class);
    }
}
