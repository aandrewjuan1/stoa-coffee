<x-app-layout>
    <div class="container mx-auto px-10 pb-10 text-gray-900 dark:text-gray-200">
        <h2 class="text-4xl font-semibold mb-4 mt-4">Inventory</h2>

        <!-- Search and Add New Product Button -->
        <div class="flex justify-between mb-4">
            <!-- Search Form -->
            <form action="{{ route('inventory.index') }}" method="GET" class="inline-block">
                <div class="flex">
                    <input type="text" name="query" placeholder="Search products..." class="border border-gray-300 rounded-md py-2 px-4 mr-2">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">
                        Search
                    </button>
                </div>
            </form>    
            <div class="flex">
                <a href="{{ route('categories.create') }}" class="bg-green-500 hover:bg-green-600 text-white mr-2 py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">Add New Category</a>            
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">Add New Product</a>        
            </div>    
        </div>

        <!-- Products Table -->
        <div class="-mx-4">
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Categories</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="border px-4 py-2"><a href="{{ route('products.show', ['product' => $product]) }}">{{ $product->name }}</a></td>
                            <td class="border px-4 py-2">{{ $product->description }}</td>
                            <td class="border px-4 py-2">{{ $product->price }}</td>
                            <td class="border px-4 py-2">{{ $product->quantity }}</td>
                            <td class="border px-4 py-2">
                                @foreach ($product->categories as $category)
                                    <a href="{{route('inventory.index', ['category' => $category->id])}}" class="bg-gray-200 text-gray-800 rounded-full px-2 py-1 text-sm mr-2" >
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('products.edit', ['product' => $product]) }}" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md shadow-md transition duration-300 ease-in-out">Edit</a>
                                <form action="{{ route('products.destroy', ['product' => $product]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md shadow-md transition duration-300 ease-in-out" onclick="return confirm('Are you sure you want to delete {{ $product->name }}?')">Delete</button>
                                </form>    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
