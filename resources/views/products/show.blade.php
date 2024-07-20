<div>
    @if (session('error'))
        <div class="mb-3 flex bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
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
                            <!-- Sticky Product Name Header -->
                            <div class="sticky top-0 bg-gray-100 dark:bg-gray-800 z-10 border-b border-gray-300 dark:border-gray-700 p-4">
                                <h1 class="text-3xl font-bold">{{ $product->name }} - ₱{{ $product->price }}</h1>
                            </div>

                            @foreach ($product->categories as $category)
                                <a href="{{ route('menu.index', ['category' => $category->name]) }}" class="bg-gray-200 text-gray-800 rounded-full px-2 py-1 mr-2">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                            <span class="block sm:inline">{{ session('error') }}</span>

                            <!-- Add to Cart Button -->
                            <div class="flex mt-4 mb-4">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add to Cart</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
