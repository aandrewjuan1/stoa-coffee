<div class="justify-center mb-10 text-gray-200">
    <!-- Search Form -->
    <div class="flex justify-center my-8">
        <div class="flex">
            <input type="text" wire:model.live="searchQuery" placeholder="Search products..."
                class="dark:bg-gray-800 border border-gray-300 rounded-md py-2 px-4 mr-2">
        </div>
    </div>
    @if (session('success'))
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="flex my-5 text-lg text-green-500">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <div class="mb-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ 'error ka sa products form'}}
        </div>
    @endif
    <div class="grid mx-20 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @foreach ($products as $product)
            <div wire:key="{{ $product->id }}"
                class="dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                <a href="#" wire:click="$dispatch('show-product', { id: {{ $product->id }} })">
                    <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    <div class="flex justify-between mx-3 my-2">
                        <span class="text-3xl font-bold mb-2">{{ $product->name }}</span>
                        <span class="text-2xl mb-2">₱{{ $product->price }}</span>
                    </div>
                </a>
                <div class="flex space-x-2 m-3 ">
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
