<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customization;
use App\Models\CustomizationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        // Get the cart associated with the authenticated user
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) 
        {
            // If the cart does not exist, return an empty collection
            $cartItems = collect();
        } 
        else {
            // Fetch cart items for the authenticated user's cart
            $cartItems = CartItem::where('cart_id', $cart->id)->with('customizations', 'customizationItems')->get();
        }

        // Pass the cart items and cart ID to the view
        return view('cart.index', ['cartItems' => $cartItems, 'cart' => $cart]);
    }

    public function add(AddToCartRequest $request)
    {
        // Get the authenticated user ID
        $userId = Auth::id();

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get or create the cart for the current user
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            $cartId = $cart->id;

            $customizationData = [
                [
                    'type' => 'temperature',
                    'value' => $request->temperature,
                    'price' => 0
                ],
                [
                    'type' => 'size',
                    'value' => $request->size,
                    'price' => $request->size == '22oz' ? 30 : 0
                ],
                [
                    'type' => 'sweetness',
                    'value' => $request->sweetness,
                    'price' => 0
                ],
                [
                    'type' => 'milk',
                    'value' => $request->milk,
                    'price' => $request->milk === 'sub soymilk' ? 35 : ($request->milk === 'sub coconutmilk' ? 45 : 0)
                ],
                [
                    'type' => 'espresso',
                    'value' => $request->espresso,
                    'price' => is_array($request->espresso) && in_array('add shot', $request->espresso) ? 40 : 0
                ],                
                [
                    'type' => 'syrup',
                    'value' => $request->syrup,
                    'price' => 25
                ],
                [
                    'type' => 'special_instructions',
                    'value' => $request->special_instructions,
                    'price' => 0
                ],
            ];

            // Get all cart items with the same product
            $cartItems = CartItem::query()
                ->where('cart_id', $cartId)
                ->where('product_id', $request->product_id)
                ->get();

            $cartItem = null;

            // Check if the product with the same customizations is already in the cart
            foreach ($cartItems as $item) {

                $customizationItemsCount = $item->customizationItems()
                    ->whereIn('value', array_column($customizationData, 'value'))
                    ->count();

                $customizationDataCount = 0;
                foreach($customizationData as $customization){
                    if($customization['value'] != null){
                        $customizationDataCount += 1;
                    }
                }

                if ($customizationItemsCount == $customizationDataCount) {
                    $cartItem = $item;
                    break;
                }
            }
            
            if($cartItem)
            {   
                $cartItem->quantity += 1;
                $cartItem->save();
                // Just add the quantity
            } else {
                // Create cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $request->product_price,
                ]);

                foreach ($customizationData as $data) {
                    if($data['value'] != null) 
                    {  
                        // Find or create the customization record
                        $customization = Customization::firstOrCreate(
                            ['type' => $data['type']]);
                        $cartItem->customizations()->attach($customization->id);

                        // If the customization is an array we handle it differently
                        if(is_array($data['value'])) 
                        {
                            $values = $data['value'];
                            foreach($values as $value)
                            {
                                // Create customization item record
                                $customizationItem = CustomizationItem::firstOrCreate([
                                    'customization_id' => $customization->id,
                                    'value' => $value,
                                    'price' => $data['price'],
                                ]);

                                $cartItem->price += $customizationItem->price;
                                $cartItem->customizationItems()->attach($customizationItem->id);
                            }
                        } 
                        else {
                            // Create customization item record
                            $customizationItem = CustomizationItem::firstOrCreate([
                                'customization_id' => $customization->id,
                                'value' => $data['value'],
                                'price' => $data['price'],
                            ]);
                            
                            $cartItem->price += $customizationItem->price;
                            $cartItem->customizationItems()->attach($customizationItem->id);
                        }
                        $cartItem->save();
                    } 
                }
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

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the cart item by ID
            $cartItem = CartItem::findOrFail($id);

            // Update the quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was an issue updating your cart. Please try again.');
        }
    }

    public function remove(CartItem $cartItem)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete the cart item
            $cartItem->delete();

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect(route('cart.index'))->with('success', 'Product removed from cart successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was an issue removing the product from your cart. Please try again.');
        }
    }
}
