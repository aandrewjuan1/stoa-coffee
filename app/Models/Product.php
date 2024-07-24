<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function customizations(): BelongsToMany
    {
        return $this->belongsToMany(Customization::class)->withTimestamps();
    }
    public function customizationItems(): BelongsToMany
    {
        return $this->belongsToMany(CustomizationItem::class)->withTimestamps();
    }

    public function scopeSearch($query, $searchQuery): void
    {
        $searchQuery = trim($searchQuery);
        
        $query->where('name', 'like', "%{$searchQuery}%")
            ->orWhereHas('categories', function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%");
            });
    }
}
