<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\CartItem as Item;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;

class CartItem extends Component
{
    public Model $item;

    public function render()
    {
        return view('cart.cart-item');
    }
}
