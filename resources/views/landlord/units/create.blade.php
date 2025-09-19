<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Add Unit to {{ $property->name }}
        </h1>

        <form action="{{ route('units.store', $property->id) }}" method="POST"
              class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf

            <!-- Unit Number -->
            <div>
                <label for="unit_number" class="block text-sm font-medium text-gray-700">Unit Number</label>
                <input type="text" id="unit_number" name="unit_number" value="{{ old('unit_number') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500"
                       required>
                @error('unit_number')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rent Amount -->
            <div>
                <label for="rent_amount" class="block text-sm font-medium text-gray-700">Rent Amount</label>
                <input type="number" id="rent_amount" name="rent_amount" value="{{ old('rent_amount') }}" step="0.01"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500"
                       required>
                @error('rent_amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="under_maintenance" {{ old('status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end">
                <a href="{{ route('units.index', $property->id) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-green-900 text-white rounded-lg shadow hover:bg-primary-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
