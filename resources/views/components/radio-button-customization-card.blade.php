<div class="mb-4 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }} ({{ $required ? 'Required' : 'Optional' }})
    </label>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
    <div class="mt-2 space-y-2">
        @foreach($options as $value => $label)
            <div class="flex items-center">
                <input type="checkbox" id="{{ $value }}" name="{{ $name }}[]" value="{{ $value }}"
                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:text-gray-400 dark:border-gray-700 dark:bg-gray-800"
                    @if (is_array(old($name)) && in_array($value, old($name))) checked @endif>
                <label for="{{ $value }}"
                    class="ml-2 block text-sm text-gray-900 dark:text-gray-300">{{ $label }}</label>
            </div>
        @endforeach
    </div>
</div>
