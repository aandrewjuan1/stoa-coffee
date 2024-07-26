<?php

namespace App\Livewire;

use App\Livewire\Forms\CartForm;
use App\Models\Buyer;
use App\Models\CartItem;
use App\Traits\CartCustomizationTrait;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditCart extends Component
{
    use CartCustomizationTrait;
    public CartItem $cartItem;
    
    public CartForm $form;

    #[On('edit-cart')]
    public function editCart($id): void
    {
        $this->cartItem = CartItem::with('product','customizations.customizationItems')->find($id);
        $this->form->reset();
        $this->setExistingCustomizations();

        $this->dispatch('open-modal', 'edit-cart');
    }
    
    protected function setExistingCustomizations(): void
    {
        $stringCustomizationIds = $this->cartItem->customizations()->where('input_field', '!=', 'check_box')->pluck('customizations.id', 'type')->toArray();
        $arrayCustomizationsIds = $this->cartItem->customizations()->where('input_field', 'check_box')->pluck('customizations.id', 'type')->toArray();

        $stringCustomizations = ['temperature', 'size', 'sweetness', 'milk', 'special_instructions'];
        $arrayCustomizations = ['espresso', 'syrup'];

        $this->setCustomizations($stringCustomizations, $stringCustomizationIds, false);
        $this->setCustomizations($arrayCustomizations, $arrayCustomizationsIds, true);
    }

    protected function setCustomizations(array $customizations, array $customizationIds, bool $isArray): void
    {
        foreach ($customizations as $property) {
            if (!array_key_exists($property, $customizationIds)) {
                continue;
            }

            $typeId = $customizationIds[$property];
            $this->form->$property = $isArray 
                ? $this->cartItem->customizationItems()->where('customization_id', $typeId)->pluck('value')->toArray()
                : $this->cartItem->customizationItems()->where('customization_id', $typeId)->pluck('value')->first();
        }
    }

    public function update()
    {
        $this->authorize('buyer');
        $this->validate();
        $this->syncCustomizations($this->cartItem, $this->form->all());

        $this->dispatch('close-modal', 'edit-cart');
        $this->dispatch('load-cart', 'edit-cart');
    }
    
    public function render()
    {
        return view('livewire.edit-cart');
    }
}
