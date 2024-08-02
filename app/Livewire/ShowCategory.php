<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ShowCategory extends Component
{
    public Category $category;
    
    public string $editingName;

    public function delete(Category $category): void
    {
        $category->delete();
        $this->redirect(route('categories.create'), navigate: true);
    }

    public function edit(Category $category): void
    {
        $this->editingName = $category->name;
    }

    public function save(): void
    {   
        $this->category->update([
            'name' => $this->editingName
        ]);

        $this->reset('editingName');
    }

    public function cancel(): void
    {
        $this->reset('editingName');
    }
    
    public function render()
    {
        return view('livewire.show-category');
    }
}
