<?php

namespace App\Traits;

use App\Models\CartItem;
use App\Models\Customization;
use App\Models\CustomizationItem;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait CartCustomizationTrait
{
    private function extractCustomizationValues(array $customizations): array
    {
        // Put all the customization values from the request to an array to avoid having nested array
        $customizationValues = [];
        foreach ($customizations as $type => $value) {
            if ($value === null) {
                continue; // Skip null values
            }
            
            if (is_array($value)) {
                $customizationValues = array_merge($customizationValues, $value);
            } else {
                $customizationValues[] = $value;
            }
        }

        return $customizationValues;
    }

    private function checkIfTheCartItemAlreadyExists(array $customizations, int $cartId, int $productId): ?CartItem
    {
        // Get all cart items with the same product
        $cartItems = CartItem::query()->where('cart_id', $cartId)->where('product_id', $productId)->get();

        // Get the customization values in request
        $customizationValues = $this->extractCustomizationValues($customizations);

        $cartItem = null;
        // Iterate the cart items
        foreach ($cartItems as $item) {
            // Get the customization items for the cart item
            $existingCustomizationValues = $item->customizationItems()->pluck('value')->toArray();

            // Compare the two customization items
            if (!array_diff($customizationValues, $existingCustomizationValues)) {
                $cartItem = $item;
                break;
            }
        }

        return $cartItem;
    }

    private function syncCustomizations(CartItem $cartItem, array $customizations): void
    {
        $customizationItemIds = [];
        $customizationIds = [];
        $customizationPrices = 0;

        Log::info(json_encode($customizations));

        // Attach each customization
        foreach ($customizations as $type => $value) {
            // Make sure the value is not null
            if ($value != null) {
                // Find the customization type
                $customization = Customization::where(['type' => $type])->first();
                $customizationIds[] = $customization->id;

                // If the customization value (e.g., espresso and syrup) is an array we handle it differently
                if (is_array($value)) {
                    $values = $value;
                    foreach ($values as $valueItems) {
                        // Find customization value
                        $customizationItem = CustomizationItem::where('value', $valueItems)->first();

                        $customizationItemIds[] = $customizationItem->id;
                        $customizationPrices += $customizationItem->price;
                    }
                } else {
                    // Find customization value
                    $customizationItem = CustomizationItem::firstOrCreate(['customization_id' => $customization->id, 'value' => $value]);

                    $customizationItemIds[] = $customizationItem->id;
                    $customizationPrices += $customizationItem->price;
                }
            }
        }

        $cartItem->price = $customizationPrices + $cartItem->product->price;
        $cartItem->save();

        $cartItem->customizations()->sync($customizationIds);
        $cartItem->customizationItems()->sync($customizationItemIds);
    }
}
