<x-app-layout>
    <div class="text-gray-900 dark:text-gray-200">
        @foreach ($categories as $category)
            {{ $category->name }}
        @endforeach
    </div>
</x-app-layout>