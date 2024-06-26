<x-app-layout>
    <div class="container mx-auto px-10 pb-10 text-gray-900 dark:text-gray-200">
        <h2 class="text-4xl font-semibold mb-4 mt-4">Inventory</h2>

        <!-- Search and Add New Product Button -->
        <div class="flex justify-between items-center mb-4">
            <div class="relative">
                <input type="text" class="border border-gray-300 rounded-md py-2 px-4 w-64 focus:outline-none focus:border-blue-500" placeholder="Search products..." name="search">
                <!-- Search icon if needed -->
                <!-- <button type="submit" class="absolute right-0 top-0 mt-2 mr-2">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M21 21l-5.2-5.2M15 10a5 5 0 11-10 0 5 5 0 0110 0z"></path>
                    </svg>
                </button> -->
            </div>
            <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-md transition duration-300 ease-in-out">Add New Product</a>
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
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr">
                            <td class="border px-4 py-2"><a href="{{route('products.show', ['product' => $product])}}">{{ $product->name }}</a></td>
                            <td class="border px-4 py-2">{{ $product->description }}</td>
                            <td class="border px-4 py-2">{{ $product->price }}</td>
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
