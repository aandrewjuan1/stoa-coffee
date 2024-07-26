<?php

namespace App\Livewire;

use App\Livewire\Forms\MenuForm;
use App\Models\Product;
use App\Traits\CartCustomizationTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;

class ShowProduct extends Component
{
    use CartCustomizationTrait;

    public Product $product;

    public MenuForm $form;

    #[On('show-product')]
    public function showProduct($id): void
    {
        if (!Auth::check())
        {
            $this->redirect('login');
            return;
        }

        $this->product = Product::with('customizations.customizationItems')->find($id);
        $this->form->reset();
        $this->form->resetValidation();
        $this->dispatch('open-modal', 'show-product');
    }

    public function render()
    {
        return view('livewire.show-product');
    }

    public function addTocart()
    {
        $this->authorize('buyer');
        $this->validate();

        // Get the authenticated user ID
        $userId = Auth::id();

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Get the customizations for the cart item
            $customizations = $this->form->all();

            // Get or create the cart for the current user so we can insert the cart items
            $cart = Cart::firstOrCreate(['user_id' => $userId]);
            $cartId = $cart->id;

            // Check if the cart item with the same customizations already exists in the cart
            $cartItem = $this->checkIfTheCartItemAlreadyExists($customizations, $cartId, $this->product->id);

            if ($cartItem) {
                // If yes, just increment the quantity
                $cartItem->increment('quantity');
                $cartItem->save();
            } else {
                // If not, create a new cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $this->product->id,
                    'quantity' => 1,
                    'price' => $this->product->price,
                ]);

                // Attach the customizations in the cart item
                $this->syncCustomizations($cartItem, $customizations);
            }
            
            // Commit the transaction
            DB::commit();

            $this->dispatch('add-to-cart-success-message', "{$this->product->name} added successfully");
            $this->dispatch('close-modal', 'show-product');

        } catch (\Exception $e) {
            // Rollback the transaction if there's an error
            DB::rollBack();

            Log::error('Error adding product to cart: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to add product to cart. Please try again.');
        }
    }
}
