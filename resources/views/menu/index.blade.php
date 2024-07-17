<x-app-layout>
    <div class="justify-center text-gray-900 dark:text-gray-200">
        <!-- Search Form -->
        <div class="flex justify-center my-8">
            <form action="{{ route('menu.index') }}" method="GET" class="inline-block">
                <div class="flex">
                    <input type="text" name="query" placeholder="Search products..."
                        class="dark:bg-gray-800 border border-gray-300 rounded-md py-2 px-4 mr-2">
                    <button type="submit"
                        class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">
                        Search
                    </button>
                </div>
            </form>
        </div>
        @if (session('success'))
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="flex my-5 text-lg text-green-500">{{ session('success') }}</p>
        @endif
        <div class="grid mx-20 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-10">
            @foreach ($products as $product)
                <div class="dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                    <a href="{{ route('menu.showProduct', $product->name) }}">
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                        <div class="flex justify-between mx-3 my-2">
                            <span class="text-3xl font-bold mb-2">{{ $product->name }}</span>
                            <span class="text-2xl mb-2">₱{{ $product->price }}</span>
                        </div>
                        <div class="flex space-x-2 m-3 ">
                            @foreach ($product->categories as $category)
                                <a href="{{ route('menu.index', ['category' => $category->name]) }}"
                                    class="px-1.5 bg-gray-200 text-gray-800 rounded-lg">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="py-4 px-4 mt-auto bottom-0 left-0">
        {{ $products->links() }}
    </div>
</x-app-layout>
