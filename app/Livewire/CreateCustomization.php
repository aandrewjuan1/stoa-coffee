<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customization;
use App\Models\CustomizationItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CreateCustomization extends Component
{
    public string $type;
    public string $value;
    public float $valuePrice;
    public string $inputField = 'radio_button';
    public bool $required = false;

    public int $customizationId;
    
    public function render()
    {
        return view('livewire.create-customization');
    }

    public function create(): void
    {
        DB::beginTransaction();
        
        try {
            $customization = Customization::create([
                'type' => $this->type,
                'input_field' => $this->inputField,
                'required' => $this->required,
            ]);
    
            CustomizationItem::create([
                'customization_id' => $customization->id,
                'value' => $this->value,
                'price' => $this->valuePrice,
            ]);
            $this->reset();
            DB::commit();
            $this->redirect(route('customizations.create'), navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
