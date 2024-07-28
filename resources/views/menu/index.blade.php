<div class="justify-center mb-10 text-gray-200 relative">
    <!-- Success Message Container -->
    <div x-data="{ message: '', show: false }" class="absolute top-0 left-0 right-0 flex justify-center p-4" x-show="show" x-transition
        x-on:add-to-cart-success-message.window="message = $event.detail; show = true; setTimeout(() => show = false, 3000)"
        :class="{
            'bg-blue-600 text-white': show,
            'opacity-100': show,
            'opacity-0': !show
        }"
        style="z-index: 1000; transition: opacity 0.5s ease;">
        <p x-text="message" class="p-2 rounded-md"></p>
    </div>

    <div class="flex justify-between items-center my-8 mx-20 space-x-4 pt-2">
        <!-- Search Input Field -->
        <div class="flex-grow flex justify-center">
            <input type="text" wire:model.live="searchQuery" placeholder="Search products..."
                class="bg-gray-800 border border-gray-300 rounded-md py-2 px-4">
        </div>
    </div>

    <div class="grid mx-20 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @foreach ($products as $product)
            <div wire:key="{{ $product->id }}"
                class="dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                <a href="#" wire:click="$dispatch('show-product', { id: {{ $product->id }} })">
                    <div>
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    </div>
                    <div class="flex justify-between mx-3 my-2">
                        <span class="text-3xl font-bold mb-2">{{ $product->name }}</span>
                        <span class="text-2xl mb-2">₱{{ $product->price }}</span>
                    </div>
                </a>
                <div class="flex space-x-2 m-3">
                    @foreach ($product->categories as $category)
                        <button type="button" wire:click="$set('searchQuery', '{{ $category->name }}')"
                            class="px-1.5 bg-gray-200 text-gray-800 rounded-lg">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        @endforeach

        <x-modal name="show-product">
            <livewire:show-product />
        </x-modal>
    </div>
</div>
