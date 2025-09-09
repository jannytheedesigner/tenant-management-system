<x-app-layout>
    <div class="p-6 space-y-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-800 text-white rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Welcome, {{ $user->name }}</h1>
                    <p class="mt-2 text-green-100">Here’s an overview of your lease, rent, and requests.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-user text-green-200 text-5xl opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- Lease Details -->
        <div class="bg-white shadow rounded-xl p-6 card-hover">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Lease Details</h2>
            @if ($lease)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-gray-600"><strong>Property:</strong> {{ $lease->unit->property->name }}</p>
                        <p class="text-gray-600"><strong>Unit:</strong> {{ $lease->unit->unit_number }}</p>
                        <p class="text-gray-600"><strong>Lease Period:</strong> {{ $lease->start_date }} –
                            {{ $lease->end_date }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Status:</strong>
                            <span
                                class="px-2 py-1 rounded-full text-sm font-medium
                                {{ $lease->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($lease->status) }}
                            </span>
                        </p>
                        <p class="text-gray-600"><strong>Monthly Rent:</strong> MWK {{ number_format($lease->rent, 2) }}
                        </p>
                    </div>
                </div>
            @else
                <div class="text-center py-6 text-gray-400">
                    <i class="fas fa-file-contract text-3xl mb-2"></i>
                    <p>No active lease found</p>
                </div>
            @endif
        </div>

        <!-- Recent Payments -->
        <div class="bg-white shadow rounded-xl p-6 card-hover">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Recent Payments</h2>
                <a href="{{ route('payments.index') }}"
                    class="text-green-600 hover:text-green-800 text-sm font-medium">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b">
                            <th class="pb-3 font-medium">Date</th>
                            <th class="pb-3 font-medium">Amount</th>
                            <th class="pb-3 font-medium">Method</th>
                            <th class="pb-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4">{{ $payment->payment_date }}</td>
                                <td class="py-4 font-medium">MWK {{ number_format($payment->amount, 2) }}</td>
                                <td class="py-4 text-gray-500">{{ ucfirst($payment->method) }}</td>
                                <td class="py-4">
                                    <span
                                        class="px-2.5 py-1 text-xs rounded-full font-medium
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-400">
                                    <i class="fas fa-receipt text-3xl mb-2"></i>
                                    <p>No payment records found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Maintenance Requests -->
        <div class="bg-white shadow rounded-xl p-6 card-hover">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Maintenance Requests</h2>
                <a href="{{ route('maintenance.index') }}"
                    class="text-green-600 hover:text-green-800 text-sm font-medium">View all</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse ($maintenanceRequests as $request)
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-medium text-gray-800 truncate">{{ Str::limit($request->description, 40) }}
                            </h3>
                            <span
                                class="px-2.5 py-1 text-xs rounded-full font-medium
                                {{ $request->status === 'resolved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500">{{ Str::limit($request->description, 80) }}</p>
                        <div class="flex items-center mt-4 text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>{{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-400 col-span-2">
                        <i class="fas fa-tools text-3xl mb-2"></i>
                        <p>No maintenance requests found</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white shadow rounded-xl p-6 card-hover">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Notifications</h2>
                <a href="{{ route('notifications.index') }}"
                    class="text-green-600 hover:text-green-800 text-sm font-medium">View all</a>
            </div>
            <ul class="space-y-3">
                @forelse ($notifications as $note)
                    <li class="p-4 border rounded-lg hover:bg-gray-50">
                        {{ $note->message }}
                        <div class="text-sm text-gray-500 mt-1">
                            {{ $note->created_at->diffForHumans() }}
                        </div>
                    </li>
                @empty
                    <div class="text-center py-6 text-gray-400">
                        <i class="fas fa-bell text-3xl mb-2"></i>
                        <p>No notifications yet</p>
                    </div>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>
