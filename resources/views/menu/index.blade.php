<x-app-layout>
    <div class="container mx-auto px-10 pb-10 text-gray-900 dark:text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">Menu</h1>
        <!-- Search Form -->
        <div class="flex justify-center my-8">
            <form action="{{ route('menu.index') }}" method="GET" class="inline-block">
                <div class="flex">
                    <input type="text" name="query" placeholder="Search products..." class="dark:bg-gray-800 border border-gray-300 rounded-md py-2 px-4 mr-2">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">
                        Search
                    </button>
                </div>
            </form> 
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->name) }}" class="block dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                    <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    <div class="p-4">
                        <h5 class="text-xl font-bold mb-2">{{ $product->name }}</h5>
                        <p class="mb-2">{{ $product->description }}</p>                        
                        <div class="flex space-x-2">
                            @foreach($product->categories as $category)
                                <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-lg">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="py-4 px-4 mt-auto bottom-0 left-0">
        {{ $products->links() }}
    </div>
</x-app-layout>
