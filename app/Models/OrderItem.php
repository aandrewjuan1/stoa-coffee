<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
 
    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customizations()
    {
        return $this->belongsToMany(Customization::class)->withTimestamps();
    }
    public function customizationItems()
    {
        return $this->belongsToMany(CustomizationItem::class)->withTimestamps();
    }
}
