<x-app-layout>
    <div class="container mx-auto px-10 pb-10 text-gray-900 dark:text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">Our Coffee Products</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->name) }}" class="block dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                    <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    <div class="p-4">
                        <h5 class="text-xl font-bold mb-2 ">{{ $product->name }}</h5>
                        <p class=" mb-2">{{ $product->description }}</p>
                        <p class=" font-bold mb-4">₱{{ $product->price }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
