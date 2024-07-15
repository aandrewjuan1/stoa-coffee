<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Order;
use App\Models\OrderItem;

class Cart extends Component
{
    public $selectedItems;
    protected $cart;
    protected $cartItems;

    #[Validate(['selectedItems' => 'required|array', 'selectedItems.*' => 'exists:cart_items,id'])]
    public function mount()
    {
        $this->loadCart();
        $this->setSelectedItems();
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
        $this->cart = CartModel::firstWhere('user_id', Auth::id());

        $this->cartItems = $this->cart
            ? CartItem::with('customizations', 'customizationItems')
                ->where('cart_id', $this->cart->id)
                ->get()
            : collect();
    }

    private function setSelectedItems()
    {
        $this->selectedItems = $this->cartItems->where('is_checked', true)->pluck('id')->toArray();
    }

    private function calculateTotalPrice()
    {
        return $this->cartItems->sum(fn($item) => $item->price * $item->quantity);
    }

    public function incrementQuantity(CartItem $cartItem)
    {
        if ($cartItem->quantity < 99) {
            $cartItem->increment('quantity');
        }
        $this->loadCart();
    }

    public function decrementQuantity(CartItem $cartItem)
    {
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }
        $this->loadCart();
    }

    public function deleteItems()
    {
        if ($this->selectedItems) {
            CartItem::whereIn('id', $this->selectedItems)->delete();
            $this->selectedItems = [];
            session()->flash('removed-success', 'Items Removed');
        } else {
            session()->flash('empty-selected-items', 'Select items');
        }
        $this->redirect(Cart::class, navigate: true);
    }

    public function toggleChecked(CartItem $cartItem)
    {
        $cartItem->is_checked = !$cartItem->is_checked; // Toggle the state

        // Save the updated state
        $cartItem->save();
        $this->loadCart();
        $this->setSelectedItems();
    }

    public function checkout()
    {
        if ($this->selectedItems) {
            $this->validate();

            $this->cartItems = CartItem::whereIn('id', $this->selectedItems)->get();

            try {
                DB::beginTransaction();

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $this->calculateTotalPrice(),
                ]);

                $this->cartItems->each(function ($cartItem) use ($order) {
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                    ]);

                    $orderItem->customizations()->sync($cartItem->customizations->pluck('id'));
                    $orderItem->customizationItems()->sync($cartItem->customizationItems->pluck('id'));
                    $cartItem->delete();
                });

                DB::commit();
                session()->flash('checkout-success', 'Order placed successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('checkout-error', 'There was an error processing your order. Please try again.');
            }
            // $this->redirect(Cart::class, navigate: true);
            return redirect()->route('orders.success', ['order' => $order->load('orderItems.customizations', 'orderItems.customizationItems')]);
        } else {
            session()->flash('empty-selected-items', 'Select items');
            $this->redirect(Cart::class, navigate: true);
        }
    }
}
