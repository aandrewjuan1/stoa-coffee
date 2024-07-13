<x-app-layout>
    <div class="container mx-auto px-4 text-white">
        @if (session('success'))
            <div class="mb-3 flex bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <strong class="font-bold">Success! </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <h1 class="text-center text-4xl font-bold my-8 text-white">Edit Cart</h1>
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <!-- Product Info -->
            <div class="md:p-6">
                <div class="p-4 md:p-0">
                    <div class="space-y-4">
                        <h1 class="inline text-3xl font-bold mb-4 mr-2">{{ $cartItem->product->name }} - ₱
                            {{ $cartItem->price }}</h1>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <!-- Customizations -->

                        <form action="{{ route('cart.update', ['cartItem' => $cartItem]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $cartItem->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_price" value="{{ $cartItem->product->price }}">

                            <!-- Choice of Temperature -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of
                                    Temperature (Required)</label>
                                <x-input-error :messages="$errors->get('temperature')" class="mt-2" />
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" id="hot" name="temperature" value="hot"
                                            {{ in_array('hot', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="hot"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Hot</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="iced" name="temperature" value="iced"
                                            {{ in_array('iced', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="iced"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Iced</label>
                                    </div>
                                </div>
                            </div>


                            <!-- Choice of Size -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Size
                                    (Required)</label>
                                <x-input-error :messages="$errors->get('size')" class="mt-2" />
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" id="16_oz" name="size" value="16oz"
                                            {{ in_array('16oz', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="16_oz"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">16 Oz -
                                        Default</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="22_oz" name="size" value="22oz"
                                            {{ in_array('22oz', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="22_oz"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">22 Oz -
                                        ₱30</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Sweetness -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sweetness
                                    (Required)</label>
                                <x-input-error :messages="$errors->get('sweetness')" class="mt-2" />
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" id="not_sweet" name="sweetness" value="not sweet"
                                            {{ in_array('not sweet', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="not_sweet"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Not
                                        Sweet</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="less_sweet" name="sweetness" value="less sweet"
                                            {{ in_array('less sweet', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="less_sweet"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Less
                                        Sweet</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="regular_sweetness" name="sweetness"
                                            value="regular sweetness"
                                            {{ in_array('regular sweetness', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="regular_sweetness"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Regular
                                        sweetness</label>
                                    </div>
                                </div>
                            </div>


                            <!-- Choice of Milk -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of Milk
                                    (Required)</label>
                                <x-input-error :messages="$errors->get('milk')" class="mt-2" />
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" id="whole_milk" name="milk" value="whole milk"
                                            {{ in_array('whole milk', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="whole_milk"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Whole</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="non_fat_milk" name="milk" value="non-fat milk"
                                            {{ in_array('non-fat milk', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="non_fat_milk"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Non-fat</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="sub_soymilk" name="milk" value="sub soymilk"
                                            {{ in_array('sub soymilk', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="sub_soymilk"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Sub Soymilk -
                                        ₱35</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="sub_coconutmilk" name="milk"
                                            value="sub coconutmilk"
                                            {{ in_array('sub coconutmilk', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            <label for="sub_coconutmilk"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Sub Coconutmilk
                                        - ₱35</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Choice of Espresso -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choice of
                                    Espresso (Optional)</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="decaf" name="espresso[]" value="decaf"
                                            {{ in_array('decaf', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('espresso')) && in_array('decaf', old('espresso'))) checked @endif>
                                        <label for="decaf"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Decaf -
                                            Free</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="add_shot" name="espresso[]" value="add shot"
                                            {{ in_array('add shot', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('espresso')) && in_array('add shot', old('espresso'))) checked @endif>
                                        <label for="add_shot"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Espresso
                                            shot - ₱40</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Syrup -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add Syrup
                                    (Optional)</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="add_vanilla" name="syrup[]"
                                            value="add vanilla syrup"
                                            {{ in_array('add vanilla syrup', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('syrup')) && in_array('add vanilla syrup', old('syrup'))) checked @endif>
                                        <label for="add_vanilla"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Vanilla
                                            Syrup - ₱25</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="add_caramel" name="syrup[]"
                                            value="add caramel syrup"
                                            {{ in_array('add caramel syrup', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('syrup')) && in_array('add caramel syrup', old('syrup'))) checked @endif>
                                        <label for="add_caramel"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Caramel
                                            Syrup - ₱25</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="add_hazelnut" name="syrup[]"
                                            value="add hazelnut syrup"
                                            {{ in_array('add hazelnut syrup', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('syrup')) && in_array('add hazelnut syrup', old('syrup'))) checked @endif>
                                        <label for="add_hazelnut"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Hazelnut
                                            Syrup - ₱25</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="add_salt_caramel" name="syrup[]"
                                            value="add salted caramel syrup"
                                            {{ in_array('add salted caramel syrup', $customizationValues) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                                            @if (is_array(old('syrup')) && in_array('add salted caramel syrup', old('syrup'))) checked @endif>
                                        <label for="add_salt_caramel"
                                            class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Add Salted
                                            Caramel Syrup - ₱25</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Instructions -->
                            <div class="mb-4">
                                <label for="special_instructions"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                                    instructions</label>
                                <textarea id="special_instructions" name="special_instructions" rows="3"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300">{{ $specialInstructions ?? '' }}</textarea>
                            </div>

                            <div class="flex justify-between space-x-3">
                                <a href="{{ route('cart.index') }}"
                                    class="text-center bg-gray-600 text-white py-2 px-4 rounded hover:bg-gray-700 w-1/2">Back</a>
                                <button type="submit"
                                    class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 w-1/2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
