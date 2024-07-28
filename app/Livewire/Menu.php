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

    public function render()
    {
        $this->products = Product::search($this->searchQuery)->get();
        return view('menu.index');
    }
}
