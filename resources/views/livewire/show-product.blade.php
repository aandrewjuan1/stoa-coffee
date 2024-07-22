<div class="container mx-auto px-4 p-10 text-gray-200">
    @if ($product)
        @if (session('error'))
            <div class="mb-3 flex bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
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
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto object-cover"
                        alt="{{ $product->name }}">
                @endif
            </div>

            <!-- Product Info -->
            <div class="p-4 space-y-4">
                <div class="space-x-2 mb-4">
                    @foreach ($product->categories as $category)
                        <a href="{{ route('menu.index', ['category' => $category->name]) }}"
                            class="bg-gray-200 text-gray-800 rounded-full px-2 py-1">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                <p class="text-2xl font-bold text-gray-300 mb-4">₱{{ $product->price }}</p>

                <!-- Customizations -->
                <div>
                    <form wire:submit="addTocart">

                        <x-radio-button-customization-card label="Temperature:" name="form.temperature"
                            :options="[
                                'hot' => 'Hot',
                                'iced' => 'Iced',
                            ]" :required="true" />

                        <x-radio-button-customization-card label="Size:" name="form.size" :options="[
                            '16oz' => '16oz',
                            '22oz' => '22oz',
                        ]"
                            :required="true" />

                        <x-radio-button-customization-card label="Sweetness:" name="form.sweetness" :options="[
                            'not sweet' => 'Not Sweet',
                            'less sweet' => 'Less Sweet',
                            'regular sweetness' => 'Regular Sweetness',
                        ]"
                            :required="true" />

                        <x-radio-button-customization-card label="Milk:" name="form.milk" :options="[
                            'whole milk' => 'Whole Milk',
                            'non-fat milk' => 'Non-Fat Milk',
                            'sub soymilk' => 'Sub Soymilk',
                            'sub coconutmilk' => 'Sub Coconutmilk',
                        ]"
                            :required="true" />

                        <x-checkbox-customization-card label="Espresso:" name="form.espresso" :options="[
                            'decaf' => 'Decaf',
                            'add shot' => 'Add Shot',
                        ]"
                            :required="false" />

                        <x-checkbox-customization-card label="Syrup:" name="form.syrup" :options="[
                            'add vanilla syrup' => 'Add Vanilla Syrup',
                            'add caramel syrup' => 'Add Caramel Syrup',
                            'add hazelnut syrup' => 'Add Hazelnut Syrup',
                            'add salted caramel syrup' => 'Add Salted Caramel Syrup',
                        ]"
                            :required="false" />

                        <label for="special_instructions"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                            Instructions</label>
                        <textarea id="special_instructions" wire:model="form.special_instructions" rows="3"
                            class="mb-4 mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add to
                            cart</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
