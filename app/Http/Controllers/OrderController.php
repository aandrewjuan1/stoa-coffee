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
    public function index()
    {
        // Retrieve all orders ordered by status (pending first, then processing)
        $orders = Order::with(['user', 'orderItems.product'])
                        ->orderBy('status', 'asc')
                        ->get();
        
        // Separate orders into pending and processing
        $pendingOrders = $orders->where('status', 'pending');
        $processingOrders = $orders->where('status', 'processing');
        
        return view('orders.index', [
            'pendingOrders' => $pendingOrders,
            'processingOrders' => $processingOrders,
        ]);
    }

    public function show(Order $order)
    {
        return view('orders.show', ['order' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string|in:processing,completed', // Define valid status values
        ]);

        // Update the order status
        $order->update(['status' => $request->status]);

        // Redirect back to the order details page
        return redirect()->route('orders.show', ['order' => $order]);
    }


    public function store(Request $request)
    {
    }

    public function showOrderSuccess(Order $order)
    {
        return view('orders.order-success', compact('order'));
    }
}
