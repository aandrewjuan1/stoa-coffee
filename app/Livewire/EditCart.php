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
        // Get the existing customizations IDS in cart items so we can get the customization values later
        $stringCustomizationIds = $this->cartItem->customizations()->where('input_field', '!=', 'check_box')->pluck('customizations.id', 'type')->toArray();
        $arrayCustomizationsIds = $this->cartItem->customizations()->where('input_field', 'check_box')->pluck('customizations.id', 'type')->toArray();

        // Set the types where their values is either string or array
        $stringCustomizationsTypes = ['temperature', 'size', 'sweetness', 'milk', 'special_instructions'];
        $arrayCustomizationsTypes = ['espresso', 'syrup'];

        // Set the existing customization in the form properties
        $this->setValuesInFormProperties($stringCustomizationsTypes, $stringCustomizationIds, false);
        $this->setValuesInFormProperties($arrayCustomizationsTypes, $arrayCustomizationsIds, true);
    }

    protected function setValuesInFormProperties(array $customizationsTypes, array $customizationIds, bool $isArray): void
    {
        foreach ($customizationsTypes as $type) {
            // Check if type exists in the cart item's customizations
            if (!array_key_exists($type, $customizationIds)) {
                continue;
            }

            // Get the customization ID if it exists in the cart item's customizations
            $typeId = $customizationIds[$type];

            // Get the customization values for each cart item using the customizations IDS we got earlier
            $this->form->$type = $isArray 
                ? $this->cartItem->customizationItems()->where('customization_id', $typeId)->pluck('value')->toArray()
                : $this->cartItem->customizationItems()->where('customization_id', $typeId)->pluck('value')->first();
        }
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->dispatch('close-modal', 'edit-cart');
            $this->dispatch('load-cart', 'edit-cart');

            $customizations = $this->form->all();
            $this->syncCustomizations($this->cartItem, $customizations);

            $this->dispatch('show-message', message : 'Cart updated', color : 'text-blue-600');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error adding product to cart: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.edit-cart');
    }
}
