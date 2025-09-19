<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Unit {{ $unit->unit_number }} - {{ $property->name }}
            </h1>
            <a href="{{ route('units.index', $property->id) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Units
            </a>
        </div>

        <!-- Unit Details Card -->
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div>
                <h2 class="text-sm font-medium text-gray-500">Unit Number</h2>
                <p class="text-lg font-semibold text-gray-800">{{ $unit->unit_number }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500">Rent Amount</h2>
                <p class="text-lg font-semibold text-gray-800">
                    ${{ number_format($unit->rent_amount, 2) }}
                </p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500">Status</h2>
                <span class="px-3 py-1 inline-block text-sm font-semibold rounded-lg
                    @if($unit->status == 'available') bg-green-100 text-green-700
                    @elseif($unit->status == 'occupied') bg-yellow-100 text-yellow-700
                    @else bg-red-100 text-red-700 @endif">
                    {{ ucfirst($unit->status) }}
                </span>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500">Created</h2>
                <p class="text-gray-600 text-sm">{{ $unit->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
                <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
                <p class="text-gray-600 text-sm">{{ $unit->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('units.edit', [$property->id, $unit->id]) }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
                Edit
            </a>
            <form action="{{ route('units.destroy', [$property->id, $unit->id]) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this unit?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
