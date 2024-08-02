<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">Create a New Category</h1>

        @if ($errors->any())
            <div class="bg-red-500 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Category Name')" />
                    <x-text-input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded" value="{{ old('name') }}" required />
                </div>

                <div class="flex justify-center space-x-2">
                    <a href="{{ route('inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Back</a>
                    <x-primary-button>
                        {{ __('Create Category') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <h2 class="text-center text-2xl font-bold my-8">Existing Categories</h2>
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 pb-5 rounded-lg shadow-md">
            @foreach ($categories as $category)
                <livewire:show-category :$category :key="$category->id" />
            @endforeach
        </div>
    </div>
</div>
