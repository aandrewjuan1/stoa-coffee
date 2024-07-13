<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cart extends Component
{
    protected $cart;
    protected $cartItems;

    public function mount()
    {
        // Load cart and cart items on component initialization
        $this->loadCart();
    }

    public function render()
    {
        return view('cart.index', [
            'cartItems' => $this->cartItems,
            'cart' => $this->cart,
        ]);
    }

    private function loadCart()
    {
        // Get the cart associated with the authenticated user
        $this->cart = CartModel::where('user_id', Auth::id())->first();

        if ($this->cart) {
            // Fetch cart items for the authenticated user's cart
            $this->cartItems = CartItem::where('cart_id', $this->cart->id)
                ->with('customizations', 'customizationItems')
                ->get();
        } else {
            // If the cart does not exist, set cart items to an empty collection
            $this->cartItems = collect();
        }
    }

    public function incrementQuantity(CartItem $cartItem)
    {
        if ($cartItem->quantity < 99) {
            // Example limit on quantity increment
            $cartItem->quantity += 1;
            $cartItem->save();
            $this->loadCart();
        }
    }

    public function decrementQuantity(CartItem $cartItem)
    {
        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
            $this->loadCart();
        }
        $this->loadCart();
    }

    public function remove(CartItem $cartItem)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete the cart item
            $cartItem->delete();
            $this->loadCart();
            // Commit the transaction
            DB::commit();

            // Redirect back with a success message
            session()->flash('removed-success', 'Product removed');
        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            // Redirect back with an error message
            session()->flash('error', 'There was an issue removing the product from your cart. Please try again.');
        }
    }
}
