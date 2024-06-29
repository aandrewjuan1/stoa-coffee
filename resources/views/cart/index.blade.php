<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Cart</h1>
            
            @if($cartItems->isEmpty())
                <p class="text-gray-400 mb-4">Your cart is empty.</p>
                <div class="flex">
                    <a href="{{ route('menu.index') }}" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">Add Products</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-900 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="py-3 px-4 border-b border-gray-600">Product</th>
                                <th class="py-3 px-4 border-b border-gray-600">Quantity</th>
                                <th class="py-3 px-4 border-b border-gray-600">Price</th>
                                <th class="py-3 px-4 border-b border-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b border-gray-700">
                                    <td class="py-3 px-4">{{ $item->product->name }}</td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 text-center border rounded bg-gray-800 text-white">
                                            <button type="submit" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 ml-2">Update</button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-4">₱{{ $item->product->price * $item->quantity }}</td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h2 class="mt-6 text-xl font-bold mb-4">Total: ₱{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}</h2>
                </div>
                <div class="flex mt-6">
                    <a href="{{ route('menu.index') }}" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">Back</a>            
                    <form action="{{ route('order') }}" method="POST" class="ml-2">
                        @csrf
                        @foreach($cartItems as $item)
                            <input type="hidden" name="cartItems[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                            <input type="hidden" name="cartItems[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                            <input type="hidden" name="cartItems[{{ $loop->index }}][price]" value="{{ $item->product->price }}">
                        @endforeach
                        <button type="submit" class="bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600">Place Order</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
