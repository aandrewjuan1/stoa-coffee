<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CreateCategory extends Component
{
    public Collection $categories;
    public function mount()
    {
        $this->categories = Category::all();
    }
    public function render()
    {
        return view('livewire.create-category');
    }
}
