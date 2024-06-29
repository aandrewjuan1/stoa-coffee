<x-app-layout>
    <div class="container mx-auto px-4 p-10 text-gray-900 dark:text-gray-200">
        <div class="max-w-4xl mx-auto bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    @if (str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="md:w-1/2 md:p-6">
                    <div class="p-4 md:p-0">
                        <div class="space-y-4">
                            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                            @foreach($product->categories as $category)
                                <a href="{{route('menu.index', ['category' => $category->name])}}" class="bg-gray-200 text-gray-800 rounded-full px-2 py-1 mr-2" >
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                            <p class="font-bold text-2xl mb-4">₱{{ $product->price }}</p>
                        </div>
                        
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
                            <a href="{{ route('menu.index') }}" class="bg-gray-700 dark:bg-white text-white dark:text-black py-2 px-4 rounded hover:bg-gray-600 dark:hover:bg-gray-200">Back to Products</a>
                            @guest
                                <a href="{{ route('register') }}" class="bg-green-700 dark:bg-white text-white dark:text-black py-2 px-4 rounded hover:bg-green-600 dark:hover:bg-gray-200 ml-2">Order</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

