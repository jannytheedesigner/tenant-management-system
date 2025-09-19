<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Add Lease to {{ $property->name }}
        </h1>
        <form action="{{ route('leases.store', $property->id) }}" method="POST"
              class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf
            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700">Unit</label>
                <select id="unit_id" name="unit_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="">Select Unit</option>
                    @foreach($property->units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_number }}</option>
                    @endforeach
                </select>
                @error('unit_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant</label>
                <input type="number" id="tenant_id" name="tenant_id" value="{{ old('tenant_id') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                @error('tenant_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                @error('start_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                @error('end_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terminated" {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <a href="{{ route('leases.index', $property->id) }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">Create Lease</button>
            </div>
        </form>
    </div>
</x-app-layout>
