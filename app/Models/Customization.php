<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customizationItems()
    {
        return $this->hasMany(CustomizationItem::class);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = strtolower($value);
    }

    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class)->withTimestamps();
    }

    public function cartItems()
    {
        return $this->belongsToMany(CartItem::class)->withTimestamps();
    }
}
