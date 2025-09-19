<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">
                Units for {{ $property->name }}
            </h1>
            <a href="{{ route('units.create', $property->id) }}"
                class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i> Add Unit
            </a>
        </div>

        <!-- Units Table -->
        <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Unit Number</th>
                        <th class="pb-3">Rent Amount</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Created</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($units as $unit)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-800">{{ $unit->unit_number }}</td>
                            <td class="py-3 text-gray-600">${{ number_format($unit->rent_amount, 2) }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                    @if($unit->status == 'available') bg-green-100 text-green-700
                                    @elseif($unit->status == 'occupied') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($unit->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-sm text-gray-500">{{ $unit->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('units.show', [$property->id, $unit->id]) }}"
                                    class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('units.edit', [$property->id, $unit->id]) }}"
                                    class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('units.destroy', [$property->id, $unit->id]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this unit?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">
                                <i class="fas fa-door-open text-3xl mb-2"></i>
                                <p>No units found for this property.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
