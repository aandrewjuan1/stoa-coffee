<x-app-layout>
    <div class="flex justify-center mx-auto">
        <div class="text-justify bg-gray-800 text-white p-6 mb-8 mt-8 rounded-lg shadow-md w-full max-w-5xl">
            <h1 class="text-2xl font-bold mb-6">Cart</h1>

            @if($cartItems->isEmpty())
                <p class="text-gray-400 mb-4">Your cart is empty.</p>
                <div class="flex">
                    <a href="{{ route('menu.index') }}" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">Add Products</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-800 text-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4">Product</th>
                                <th class="py-2 px-4">Price</th>
                                <th class="py-2 px-4">Quantity</th>
                                <th class="py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b border-gray-700">
                                    <td class="py-3 px-4">
                                        <div>{{ $item->product->name }}</div>
                                        <div class="ml-4">
                                            @foreach ($item->customizations as $customization)
                                                <div class="text-sm text-gray-400">
                                                    {{ str_replace('_', ' ', $customization->type) }}:
                                                    <span class="text-sm text-gray-500">
                                                        {{ $item->customizationItems
                                                            ->where('customization_id', $customization->id)
                                                            ->pluck('value')
                                                            ->join(', ') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">₱{{ $item->price * $item->quantity }}</td>
                                    <td class="py-3 px-4">{{ $item->quantity }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('cart.edit', ['cartItem' => $item]) }}" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h2 class="mt-6 text-xl font-bold mb-4">Total: ₱{{ $cartItems->sum(fn($item) => $item->price * $item->quantity) }}</h2>
                </div>
                <div class="flex mt-6">
                    <a href="{{ route('menu.index') }}" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">Back</a>
                    <form action="#" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="bg-green-700 text-white py-2 px-4 rounded hover:bg-green-600">Place Order</button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>