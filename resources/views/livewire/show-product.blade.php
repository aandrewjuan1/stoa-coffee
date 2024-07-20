<div class="container mx-auto px-4 p-10 text-gray-200">
    @if ($product)
        @if (session('error'))
            <div class="mb-3 flex bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="max-w-xl mx-auto bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Sticky Product Name -->
            <div class=" bg-gray-800 z-10 p-4">
                <h1 class="text-4xl font-bold text-gray-200">{{ $product->name }}</h1>
            </div>
            
            <!-- Product Image -->
            <div>
                @if (str_starts_with($product->image, 'http'))
                    <img src="{{ $product->image }}" class="w-full h-auto object-cover" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto object-cover" alt="{{ $product->name }}">
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4 space-y-4">
                <div class="space-x-2 mb-4">
                    @foreach ($product->categories as $category)
                        <a href="{{ route('menu.index', ['category' => $category->name]) }}" class="bg-gray-200 text-gray-800 rounded-full px-2 py-1">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                <p class="text-2xl font-bold text-gray-300 mb-4">₱{{ $product->price }}</p>

                <!-- Customizations -->
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="product_price" value="{{ $product->price }}">

                    <!-- Choice of Temperature -->
                    <x-radio-button-customization-card label="Choice of Temperature" name="temperature"
                        :options="['hot' => 'Hot', 'iced' => 'Iced']" :selected="$product->temperature" required="true" />

                    <!-- Choice of Size -->
                    <x-radio-button-customization-card label="Choice of Size" name="size" :options="[
                        '16oz' => '16 Oz - Default',
                        '22oz' => '22 Oz - ₱30',
                    ]" :selected="$product->size" required="true" />

                    <!-- Sweetness -->
                    <x-radio-button-customization-card label="Sweetness" name="sweetness" :options="[
                        'not sweet' => 'Not Sweet',
                        'less sweet' => 'Less Sweet',
                        'regular sweetness' => 'Regular sweetness',
                    ]" :selected="$product->sweetness" required="true" />

                    <!-- Choice of Milk -->
                    <x-radio-button-customization-card label="Choice of Milk" name="milk" :options="[
                        'whole milk' => 'Whole',
                        'non-fat milk' => 'Non-fat',
                        'sub soymilk' => 'Sub Soymilk - ₱35',
                        'sub coconutmilk' => 'Sub Coconutmilk - ₱35',
                    ]" :selected="$product->milk" required="true" />

                    <!-- Choice of Espresso -->
                    <x-checkbox-customization-card label="Choice of Espresso" name="espresso" :options="[
                        'decaf' => 'Decaf - Free',
                        'add shot' => 'Add Espresso shot - ₱40',
                    ]" required="false" />

                    <!-- Add Syrup -->
                    <x-checkbox-customization-card label="Add Syrup" name="syrup" :options="[
                        'add vanilla syrup' => 'Add Vanilla Syrup - ₱25',
                        'add caramel syrup' => 'Add Caramel Syrup - ₱25',
                        'add hazelnut syrup' => 'Add Hazelnut Syrup - ₱25',
                        'add salted caramel syrup' => 'Add Salted Caramel Syrup - ₱25',
                    ]" :selected="old('syrup', $product->syrup)" />

                    <!-- Special Instructions -->
                    <div class="mb-4">
                        <label for="special_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special Instructions</label>
                        <textarea id="special_instructions" name="special_instructions" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('special_instructions') }}</textarea>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add to Cart</button>
                </form>
            </div>
        </div>
    @endif
</div>
