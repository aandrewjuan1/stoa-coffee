<div class="container mx-auto px-4 p-10 text-gray-200">
    @if ($cartItem)
        @if (session('error'))
            <div class="mb-3 flex bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="max-w-xl mx-auto bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Sticky Product Name -->
            <div class=" bg-gray-800 z-10 p-4">
                <h1 class="text-4xl font-bold text-gray-200">{{ $cartItem->product->name }}</h1>
            </div>

            <!-- Product Info -->
            <div class="p-4 space-y-4">
                <p class="text-2xl font-bold text-gray-300 mb-4">₱{{ $cartItem->product->price }}</p>

                <!-- Customizations -->
                <div>
                    <form wire:submit="update">

                        @foreach ($cartItem->product->customizations as $customization)
                            @if ($customization->input_field == 'radio_button')
                                <x-radio-button-customization-card :label="$customization->type . ':'" :name="'form.' . $customization->type" :options="$customization->customizationItems->pluck('value', 'value')->toArray()"
                                    :required="true" />
                            @elseif ($customization->input_field == 'check_box')
                                <x-checkbox-customization-card :label="$customization->type . ':'" :name="'form.' . $customization->type" :options="$customization->customizationItems->pluck('value', 'value')->toArray()"
                                    :required="false" />
                            @endif
                        @endforeach

                        <label for="special_instructions"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                            Instructions</label>
                        <textarea id="special_instructions" wire:model="form.special_instructions" rows="3"
                            class="mb-4 mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>

                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">Update</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
