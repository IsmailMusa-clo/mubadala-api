<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $hidden = [
        'product_id',
        'sender_id',
        'receiver_id',
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function sender()
    // {
    //     return $this->belongsTo(User::class, 'sender_id');
    // }

    // public function receiver()
    // {
    //     return $this->belongsTo(User::class, 'reciver_id');
    // }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
