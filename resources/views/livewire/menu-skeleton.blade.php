<div class="justify-center text-gray-900 dark:text-gray-200">
    <!-- Search Form -->
    <div class="flex justify-center my-8">
        <div class="flex">
            <input type="text" wire:model.live="searchQuery" placeholder="Search products..."
                class="dark:bg-gray-800 border border-gray-300 rounded-md py-2 px-4 mr-2">
        </div>
    </div>
    @if (session('success'))
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="flex my-5 text-lg text-green-500">{{ session('success') }}</p>
    @endif
    <div class="grid mx-20 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @foreach (range(1, 8) as $index)
            <div
                class="dark:bg-gray-800 bg-gray-100 rounded-lg shadow-md overflow-hidden transform transition-transform hover:scale-105 hover:shadow-lg animate-pulse">
                <div class="w-full h-48 bg-gray-300 animate-pulse"></div>
                <div class="flex justify-between mx-3 my-2">
                    <span class="bg-gray-300 rounded w-32 h-6 animate-pulse"></span>
                    <span class="bg-gray-300 rounded w-16 h-6 animate-pulse"></span>
                </div>
                <div class="flex space-x-2 m-3 ">
                    @foreach (range(1, 3) as $catIndex)
                        <span class="px-1.5 bg-gray-300 rounded-lg w-16 h-6 animate-pulse"></span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
