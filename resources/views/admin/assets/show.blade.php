<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Asset Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.assets.edit', $asset) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Edit Asset
                </a>
                <a href="{{ route('admin.assets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-800 dark:border-green-600 dark:text-green-100" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Asset Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Asset Information</h3>
                            
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Asset Tag</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->asset_tag }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->name }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->category }}</dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($asset->status === 'available') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                            @elseif($asset->status === 'assigned') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                            @elseif($asset->status === 'maintenance') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                            @endif">
                                            {{ ucfirst($asset->status) }}
                                        </span>
                                    </dd>
                                </div>

                                @if($asset->manufacturer)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Manufacturer</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->manufacturer }}</dd>
                                </div>
                                @endif

                                @if($asset->model)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Model</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->model }}</dd>
                                </div>
                                @endif

                                @if($asset->serial_number)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Serial Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->serial_number }}</dd>
                                </div>
                                @endif

                                @if($asset->purchase_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->purchase_date->format('M d, Y') }}</dd>
                                </div>
                                @endif

                                @if($asset->purchase_price)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Purchase Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">${{ number_format($asset->purchase_price, 2) }}</dd>
                                </div>
                                @endif

                                @if($asset->description)
                                <div class="md:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $asset->description }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Assignment Actions -->
                <div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assign Asset</h3>
                            
                            @if($asset->status === 'available' || $asset->status === 'maintenance')
                                <form method="POST" action="{{ route('admin.assets.assign', $asset) }}">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <x-input-label for="user_id" :value="__('Select User')" />
                                        <select id="user_id" name="user_id" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full" required>
                                            <option value="">Choose a user...</option>
                                            @foreach(\App\Models\User::where('is_admin', false)->orderBy('name')->get() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                    </div>

                                    <div class="mb-4">
                                        <x-input-label for="assigned_date" :value="__('Assignment Date')" />
                                        <x-text-input id="assigned_date" class="block mt-1 w-full" type="date" name="assigned_date" :value="old('assigned_date', date('Y-m-d'))" required />
                                        <x-input-error :messages="$errors->get('assigned_date')" class="mt-2" />
                                    </div>

                                    <div class="mb-4">
                                        <x-input-label for="notes" :value="__('Notes (optional)')" />
                                        <textarea id="notes" name="notes" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('notes') }}</textarea>
                                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                                    </div>

                                    <x-primary-button class="w-full justify-center">
                                        {{ __('Assign Asset') }}
                                    </x-primary-button>
                                </form>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">This asset is currently assigned and cannot be reassigned until it is returned.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment History -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assignment History</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assigned Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Return Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($asset->assignments as $assignment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $assignment->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->assigned_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->return_date ? $assignment->return_date->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $assignment->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ ucfirst($assignment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($assignment->status === 'active')
                                                <form action="{{ route('admin.assignments.return', $assignment) }}" method="POST" class="inline" onsubmit="return confirm('Mark this asset as returned?');">
                                                    @csrf
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Return Asset</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">Returned</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No assignment history
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
