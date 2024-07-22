<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 text-gray-900 dark:text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">Create New Customizations</h1>

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
            <form action="{{ route('customizations.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <x-input-label for="type" :value="__('Customization Type')" />
                    <x-text-input type="text" name="type" id="type" class="w-full p-2 border border-gray-300 rounded" value="{{ old('type') }}" required />
                </div>
                <div class="mb-4">
                    <x-input-label for="value" :value="__('Customization Value')" />
                    <x-text-input type="text" name="value" id="value" class="w-full p-2 border border-gray-300 rounded" value="{{ old('value') }}" required />
                </div>

                <div class="text-center">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <h2 class="text-center text-2xl font-bold my-8">Customizations</h2>
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 pb-5 rounded-lg shadow-md">
            @foreach ($customizations as $type)
                <div class="p-2 border-b border-gray-300 dark:border-gray-700">{{ $type->type }}</div>
                <span class="text-sm text-gray-500">
                    {{ $type->customizationItems->where('customization_id', $type->id)->pluck('value')}}
                </span>
            @endforeach
        </div>
    </div>
</x-app-layout>
