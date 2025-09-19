<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Lease for Unit {{ $lease->unit->unit_number }} - {{ $property->name }}
            </h1>
            <a href="{{ route('leases.index', $property->id) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Leases
            </a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div>
                <h2 class="text-sm font-medium text-gray-500">Unit</h2>
                <p class="text-lg font-semibold text-gray-800">{{ $lease->unit->unit_number }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Tenant</h2>
                <p class="text-lg font-semibold text-gray-800">{{ $lease->tenant->name ?? 'N/A' }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Start Date</h2>
                <p class="text-lg font-semibold text-gray-800">{{ $lease->start_date }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">End Date</h2>
                <p class="text-lg font-semibold text-gray-800">{{ $lease->end_date }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Status</h2>
                <span class="px-3 py-1 inline-block text-sm font-semibold rounded-lg
                    @if($lease->status == 'active') bg-green-100 text-green-700
                    @elseif($lease->status == 'pending') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($lease->status) }}
                </span>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Created</h2>
                <p class="text-gray-600 text-sm">{{ $lease->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
                <p class="text-gray-600 text-sm">{{ $lease->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('leases.edit', [$property->id, $lease->id]) }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Edit</a>
            <form action="{{ route('leases.destroy', [$property->id, $lease->id]) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                        onclick="return confirm('Are you sure you want to delete this lease?')">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>
