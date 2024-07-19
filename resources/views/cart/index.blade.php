<div class="flex justify-center mx-20">
    <div class="text-justify bg-gray-800 text-white p-6 mb-8 mt-8 rounded-lg shadow-md w-full max-w-5xl">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">Cart</h1>
            <div x-data="{ message: '', show: false }"
                x-on:show-message.window="message = $event.detail; show = true; setTimeout(() => show = false, 3000)">
                <div x-show="show" class="text-red-500" x-transition>
                    <p x-text="message"></p>
                </div>
            </div>
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
                            <livewire:cart-item :$item key="{{ Str::random() }}" />
                        @endforeach
                    </tbody>
                </table>
                <h2 class="mt-6 text-xl font-bold mb-4">Total:
                    ₱{{ $totalPrice }}</h2>
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
