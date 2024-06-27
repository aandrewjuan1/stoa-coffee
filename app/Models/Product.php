<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
    }
}
