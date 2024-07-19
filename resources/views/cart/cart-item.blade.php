<tr class="border-b border-gray-700">
    <td class="py-3 px-4">
        <div>{{ $item->product->name }}</div>
        <div class="ml-4">
            @foreach ($item->customizations as $customization)
                <div class="text-sm text-gray-400">
                    {{ str_replace('_', ' ', $customization->type) }}:
                    <span class="text-sm text-gray-500">
                        {{ $item->customizationItems->where('customization_id', $customization->id)->pluck('value')->join(', ') }}
                    </span>
                </div>
            @endforeach
        </div>
    </td>
    <td class="py-3 px-4">₱{{ $item->price * $item->quantity }}</td>
    <td class="py-3 px-4">
        <div class="flex items-center">
            <button type="button" wire:click="$parent.decrementQuantity({{ $item->id }})"
                wire:loading.attr="disabled"
                class="text-gray-300 focus:outline-none {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                -
            </button>
            <span class="mx-2">{{ $item->quantity }}</span>
            <button type="button" wire:click="$parent.incrementQuantity({{ $item->id }})"
                class="text-gray-300 focus:outline-none">
                +
            </button>
        </div>
    </td>
    <td class="py-3 px-4">
        <div class="flex items-center">
            <div class="relative group">
                <a href="{{ route('cart.edit', ['cartItem' => $item]) }}"
                    class="text-white py-2 px-2 relative block">
                    <img src="{{ Vite::asset('resources/images/edit-logo.svg') }}"
                        alt="Edit"
                        class="w-6 h-6 rounded hover:bg-gray-500 hover:opacity-50">
                    <span
                        class="opacity-0 group-hover:opacity-100 absolute top-0 left-1/2 transform -translate-x-1/2 -mt-8 bg-gray-800 text-white text-xs py-1 px-2 rounded">
                        Edit
                    </span>
                </a>
            </div>
            <div class="relative group ml-2">
                <label>
                    <input type="checkbox"
                            wire:change="$parent.toggleChecked({{ $item->id }})"
                            @checked($item->is_checked)>
                    {{ $item->name }}
                </label>
            </div>
        </div>
    </td>
</tr>
