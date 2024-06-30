<x-app-layout>
    <div class="flex justify-center">
        <div class="max-w-lg w-full bg-gray-800 shadow-md rounded-lg overflow-hidden text-gray-900 dark:text-gray-200 mt-8 mb-8">
            <div class="p-6">
                <div class="flex justify-between">
                    <h1 class="text-2xl font-bold mb-4">Order #{{ $order->id }}</h1>
                    <h1 class="text-2xl font-bold mb-4 text-red-300">{{ $order->status }}</h1>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 mt-4">
                    <h2 class="text-lg font-semibold py-2">Order Items</h2>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->orderItems as $item)
                            <li class="flex justify-between items-center py-2">
                                <span>{{ $item->product->name }}</span>
                                <span class="text-gray-500 dark:text-gray-400">x{{ $item->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <p class="text-lg font-semibold">Total Price:</p>
                    <p class="text-lg">₱{{ $order->total_price }}</p>
                </div>
                
                <div class="flex justify-between items-center">
                    <p class="text-lg font-semibold">Order Date:</p>
                    <p class="text-lg">{{ $order->created_at->format('Y-m-d') }}</p>
                </div>
                
                <!-- Buttons -->
                <div class="mt-6 flex justify-center gap-4">
                    @if ($order->status === 'pending')
                        <form action="{{route('orders.update', $order->id)}}" method="POSt">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="processing">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Process</button>
                        </form>
                    @elseif ($order->status === 'processing')
                        <form action="{{route('orders.update', $order->id)}}" method="POSt">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Complete</button>
                        </form>
                    @endif
                    <a href="{{ route('orders.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
