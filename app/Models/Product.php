<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::deleting(function ($product) {
            foreach ($product->images as $image) {
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


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function exchange()
    {
        return $this->hasOne(Exchange::class);
    }
}
