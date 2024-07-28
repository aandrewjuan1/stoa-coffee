<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ShowCategory extends Component
{
    public Category $category;

    public function delete(Category $category): void
    {
        $category->delete();
        $this->redirect(route('categories.create'), navigate: true);
    }
    public function render()
    {
        return view('livewire.show-category');
    }
}
