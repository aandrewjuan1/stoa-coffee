<div>
    @foreach ($customizations as $type)
        <div class="flex items-center justify-between p-4 border-b border-gray-700">
            <div class="flex-grow">
                <span class="font-semibold">{{ ucfirst($type->type) }}:</span>
                <span class="text-sm text-gray-500">
                    {{ implode(', ', $type->customizationItems->where('customization_id', $type->id)->pluck('value')->toArray()) }}
                </span>
            </div>

            <div class="flex-shrink-0 flex space-x-2">
                <button type="button" wire:click="#" class="relative group">
                    <img src="{{ Vite::asset('resources/images/edit-logo.svg') }}"
                        alt="Edit"
                        class="w-6 h-6 rounded hover:opacity-75 transition-opacity">
                    <span class="opacity-0 group-hover:opacity-100 absolute top-0 left-1/2 transform -translate-x-1/2 -mt-8 bg-gray-800 text-white text-xs py-1 px-2 rounded transition-opacity">
                        Edit
                    </span>
                </button>
                <button type="button" wire:click="delete({{ $type->id }})" class="text-red-600 hover:text-red-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
</div>
