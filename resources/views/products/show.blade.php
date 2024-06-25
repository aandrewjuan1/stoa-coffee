<x-app-layout>
    <div class="container mx-auto px-10 pb-10 text-gray-900 dark:text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">{{ $product->name }}</h1>
        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transform transition-transform">
            @if (str_starts_with($product->image, 'http'))
                <img src="{{ $product->image }}" class="w-full h-64 object-cover" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-64 object-cover" alt="{{ $product->name }}">
            @endif
            <div class="p-4">
                <h5 class="text-xl font-bold mb-2">{{ $product->name }}</h5>
                <p class="mb-2">{{ $product->description }}</p>
                <p class="font-bold mb-4">₱{{ $product->price }}</p>
                @auth
                    <div class="flex justify-between mt-4" x-data="{ quantity: 1 }">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex items-center">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" x-model="quantity" min="1" class="w-16 text-center border rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-200">
                            <button type="submit" class="bg-green-700 dark:bg-white text-white dark:text-black py-2 px-4 rounded hover:bg-green-600 dark:hover:bg-gray-200 ml-2">Add to Cart</button>
                        </form>
                    </div>
                @endauth
                <div class="flex mt-4">
                    <div>
                        <a href="{{ route('products.index') }}" class="bg-gray-700 dark:bg-white text-white dark:text-black py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-200">Back to Products</a>
                    </div>
                    @guest
                        <div>
                            <a href="{{ route('register') }}" class="bg-green-700 dark:bg-white text-white dark:text-black py-2 px-4 rounded hover:bg-green-600 dark:hover:bg-gray-200 ml-2">Order</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
