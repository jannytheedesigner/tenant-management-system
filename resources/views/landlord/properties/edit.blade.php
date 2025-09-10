<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Property</h1>

        <!-- Form -->
        <form action="{{ route('properties.update', $property) }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf
            @method('PUT')

            <!-- Property Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
                <input type="text" id="name" name="name" 
                       value="{{ old('name', $property->name) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                       required>
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" id="location" name="location" 
                       value="{{ old('location', $property->location) }}" 
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500" 
                       required>
                @error('location')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end">
                <a href="{{ route('properties.index') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
