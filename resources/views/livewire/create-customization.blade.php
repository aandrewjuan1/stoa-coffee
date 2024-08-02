<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 text-gray-900 dark:text-gray-200">
        <h1 class="text-center text-4xl font-bold my-8">Create New Customizations</h1>

        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <form wire:submit="create()">
                <div class="mb-4">
                    <x-input-label for="type" :value="__('Customization Type')" />
                    <x-text-input type="text" wire:model="type" id="type" class="w-full p-2 border border-gray-300 rounded" required />
                    @error($type) <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex mb-4 space-x-2 text-gray-800">
                    <x-input-label for="input_field" :value="__('Input Field')" />
                    <select wire:model="inputField" id="input_field">
                        <option value="radio_button">{{__('Radio Button')}}</option>
                        <option value="check_box">{{__('Checkbox')}}</option>
                        <option value="textarea">{{__('Textarea')}}</option>
                    </select>
                
                    <x-input-label for="required" :value="__('Required')" />
                    <select wire:model="required" id="required">
                        <option :value="false">{{__('False')}}</option>
                        <option :value="true">{{__('True')}}</option>
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="value" :value="__('Customization Value')" />
                    <x-text-input type="text" wire:model="value" id="value" class="w-full p-2 border border-gray-300 rounded" required />
                    @error($value) <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-input-label for="value_price" :value="__('Value Price')" />
                    <x-text-input type="number" wire:model="valuePrice" id="value_price" class="w-full p-2 border border-gray-300 rounded" required />
                    @error($valuePrice) <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="text-center">
                    <x-primary-button type="submit">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

        <h2 class="text-center text-2xl font-bold my-8">Customizations</h2>
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 pb-5 rounded-lg shadow-md">
            <livewire:show-customization />
        </div>

        <x-modal name="edit-customization">
            
        </x-modal>
    </div>
</div>
