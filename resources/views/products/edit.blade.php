<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 text-white">
        <h1 class="text-center text-4xl font-bold my-8 text-white">Edit a Product</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <form action="{{ route('products.update', $product->name) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Product Name')" />
                    <x-text-input type="text" name="product_name" id="name" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->name }}" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input as="textarea" name="description" id="description" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->description }}" required></x-text-input>
                </div>

                <div class="mb-4">
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input type="number" name="price" id="price" class="w-full p-2 border border-gray-300 rounded" value="{{ $product->price }}" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="image" class="block text-gray-700 font-bold mb-2">Product image:</x-input-label>
                    @if (str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover mb-4" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover mb-4" alt="{{ $product->name }}">
                    @endif
                    <x-text-input type="file" name="image" id="image" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:shadow-outline"></x-text-input> 
                </div>
                <div class="flex justify-between">
                    <a href="{{ route('inventory') }}" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-800">Back</a>
                    <button type="submit" class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-800">Update Product</button>
                </div>
            </form>
            <form action="{{ route('products.destroy', $product->name) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600/55 text-white py-2 px-4 rounded hover:bg-red-800 w-full">Delete Product</button>
            </form>
        </div>
    </div>
</x-app-layout>