<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Asset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.assets.update', $asset) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Asset Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $asset->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Asset Tag -->
                            <div>
                                <x-input-label for="asset_tag" :value="__('Asset Tag')" />
                                <x-text-input id="asset_tag" class="block mt-1 w-full" type="text" name="asset_tag" :value="old('asset_tag', $asset->asset_tag)" required />
                                <x-input-error :messages="$errors->get('asset_tag')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category" :value="__('Category')" />
                                <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" :value="old('category', $asset->category)" required />
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="available" {{ old('status', $asset->status) === 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="assigned" {{ old('status', $asset->status) === 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="maintenance" {{ old('status', $asset->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="retired" {{ old('status', $asset->status) === 'retired' ? 'selected' : '' }}>Retired</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Manufacturer -->
                            <div>
                                <x-input-label for="manufacturer" :value="__('Manufacturer')" />
                                <x-text-input id="manufacturer" class="block mt-1 w-full" type="text" name="manufacturer" :value="old('manufacturer', $asset->manufacturer)" />
                                <x-input-error :messages="$errors->get('manufacturer')" class="mt-2" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model', $asset->model)" />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <!-- Serial Number -->
                            <div>
                                <x-input-label for="serial_number" :value="__('Serial Number')" />
                                <x-text-input id="serial_number" class="block mt-1 w-full" type="text" name="serial_number" :value="old('serial_number', $asset->serial_number)" />
                                <x-input-error :messages="$errors->get('serial_number')" class="mt-2" />
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <x-input-label for="purchase_date" :value="__('Purchase Date')" />
                                <x-text-input id="purchase_date" class="block mt-1 w-full" type="date" name="purchase_date" :value="old('purchase_date', $asset->purchase_date?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                            </div>

                            <!-- Purchase Price -->
                            <div>
                                <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                                <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" name="purchase_price" :value="old('purchase_price', $asset->purchase_price)" />
                                <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $asset->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <x-primary-button>{{ __('Update Asset') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
