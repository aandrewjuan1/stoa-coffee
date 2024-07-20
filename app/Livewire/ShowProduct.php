<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ShowProduct extends Component
{
    public Product $product;

    #[On('show-product')]
    public function showProduct($id): void
    {
        $this->product = Product::find($id);
        $this->dispatch('open-modal', 'show-product');
    }

    public function render()
    {
        return view('livewire.show-product');
    }
}
