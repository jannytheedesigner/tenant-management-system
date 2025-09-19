<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">
                All Units
            </h1>

            @isset($property)
                {{-- When you're on a specific property's units page --}}
                <a href="{{ route('units.create', $property->id) }}"
                   class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                    <i class="fas fa-plus mr-2"></i> Add Unit
                </a>
            @else
                {{-- Global "All Units" page: ask user to choose a property first --}}
                <button type="button"
                        class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700"
                        onclick="document.getElementById('propertySelectModal').classList.remove('hidden')">
                    <i class="fas fa-plus mr-2"></i> Add Unit
                </button>
            @endisset
        </div>

        <!-- Units Table -->
        <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Unit Number</th>
                        <th class="pb-3">Rent Amount</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3">Property</th>
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
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-lg
                                    @if ($unit->status == 'available') bg-green-100 text-green-700
                                    @elseif($unit->status == 'occupied') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($unit->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-gray-600">{{ $unit->property->name ?? 'N/A' }}</td>
                            <td class="py-3 text-sm text-gray-500">{{ $unit->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('units.show', $unit->id) }}" class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('units.edit', $unit->id) }}" class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="inline">
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
                            <td colspan="6" class="text-center py-6 text-gray-400">
                                <i class="fas fa-door-open text-3xl mb-2"></i>
                                <p>No units found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Property selection modal (for "All Units" page) --}}
    <div id="propertySelectModal" class="hidden fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/40" onclick="closePropertyModal()"></div>

        <div class="relative bg-white rounded-xl shadow-xl max-w-lg mx-auto mt-24 p-6">
            <h2 class="text-lg font-semibold text-gray-900">Choose a property</h2>
            <p class="text-sm text-gray-500 mt-1">Select the property that this new unit will belong to.</p>

            @if(!empty($properties) && count($properties))
                <div class="mt-4">
                    <label for="propertySelect" class="block text-sm font-medium text-gray-700">Property</label>
                    <select id="propertySelect"
                            class="mt-1 w-full border rounded-lg p-2 focus:ring-2 focus:ring-[#12C6B0] focus:border-[#12C6B0]">
                        @foreach($properties as $p)
                            {{-- Works if $properties is a collection of models or arrays --}}
                            <option value="{{ is_object($p) ? $p->id : ($p['id'] ?? '') }}">
                                {{ is_object($p) ? $p->name : ($p['name'] ?? 'Unnamed') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closePropertyModal()"
                            class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>

                    {{-- Build the correct units.create URL with the chosen property ID --}}
                    <button type="button" onclick="goToUnitCreate()"
                            class="px-4 py-2 rounded-lg bg-[#12C6B0] text-white hover:bg-[#0fa695]">
                        Continue
                    </button>
                </div>
            @else
                <div class="mt-4 text-gray-600">
                    No properties found. Create a property first.
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('properties.create') }}"
                       class="px-4 py-2 rounded-lg bg-[#12C6B0] text-white hover:bg-[#0fa695]">
                        Create Property
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function closePropertyModal() {
            document.getElementById('propertySelectModal').classList.add('hidden');
        }
        function goToUnitCreate() {
            const sel = document.getElementById('propertySelect');
            if (!sel || !sel.value) return;
            // Template to the route that expects {property}
            const template = @json(route('units.create', ['property' => '__ID__']));
            const url = template.replace('__ID__', sel.value);
            window.location.href = url;
        }
    </script>
</x-app-layout>
