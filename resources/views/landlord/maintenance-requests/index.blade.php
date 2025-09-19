<x-app-layout>
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">
                Maintenance Requests
            </h1>
            <a href="{{ route('maintenance-requests.create') }}"
                class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                <i class="fas fa-plus mr-2"></i> New Request
            </a>
        </div>
        <div class="bg-white shadow rounded-xl p-6 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left text-gray-500 text-sm border-b">
                        <th class="pb-3">Property</th>
                        <th class="pb-3">Unit</th>
                        <th class="pb-3">Category</th>
                        <th class="pb-3">Description</th>
                        <th class="pb-3">Priority</th>
                        <th class="pb-3">Status</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($maintenanceRequests as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-medium text-gray-800">{{ $request->unit->property->name }}</td>
                            <td class="py-3 font-medium text-gray-800">{{ $request->unit->unit_number }}</td>
                            <td class="py-3 text-gray-600">{{ ucfirst($request->category) }}</td>
                            <td class="py-3 text-gray-600">{{ Str::limit($request->description, 30) }}</td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                    @if($request->priority == 'high') bg-red-100 text-red-700
                                    @elseif($request->priority == 'medium') bg-yellow-100 text-yellow-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst($request->priority) }}
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-lg
                                    @if($request->status == 'completed') bg-green-100 text-green-700
                                    @elseif($request->status == 'in_progress') bg-blue-100 text-blue-700
                                    @elseif($request->status == 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('maintenance-requests.show', $request->id) }}"
                                    class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('maintenance-requests.edit', $request->id) }}"
                                    class="text-green-600 hover:underline">Edit</a>
                                <form action="{{ route('maintenance-requests.destroy', $request->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure you want to delete this maintenance request?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-gray-500">No maintenance requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>