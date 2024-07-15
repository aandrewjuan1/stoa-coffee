<div class="flex justify-center mx-auto">
    <div class="text-justify bg-gray-800 text-white p-6 mb-8 mt-8 rounded-lg shadow-md w-full max-w-5xl">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Cart</h1>
            @if (session()->has('removed-success'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-red-600 dark:text-red-400">{{ session('removed-success') }}</p>
            @endif
            @if (session()->has('empty-selected-items'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-red-600 dark:text-red-400">{{ session('empty-selected-items') }}</p>
            @endif
            @if (session('checkout-success'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="flex my-5 text-lg text-green-500">{{ session('checkout-success') }}</p>
            @endif
        </div>
        @if ($cartItems->isEmpty())
            <p class="text-gray-400 mb-4">Your cart is empty.</p>
            <div class="flex">
                <a href="{{ route('menu.index') }}"
                    class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">Add
                    Products</a>
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
                        @foreach ($cartItems as $item)
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-4">
                                    <div>{{ $item->product->name }}</div>
                                    <div class="ml-4">
                                        @foreach ($item->customizations as $customization)
                                            <div class="text-sm text-gray-400">
                                                {{ str_replace('_', ' ', $customization->type) }}:
                                                <span class="text-sm text-gray-500">
                                                    {{ $item->customizationItems->where('customization_id', $customization->id)->pluck('value')->join(', ') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-3 px-4">₱{{ $item->price * $item->quantity }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <button type="button" wire:click="decrementQuantity({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-gray-300 focus:outline-none {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            -
                                        </button>
                                        <span class="mx-2">{{ $item->quantity }}</span>
                                        <button type="button" wire:click="incrementQuantity({{ $item->id }})"
                                            class="text-gray-300 focus:outline-none">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="relative group">
                                            <a href="{{ route('cart.edit', ['cartItem' => $item]) }}"
                                                class="text-white py-2 px-2 relative block">
                                                <img src="{{ Vite::asset('resources/images/edit-logo.svg') }}"
                                                    alt="Edit"
                                                    class="w-6 h-6 rounded hover:bg-gray-500 hover:opacity-50">
                                                <span
                                                    class="opacity-0 group-hover:opacity-100 absolute top-0 left-1/2 transform -translate-x-1/2 -mt-8 bg-gray-800 text-white text-xs py-1 px-2 rounded">
                                                    Edit
                                                </span>
                                            </a>
                                        </div>
                                        <div class="relative group ml-2">
                                            <label>
                                                <input type="checkbox"
                                                       wire:model="cartItems.{{ $loop->index }}.is_checked"
                                                       wire:change="toggleChecked({{ $item->id }})"
                                                       @if ($item->is_checked) checked @endif>
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h2 class="mt-6 text-xl font-bold mb-4">Total:
                    ₱{{ $cartItems->sum(fn($item) => $item->price * $item->quantity) }}</h2>
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex gap-2">
                    <a href="{{ route('menu.index') }}"
                        class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600">{{ __('Back') }}</a>
                    <button type="button" wire:click='checkout()'
                        class="bg-blue-700 text-white
                        py-2 px-4 rounded hover:bg-blue-600">{{ __('Checkout') }}</button>
                </div>
                <button type="button" wire:click="deleteItems()"
                    class="bg-red-700 text-white py-2 px-4 rounded hover:bg-red-600">{{ __('Delete') }}</button>
            </div>
        @endif
    </div>
</div>
