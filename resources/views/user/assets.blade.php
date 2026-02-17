<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Assets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Currently Assigned Assets -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Currently Assigned Assets</h3>
                    
                    @if($activeAssignments->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($activeAssignments as $assignment)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $assignment->asset->name }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            Active
                                        </span>
                                    </div>
                                    
                                    <dl class="mt-4 space-y-2">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Asset Tag</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $assignment->asset->asset_tag }}</dd>
                                        </div>
                                        
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $assignment->asset->category }}</dd>
                                        </div>
                                        
                                        @if($assignment->asset->serial_number)
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Serial Number</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $assignment->asset->serial_number }}</dd>
                                        </div>
                                        @endif
                                        
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Assigned Date</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $assignment->assigned_date->format('M d, Y') }}</dd>
                                        </div>
                                        
                                        @if($assignment->notes)
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500 dark:text-gray-400">Notes</dt>
                                            <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $assignment->notes }}</dd>
                                        </div>
                                        @endif
                                    </dl>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">You currently have no assigned assets.</p>
                    @endif
                </div>
            </div>

            <!-- Assignment History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Assignment History</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asset</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Asset Tag</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assigned Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Return Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($allAssignments as $assignment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $assignment->asset->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $assignment->asset->asset_tag }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $assignment->asset->category }}
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No assignment history
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $allAssignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
