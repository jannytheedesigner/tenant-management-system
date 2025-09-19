<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">
                Leases for {{ $property->name }}
            </h1>
            <a href="{{ route('leases.create', $property->id) }}"
                class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i> Add Lease
            </a>
        </div>
        <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Unit</th>
                        <th class="pb-3">Tenant</th>
                        <th class="pb-3">Start Date</th>
                        <th class="pb-3">End Date</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($leases as $lease)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-800">{{ $lease->unit->unit_number }}</td>
                            <td class="py-3 text-gray-600">{{ $lease->tenant->name ?? 'N/A' }}</td>
                            <td class="py-3 text-gray-600">{{ $lease->start_date }}</td>
                            <td class="py-3 text-gray-600">{{ $lease->end_date }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                    @if($lease->status == 'active') bg-green-100 text-green-700
                                    @elseif($lease->status == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($lease->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('leases.show', [$property->id, $lease->id]) }}"
                                    class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('leases.edit', [$property->id, $lease->id]) }}"
                                    class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('leases.destroy', [$property->id, $lease->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this lease?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-500">No leases found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
