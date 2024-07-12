<x-app-layout>
    <div class="flex justify-center mx-auto">
        <div class="text-justify bg-gray-800 text-white p-6 mb-8 mt-8 rounded-lg shadow-md w-full max-w-5xl">
            <h1 class="text-2xl font-bold mb-6">Cart</h1>
            @if(session('success'))
                <div class="mb-3 flex bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success! </strong>
                    <span class="block sm:inline ml-1">{{ session('success') }}</span>
                </div>
            @endif
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
                                    <td class="py-3 px-4">
                                        <div x-data="{ quantity: {{ $item->quantity }} }">
                                            <form action="{{ route('cart.addQuantity', ['cartItem' => $item]) }}" method="POST" x-ref="quantityForm">
                                                @csrf
                                                @method('PUT')
                                                <button @click="quantity > 1 ? (quantity--, $refs.quantityForm.submit()) : null" 
                                                        x-bind:class="{ 'opacity-50 cursor-not-allowed': quantity <= 1 }" 
                                                        class="text-gray-300 focus:outline-none">
                                                    -
                                                </button>
                                                <span x-text="quantity" class="mx-2"></span>
                                                <button @click="quantity++; $refs.quantityForm.submit()" class="text-gray-300 focus:outline-none">
                                                    +
                                                </button>
                                                <input type="hidden" name="quantity" x-model="quantity">
                                            </form>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <a href="{{ route('cart.edit', ['cartItem' => $item]) }}" class="relative group text-white py-2 px-2">
                                                <img src="{{ Vite::asset('resources/images/edit-logo.svg') }}" alt="Logo" class="relative group bg-green-500 text-white py-2 px-2 rounded hover:bg-green-600">
                                                <span class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-full bg-green-600 text-white py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">Edit</span>
                                            </a>
                                            <form action="{{ route('cart.remove', ['cartItem' => $item ]) }}" method="POST" class="relative group   text-white py-2 px-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center justify-center">
                                                    <img src="{{ Vite::asset('resources/images/delete-logo.svg') }}" alt="Logo" class="relative group bg-red-500 text-white py-2 px-2 rounded hover:bg-red-600">
                                                    <span class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-full bg-red-600 text-white py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">Delete</span>
                                                </button>
                                            </form>
                                        </div>
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
                        <button type="submit" class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-600">Place Order</button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
