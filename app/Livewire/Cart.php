<?php

namespace App\Livewire;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class Cart extends Component
{
    #[Validate(['selectedItems' => 'required|array', 'selectedItems.*' => 'exists:cart_items,id'])]
    public array $selectedItems;
    protected CartModel $cart;
    protected Collection $cartItems;
    public float $totalPrice;

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

    private function loadCart(): void
    {
        $this->cart = CartModel::firstWhere('user_id', Auth::id());

        $this->cartItems = $this->cart
            ? CartItem::with('customizations', 'customizationItems')
                ->where('cart_id', $this->cart->id)
                ->get()
            : collect();
    }

    private function setSelectedItems(): void
    {
        $this->selectedItems = $this->cartItems->where('is_checked', true)->pluck('id')->toArray();
    }

    private function calculateTotalPrice($cartItems): float
    {
        return $cartItems->sum(fn($item) => $item->price * $item->quantity);
    }

    public function incrementQuantity(CartItem $cartItem): void
    {
        if ($cartItem->quantity < 99) {
            $cartItem->increment('quantity');
        }
        $this->loadCart();
    }

    public function decrementQuantity(CartItem $cartItem): void
    {
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }
        $this->loadCart();
    }

    public function deleteItems(): void
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

    public function toggleChecked(CartItem $cartItem): void
    {
        $cartItem->is_checked = !$cartItem->is_checked; 

        $cartItem->save();
        $this->loadCart();
        $this->setSelectedItems();
    }

    public function checkout(): void
    {
        if ($this->selectedItems) {
            $this->validate();

            $cartItems = CartItem::whereIn('id', $this->selectedItems)->get();

            try {
                DB::beginTransaction();

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $this->calculateTotalPrice($cartItems),
                ]);

                $cartItems->each(function ($cartItem) use ($order) {
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

                OrderPlaced::dispatch($order);
                session()->flash('checkout-success', 'Order placed successfully!');
                $this->redirect(route('orders.success', ['order' => $order->load('orderItems.customizations', 'orderItems.customizationItems')]), navigate: true);
            } catch (\Exception $exception) {
                DB::rollBack();
                session()->flash('checkout-error', 'There was an error processing your order. Please try again.');
                Log::info($exception);
                $this->redirect(Cart::class, navigate: true);
            }
        } else {
            session()->flash('empty-selected-items', 'Select items');
            $this->redirect(Cart::class, navigate: true);
        }
    }
}
