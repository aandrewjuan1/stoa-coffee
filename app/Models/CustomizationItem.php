<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomizationItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customization()
    {
        return $this->belongsTo(Customization::class);
    }

    public function cartItems()
    {
        return $this->belongsToMany(CartItem::class)->withTimestamps();
    }
    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class)->withTimestamps();
    }
}
