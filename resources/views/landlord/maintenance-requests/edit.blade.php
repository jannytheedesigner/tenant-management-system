<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Edit Maintenance Request
        </h1>
        <form action="{{ route('maintenance-requests.update', $maintenanceRequest->id) }}" method="POST"
              class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf
            @method('PUT')
            
            <div>
                <label for="unit_id" class="block text-sm font-medium text-gray-700">Property & Unit</label>
                <select id="unit_id" name="unit_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ $maintenanceRequest->unit_id == $unit->id ? 'selected' : '' }}>
                            {{ $unit->property->name }} - Unit {{ $unit->unit_number }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="category" name="category" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="plumbing" {{ old('category', $maintenanceRequest->category) == 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                    <option value="electrical" {{ old('category', $maintenanceRequest->category) == 'electrical' ? 'selected' : '' }}>Electrical</option>
                    <option value="hvac" {{ old('category', $maintenanceRequest->category) == 'hvac' ? 'selected' : '' }}>HVAC</option>
                    <option value="appliance" {{ old('category', $maintenanceRequest->category) == 'appliance' ? 'selected' : '' }}>Appliance</option>
                    <option value="structural" {{ old('category', $maintenanceRequest->category) == 'structural' ? 'selected' : '' }}>Structural</option>
                    <option value="other" {{ old('category', $maintenanceRequest->category) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>{{ old('description', $maintenanceRequest->description) }}</textarea>
                @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="low" {{ old('priority', $maintenanceRequest->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $maintenanceRequest->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $maintenanceRequest->priority) == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="preferred_time" class="block text-sm font-medium text-gray-700">Preferred Service Time</label>
                <input type="datetime-local" id="preferred_time" name="preferred_time"
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                       value="{{ old('preferred_time', $maintenanceRequest->preferred_time) }}">
                @error('preferred_time')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="pending" {{ old('status', $maintenanceRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $maintenanceRequest->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('status', $maintenanceRequest->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $maintenanceRequest->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('maintenance-requests.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                <button type="submit" 
                        class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                    Update Request
                </button>
            </div>
        </form>
    </div>
</x-app-layout>