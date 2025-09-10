<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $property->name }}</h1>
        <p class="text-gray-600">📍 Location: {{ $property->location }}</p>
        <p class="text-gray-600">🏢 Units: {{ $property->units->count() }}</p>
        <p class="text-gray-500 text-sm">Added on {{ $property->created_at->format('M d, Y') }}</p>

        <div>
            <a href="{{ route('properties.edit', $property) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg">Edit</a>
            <a href="{{ route('properties.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg">Back</a>
        </div>
    </div>
</x-app-layout>
