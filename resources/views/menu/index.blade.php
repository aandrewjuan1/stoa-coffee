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
        @if(session('success'))
            <div class="mb-3 flex bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success! </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg">
                    <a href="{{route('menu.showProduct', $product->name)}}">
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover" alt="{{ $product->name }}">
                        <div class="flex mx-3 my-2">
                            <span class="text-3xl font-bold mb-2">{{ $product->name }}</span>
                        </div>
                        <div class="flex space-x-2 m-3 ">
                            @foreach($product->categories as $category)
                                <a href="{{route('menu.index', ['category' => $category->name])}}" class="px-1.5 py-0.5 bg-gray-200 text-gray-800 rounded-lg">{{ $category->name }}</a>
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
