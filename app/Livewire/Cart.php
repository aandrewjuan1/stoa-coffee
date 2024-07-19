<?php

namespace App\Livewire;

use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Reactive;

class Cart extends Component
{
    public Collection $selectedItems;
    protected CartModel $cart;
    #[Reactive]
    protected Collection $cartItems;
    public float $totalPrice = 0;

    public function mount()
    {
        $this->loadCart();
    }

    public function render()
    {
        return view('cart.index', [
            'cartItems' => $this->cartItems,
            'cart' => $this->cart,
        ]);
    }

    protected function loadCart(): void
    {
        $this->cart = CartModel::firstWhere('user_id', Auth::id());

        $this->cartItems = $this->cart
            ? CartItem::with('customizations', 'customizationItems')
                ->where('cart_id', $this->cart->id)
                ->get()
            : collect();

        $this->setSelectedItems();
        $this->totalPrice = $this->calculateTotalPrice($this->selectedItems);
    }

    private function setSelectedItems(): void
    {
        $this->selectedItems = $this->cartItems->where('is_checked', true);
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
        if ($this->selectedItems->isEmpty()) {
            $this->dispatch('show-message', 'Select Items');
            $this->setShowMessageEvent('Select Items');
            return;
        }

        $this->selectedItems->each(function ($item) {
            $item->delete();
        });

        $this->setShowMessageEvent('Items Removed');
    }

    protected function setShowMessageEvent(string $message): void
    {
        $this->dispatch('show-message', $message);
        $this->loadCart();
    }

    public function toggleChecked(CartItem $cartItem): void
    {
        $cartItem->is_checked = !$cartItem->is_checked;

        $cartItem->save();
        $this->loadCart();
    }

    public function checkout(): void
    {
        if ($this->selectedItems->isEmpty()) {
            $this->setShowMessageEvent('Select Items');
            return;
        }

        $cartItems = $this->selectedItems;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $this->calculateTotalPrice($cartItems),
            ]);

            $cartItems->each(function ($cartItem) use ($order) {
                // Additional validation or checks can be done here
                if ($cartItem->quantity <= 0) {
                    throw new \Exception("Invalid quantity for item: {$cartItem->id}");
                }

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
            
            $this->redirect(route('orders.success', ['order' => $order->load('orderItems.customizations', 'orderItems.customizationItems')]), navigate: true);
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->setShowMessageEvent('There was an error processing your order. Please try again.');
        }
    }
}
