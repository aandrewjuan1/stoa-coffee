<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(CartItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customizations()
    {
        return $this->belongsToMany(Customization::class)
                    ->withTimestamps();
    }
    public function customizationItems()
    {
        return $this->belongsToMany(CustomizationItem::class)
                    ->withTimestamps();
    }
}
