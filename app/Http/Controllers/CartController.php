<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customization;
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

        if (!$cart) {
            // If the cart does not exist, return an empty collection
            $cartItems = collect();
        } else {
            // Fetch cart items for the authenticated user's cart
            $cartItems = CartItem::where('cart_id', $cart->id)->with('customizations')->get();
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

            // Define customizations data
            $customizations = [
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
                ]
            ];

            // Check if the product with the same customizations is already in the cart
            $cartItem = CartItem::query()
                ->where('cart_id', $cartId)
                ->where('product_id', $request->product_id)
                ->whereHas('customizations', function ($query) use ($customizations) {
                    foreach ($customizations as $customization) {
                        $query->where('type', $customization['type'])
                              ->where('value', $customization['value']);
                    }
                })
                ->first();

            // If the product with the same customization is already in the cart, update the quantity
            // dd($cartItem);
            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // If not, create a cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'price' => $request->product_price
                ]);

                // Create customization records
                foreach ($customizations as $customizationData) {
                    $customization = Customization::firstOrCreate($customizationData);
                    
                    $cartItem->price += $customization->price; // Add customization price to cart item price
                    $cartItem->customizations()->attach($customization->id); // Attach customization to cart item
                }

                $cartItem->save(); // Since we edit the cart item price, we save them after

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
