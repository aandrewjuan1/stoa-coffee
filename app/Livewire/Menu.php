<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Product;

class Menu extends Component
{
    #[Url(as: 'q')]
    public string $searchQuery = '';
    public Collection $products;

    public function loadProducts(): void
    {
        $this->products = Product::where('name', 'like', "%{$this->searchQuery}%")
            ->orWhereHas('categories', function ($query) {
                $query->where('name', 'like', "%{$this->searchQuery}%");
            })
            ->get();
    }

    public function placeholder()
    {
        return view('livewire.menu-skeleton');
    }

    public function render()
    {
        $this->loadProducts();
        return view('menu.index');
    }
}
