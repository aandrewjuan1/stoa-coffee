<x-app-layout>
    <div class="container mx-auto px-4 py-8 flex justify-center items-center h-full">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md max-w-lg w-full">
            <h1 class="text-2xl font-bold mb-6">Pending Order</h1>
            <h2 class="mt-6 text-xl font-bold mb-4">Order ID: {{ $order->id }}</h2>
            <p class="text-gray-400 mb-4">Thank you for your purchase! Here are your order details:</p>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-900 rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="py-3 px-4 border-b border-gray-600">Product</th>
                            <th class="py-3 px-4 border-b border-gray-600">Quantity</th>
                            <th class="py-3 px-4 border-b border-gray-600">Price</th>
                            <th class="py-3 px-4 border-b border-gray-600">Customizations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr class="text-center border-b border-gray-700">
                                <td class="py-3 px-4">{{ $item->product->name }}</td>
                                <td class="py-3 px-4">{{ $item->quantity }}</td>
                                <td class="py-3 px-4">₱{{ $item->price }}</td>
                                <td class="py-3 px-4">
                                    @foreach ($item->customizations as $customization)
                                        <div class="text-sm text-gray-400">
                                            {{ str_replace('_', ' ', $customization->type) }}:
                                            <span class="text-sm text-gray-500">
                                                {{ $item->customizationItems->where('customization_id', $customization->id)->pluck('value')->join(', ') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h2 class="mt-6 text-xl font-bold mb-4">Total: ₱{{ $order->total_price }}</h2>
            </div>
            
            <div class="flex justify-center mt-6">
                <a href="{{ route('menu.index') }}" class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-600">Continue Shopping</a>            
            </div>
        </div>
    </div>
</x-app-layout>
