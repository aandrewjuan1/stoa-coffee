<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customization;
use App\Models\CustomizationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private function extractCustomizationValues($customizations)
    {
        // Put all the customization values from the request to an array to avoid having nested array
        $customizationValues = [];
        foreach ($customizations as $customization) {
            if ($customization['value'] != null) {
                if (is_array($customization['value'])) {
                    $customizationValues = array_merge($customizationValues, $customization['value']);
                } else {
                    $customizationValues[] = $customization['value'];
                }
            }
        }
        return $customizationValues;
    }

    private function checkIfTheCartItemAlreadyExists($customizations, $cartId, $productId)
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

        // Create and attach each customizations
        foreach ($customizations as $data) {
            if ($data['value'] != null) {
                // Find or create the customization record
                $customization = Customization::firstOrCreate(['type' => $data['type']]);
                $customizationIds[] = $customization->id;

                // If the customization value (ex. espresso and syrup) is an array we handle it differently
                if (is_array($data['value'])) {
                    $values = $data['value'];
                    foreach ($values as $value) {
                        // Create customization item record
                        $customizationItem = CustomizationItem::firstOrCreate([
                            'customization_id' => $customization->id,
                            'value' => $value,
                            'price' => $data['price'],
                        ]);

                        $customizationItemIds[] = $customizationItem->id;
                        $customizationPrices += $customizationItem->price;
                    }
                } else {
                    // Create customization item record
                    $customizationItem = CustomizationItem::firstOrCreate([
                        'customization_id' => $customization->id,
                        'value' => $data['value'],
                        'price' => $data['price'],
                    ]);

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

    protected function setcustomizations(Request $request): array
    {
        return [
            [
                'type' => 'temperature',
                'value' => $request->temperature,
                'price' => 0,
            ],
            [
                'type' => 'size',
                'value' => $request->size,
                'price' => $request->size == '22oz' ? 30 : 0,
            ],
            [
                'type' => 'sweetness',
                'value' => $request->sweetness,
                'price' => 0,
            ],
            [
                'type' => 'milk',
                'value' => $request->milk,
                'price' => $request->milk === 'sub soymilk' ? 35 : ($request->milk === 'sub coconutmilk' ? 45 : 0),
            ],
            [
                'type' => 'espresso',
                'value' => $request->espresso,
                'price' => is_array($request->espresso) && in_array('add shot', $request->espresso) ? 40 : 0,
            ],
            [
                'type' => 'syrup',
                'value' => $request->syrup,
                'price' => 25,
            ],
            [
                'type' => 'special_instructions',
                'value' => $request->special_instructions,
                'price' => 0,
            ],
        ];
    }

    public function addToCart(AddToCartRequest $request)
    {
        // Get the authenticated user ID
        $userId = Auth::id();

        try {

            // Start a database transaction
            DB::beginTransaction();

            // Get the customizations for the cart item
            $customizations = $this->setcustomizations($request);

            // Get or create the cart for the current user so we can insert the cart items
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            $cartId = $cart->id;

            // Check if the cart item with the same customizations already exists in the cart
            $cartItem = $this->checkIfTheCartItemAlreadyExists($customizations, $cartId, $request->product_id);

            if ($cartItem) {
                // If yes, just increment the quantity
                $cartItem->increment('quantity');
                $cartItem->save();
            } else {
                // If not, create a new cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $request->product_price,
                ]);

                // Attach the customizations in the cart item
                $this->syncCustomizations($cartItem, $customizations);
            }

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect(route('menu.index'))->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Log the error for debugging purposes
            Log::error('Error adding product to cart: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to add product to cart. Please try again.');
        }
    }

    public function edit(CartItem $cartItem)
    {
        // Get all customization values to check the boxes
        $customizationValues = $cartItem->customizationItems->pluck('value')->toArray();

        // Find the special instructions customization and its value
        $specialInstructions = null;
        $specialInstructionsId = $cartItem->customizations->where('type', 'special_instructions')->first();

        if ($specialInstructionsId) {
            $specialInstructions = $cartItem->customizationItems->where('customization_id', $specialInstructionsId->id)->first();
        }

        return view('cart.edit', [
            'cartItem' => $cartItem->load('product'),
            'customizationValues' => $customizationValues,
            'specialInstructions' => $specialInstructions ? $specialInstructions->value : null,
        ]);
    }

    public function update(UpdateCartRequest $request, CartItem $cartItem)
    {
        // Get the customizations for the cart item
        $customizations = $this->setcustomizations($request);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $this->syncCustomizations($cartItem, $customizations);

            DB::commit();

            // Redirect back with a success message
            return to_route('cart.index')->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Log the error for debugging purposes
            Log::error('Error adding product to cart: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was an issue updating your cart. Please try again.');
        }
    }
}
