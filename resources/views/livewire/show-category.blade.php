<div class="flex items-center justify-between p-2 border-b border-gray-700">
    {{ $category->name }}

    <div class="flex">
        {{-- <button type="button" wire:click="$dispatch('edit-cart', { id: {{ $category->id }} })"
            class="text-white py-2 px-2 relative block">
            <img src="{{ Vite::asset('resources/images/edit-logo.svg') }}"
                alt="Edit"
                class="w-6 h-6 rounded hover:opacity-50">
            <span class="opacity-0 group-hover:opacity-100 absolute top-0 left-1/2 transform -translate-x-1/2 -mt-8 bg-gray-800 text-white text-xs py-1 px-2 rounded">
                Edit
            </span>
        </button> --}}
        <button type="button" wire:click="delete({{ $category-> id}})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
              </svg>
        </button>
    </div>

</div>
