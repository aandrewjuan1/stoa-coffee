<x-app-layout>
    @if(session('error'))
        <div class="mb-3 flex bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <div class="container mx-auto px-4 p-10 text-gray-900 dark:text-gray-200">
        <div class="max-w-4xl mx-auto bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Product Image -->
                <div class="md:w-1/2">
                    @if (str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" class="h-full w-full object-cover" alt="{{ $product->name }}">
                    @endif
                </div>
 
                <!-- Product Info -->
                <div class="md:w-1/2 md:p-6">
                    <div class="p-4 md:p-0">
                        <div class="space-y-4">
                            <h1 class="text-3xl font-bold mb-4">{{ $product->name }} - ₱{{ $product->price }}</h1>
                            @foreach($product->categories as $category)
                                <a href="{{route('menu.index', ['category' => $category->name])}}" class="bg-gray-200 text-gray-800 rounded-full px-2 py-1 mr-2" >
                                    {{ $category->name }}
                                </a>
                            @endforeach
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $product->description }}</p>
                            <span class="block sm:inline">{{ session('error') }}</span>
                            
                            <!-- Customizations -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="product_price" value="{{ $product->price }}">
                                
                                <!-- Choice of Temperature -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Temperature (Required)</label>
                                    <x-input-error :messages="$errors->get('temperature')" class="mt-2" />
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="hot" name="temperature" value="hot"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('temperature', $product->temperature) == 'hot') checked @endif>
                                            <label for="hot" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Hot</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="iced" name="temperature" value="iced"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('temperature', $product->temperature) == 'iced') checked @endif>
                                            <label for="iced" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Iced</label>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- Choice of Size -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Size (Required)</label>
                                    <x-input-error :messages="$errors->get('size')" class="mt-2" />
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="16_oz" name="size" value="16oz"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('size', $product->size) == '16oz') checked @endif>
                                            <label for="16_oz" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">16 Oz - Default</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="22_oz" name="size" value="22oz"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('size', $product->size) == '22oz') checked @endif>
                                            <label for="22_oz" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">22 Oz - ₱30</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Sweetness -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sweetness (Required)</label>
                                    <x-input-error :messages="$errors->get('sweetness')" class="mt-2" />
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="not_sweet" name="sweetness" value="not sweet"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('sweetness', $product->sweetness) == 'not sweet') checked @endif>
                                            <label for="not_sweet" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Not Sweet</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="less_sweet" name="sweetness" value="less sweet"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('sweetness', $product->sweetness) == 'less sweet') checked @endif>
                                            <label for="less_sweet" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Less Sweet</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="regular_sweetness" name="sweetness" value="regular sweetness"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('sweetness', $product->sweetness) == 'regular sweetness') checked @endif>
                                            <label for="regular_sweetness" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Regular sweetness</label>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- Choice of Milk -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Milk (Required)</label>
                                    <x-input-error :messages="$errors->get('milk')" class="mt-2" />
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="whole_milk" name="milk" value="whole milk"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('milk', $product->milk) == 'whole milk') checked @endif>
                                            <label for="whole_milk" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Whole</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="non_fat_milk" name="milk" value="non-fat milk"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('milk', $product->milk) == 'non-fat milk') checked @endif>
                                            <label for="non_fat_milk" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Non-fat</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="sub_soymilk" name="milk" value="sub soymilk"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('milk', $product->milk) == 'sub soymilk') checked @endif>
                                            <label for="sub_soymilk" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Sub Soymilk - ₱35</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="sub_coconutmilk" name="milk" value="sub coconutmilk"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(old('milk', $product->milk) == 'sub coconutmilk') checked @endif>
                                            <label for="sub_coconutmilk" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Sub Coconutmilk - ₱35</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Choice of Espresso -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Espresso (Optional)</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="decaf" name="espresso[]" value="decaf"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('espresso')) && in_array('decaf', old('espresso'))) checked @endif>
                                            <label for="decaf" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Decaf - Free</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="add_shot" name="espresso[]" value="add shot"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('espresso')) && in_array('add shot', old('espresso'))) checked @endif>
                                            <label for="add_shot" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Espresso shot - ₱40</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Syrup -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add Syrup (Optional)</label>
                                    <div class="mt-2 space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="add_vanilla" name="syrup[]" value="add vanilla syrup"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('syrup')) && in_array('add vanilla syrup', old('syrup'))) checked @endif>
                                            <label for="add_vanilla" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Vanilla Syrup - ₱25</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="add_caramel" name="syrup[]" value="add caramel syrup"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('syrup')) && in_array('add caramel syrup', old('syrup'))) checked @endif>
                                            <label for="add_caramel" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Caramel Syrup - ₱25</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="add_hazelnut" name="syrup[]" value="add hazelnut syrup"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('syrup')) && in_array('add hazelnut syrup', old('syrup'))) checked @endif>
                                            <label for="add_hazelnut" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Hazelnut Syrup - ₱25</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="add_salt_caramel" name="syrup[]" value="add salted caramel syrup"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                                @if(is_array(old('syrup')) && in_array('add salted caramel syrup', old('syrup'))) checked @endif>
                                            <label for="add_salt_caramel" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Salted Caramel Syrup - ₱25</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Special Instructions -->
                                <div class="mb-4">
                                    <label for="special_instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special instructions</label>
                                    <textarea id="special_instructions" name="special_instructions" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300">{{ old('special_instructions') }}</textarea>
                                </div>

                                
                                <!-- Add to Cart Button -->
                                @can('buyer')
                                    <div class="flex mt-4 mb-4">
                                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Add to Cart</button>
                                    </div>
                                @endcan

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
