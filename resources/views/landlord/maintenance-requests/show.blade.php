<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Maintenance Request Details
            </h1>
            <a href="{{ route('maintenance-requests.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Requests
            </a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Property</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $maintenanceRequest->unit->property->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Unit</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $maintenanceRequest->unit->unit_number }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Category</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ ucfirst($maintenanceRequest->category) }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Priority</h2>
                    <span class="px-3 py-1 inline-block text-sm font-semibold rounded-lg
                        @if($maintenanceRequest->priority == 'high') bg-red-100 text-red-700
                        @elseif($maintenanceRequest->priority == 'medium') bg-yellow-100 text-yellow-700
                        @else bg-blue-100 text-blue-700 @endif">
                        {{ ucfirst($maintenanceRequest->priority) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Status</h2>
                    <span class="px-3 py-1 inline-block text-sm font-semibold rounded-lg
                        @if($maintenanceRequest->status == 'completed') bg-green-100 text-green-700
                        @elseif($maintenanceRequest->status == 'in_progress') bg-blue-100 text-blue-700
                        @elseif($maintenanceRequest->status == 'pending') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
                    </span>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Preferred Time</h2>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $maintenanceRequest->preferred_time ? $maintenanceRequest->preferred_time->format('M d, Y H:i') : 'Not specified' }}
                    </p>
                </div>
            </div>

            <div class="col-span-2">
                <h2 class="text-sm font-medium text-gray-500">Description</h2>
                <p class="mt-1 text-gray-600">{{ $maintenanceRequest->description }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500">Created At</h2>
                <p class="text-gray-600 text-sm">{{ $maintenanceRequest->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
                <p class="text-gray-600 text-sm">{{ $maintenanceRequest->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('maintenance-requests.edit', $maintenanceRequest->id) }}"
               class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">Edit</a>
            <form action="{{ route('maintenance-requests.destroy', $maintenanceRequest->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                        onclick="return confirm('Are you sure you want to delete this maintenance request?')">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>