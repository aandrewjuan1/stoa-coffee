<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 text-white">
        <h1 class="text-center text-4xl font-bold my-8 text-white">Create a New Product</h1>

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
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Product Name')" />
                    <x-text-input type="text" name="product_name" id="name" class="w-full p-2 border border-gray-300 rounded" value="{{ old('product_name') }}" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input as="textarea" name="description" id="description" class="w-full p-2 border border-gray-300 rounded" value="{{ old('description') }}" required></x-text-input>
                </div>

                <div class="mb-4">
                    <x-input-label for="price" :value="__('Price')" />
                    <x-text-input type="number" name="price" id="price" class="w-full p-2 border border-gray-300 rounded" value="{{ old('price') }}" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="image" :value="__('Image')" />
                    <x-text-input type="file" name="image" id="image" class="w-full p-2 border border-gray-300 rounded"/>
                </div>

                <div class="text-center">
                    <x-primary-button>
                        {{ __('Create Product') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>