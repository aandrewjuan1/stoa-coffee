<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customization;
use Illuminate\Database\Eloquent\Collection;

class ShowCustomization extends Component
{
    public Collection $customizations;
    public Customization $customization;

    public function mount()
    {
        $this->customizations = Customization::where('type', '!=', 'special_instructions')->with('customizationItems')->get();
    }
    public function render()
    {
        return view('livewire.show-customization');
    }

    public function delete(Customization $customization): void
    {
        $customization->delete();
        $this->redirect(route('customizations.create'), navigate: true);
    }
}
