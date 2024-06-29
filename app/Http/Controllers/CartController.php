<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $cartItems = CartItem::where('cart_id', $cart->id)->get();
        }

        // Pass the cart items and cart ID to the view
        return view('cart.index', ['cartItems' => $cartItems, 'cart' => $cart]);
    }

    public function add(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Get the authenticated user ID
            $userId = Auth::id();

            // Get the cart ID associated with the authenticated user
            $cart = Cart::where('user_id', $userId)->first();

            if (!$cart) {
                // If the cart does not exist, create a new cart for the user
                $cart = Cart::create(['user_id' => $userId]);
            }

            $cartId = $cart->id;

            // Check if the product is already in the cart
            $cartItem = CartItem::where('cart_id', $cartId)
                                ->where('product_id', $request->product_id)
                                ->first();

            if ($cartItem) {
                // If the product is already in the cart, update the quantity
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                // Otherwise, create a new cart item
                CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            return redirect(route('menu.index'))->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was an issue adding the product to your cart. Please try again.');
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
