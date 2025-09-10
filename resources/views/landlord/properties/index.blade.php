<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Properties</h1>
            <a href="{{ route('properties.create') }}"
                class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i> Add Property
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-xl p-6">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Name</th>
                        <th class="pb-3">Location</th>
                        <th class="pb-3">Units</th>
                        <th class="pb-3">Created</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-800">{{ $property->name }}</td>
                            <td class="py-3 text-gray-600">{{ $property->location }}</td>
                            <td class="py-3">{{ $property->units->count() }}</td>
                            <td class="py-3 text-sm text-gray-500">{{ $property->created_at->format('M d, Y') }}</td>
                            <td class="py-3 text-right">
                                <a href="{{ route('properties.show', $property) }}"
                                    class="text-blue-600 hover:underline">View</a> |
                                <a href="{{ route('properties.edit', $property) }}"
                                    class="text-green-600 hover:underline">Edit</a> |
                                <form action="{{ route('properties.destroy', $property) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this property?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">
                                <i class="fas fa-building text-3xl mb-2"></i>
                                <p>No properties found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
