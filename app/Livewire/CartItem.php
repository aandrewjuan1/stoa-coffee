<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem as Item;

class CartItem extends Component
{
    public Item $item;

    public function render()
    {
        return view('cart.cart-item');
    }
}
