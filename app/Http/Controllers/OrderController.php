<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request inputs
        $validatedData = $request->validate([
            'cartItems' => 'required|array',
            'cartItems.*.product_id' => 'required|exists:products,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
            'cartItems.*.price' => 'required|numeric|min:0'
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Calculate the total price of the order
            $totalPrice = collect($validatedData['cartItems'])->sum(function($cartItem) {
                return $cartItem['quantity'] * $cartItem['price'];
            });

            // Create a new order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending', // or any default status you prefer
            ]);

            // Insert order items into the OrderItem table
            foreach ($validatedData['cartItems'] as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                ]);

                // Update product quantity
                $product = Product::find($cartItem['product_id']);
                if ($product) {
                    $product->decrement('quantity', $cartItem['quantity']);
                } else {
                    throw new \Exception('Product not found.');
                }
            }

            // Clear the user's cart
            Cart::where('user_id', Auth::id())->delete();

            // Commit the transaction
            DB::commit();

            // Redirect to the order success page with the order details
            return view('orders.order-success', compact('order'));
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'There was an error placing your order. Please try again.');
        }
    }
}
