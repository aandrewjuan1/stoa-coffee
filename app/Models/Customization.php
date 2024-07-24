<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customization extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function scopeRequired($query): void
    {
        $query->where('required', true);
    }
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = strtolower($value);
    }
    public function customizationItems()
    {
        return $this->hasMany(CustomizationItem::class);
    }


    public function orderItems()
    {
        return $this->belongsToMany(OrderItem::class)->withTimestamps();
    }

    public function cartItems()
    {
        return $this->belongsToMany(CartItem::class)->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
