<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 space-y-8">
        <!-- Welcome Header -->
        <div class="bg-blue-500 text-white rounded-xl p-12">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Welcome, {{ $user->name }}</h1>
                    <p class="mt-2 text-primary-100">Here's an overview of your rental properties and performance.</p>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-home text-primary-200 text-5xl opacity-50"></i>
                </div>
            </div>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="bg-white p-6 rounded-xl kpi-card border-l-primary-500 card-hover">
                <div class="flex items-center">
                    <div class="rounded-full bg-primary-50 p-3">
                        <i class="fas fa-building text-primary-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-500">Properties</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalProperties }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl kpi-card border-l-green-500 card-hover">
                <div class="flex items-center">
                    <div class="rounded-full bg-green-50 p-3">
                        <i class="fas fa-door-open text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-500">Units</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $totalUnits }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl kpi-card border-l-blue-500 card-hover">
                <div class="flex items-center">
                    <div class="rounded-full bg-blue-50 p-3">
                        <i class="fas fa-user-check text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-500">Occupied</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $occupiedUnits }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl kpi-card border-l-red-500 card-hover">
                <div class="flex items-center">
                    <div class="rounded-full bg-red-50 p-3">
                        <i class="fas fa-door-closed text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-500">Vacant</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $vacantUnits }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl kpi-card border-l-purple-500 card-hover">
                <div class="flex items-center">
                    <div class="rounded-full bg-purple-50 p-3">
                        <i class="fas fa-file-contract text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-sm font-medium text-gray-500">Active Leases</h2>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $leases->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payments -->
            <div class="bg-white rounded-xl p-6 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Recent Payments</h2>
                    <a href="{{ route('payments.index') }}"
                        class="text-primary-600 hover:text-primary-800 text-sm font-medium">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-500 border-b">
                                <th class="pb-3 font-medium">Tenant</th>
                                <th class="pb-3 font-medium">Amount</th>
                                <th class="pb-3 font-medium">Date</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">{{ $payment->lease->tenant->name }}</td>
                                    <td class="py-4 font-medium">MWK {{ number_format($payment->amount, 2) }}</td>
                                    <td class="py-4 text-gray-500">{{ $payment->payment_date }}</td>
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

            <!-- Active Leases -->
            <div class="bg-white rounded-xl p-6 card-hover">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">Active Leases</h2>
                    <a href="{{ route('leases.index') }}"
                        class="text-primary-600 hover:text-primary-800 text-sm font-medium">View all</a>
                </div>
                <div class="space-y-4">
                    @forelse ($leases as $lease)
                        <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="bg-primary-100 p-2 rounded-lg">
                                    <i class="fas fa-file-signature text-primary-600"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-medium text-gray-800">{{ $lease->tenant->name }}</h3>
                                    <p class="text-sm text-gray-500">Unit {{ $lease->unit->unit_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Ends on</p>
                                <p class="font-medium text-gray-800">{{ $lease->end_date }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-file-contract text-3xl mb-2"></i>
                            <p>No active leases found</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Maintenance Requests -->
        <div class="bg-white rounded-xl p-6 card-hover">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Maintenance Requests</h2>
                <a href="{{ route('maintenance.index') }}"
                    class="text-primary-600 hover:text-primary-800 text-sm font-medium">View all</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($maintenanceRequests as $request)
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                        <h3 class="font-medium text-gray-800 truncate">{{ Str::limit($request->description, 30) }}
                        </h3>
                        <span
                            class="px-2.5 py-1 text-xs rounded-full font-medium
                            {{ $request->status === 'completed'
                                ? 'bg-green-100 text-green-800'
                                : ($request->status === 'in progress'
                                    ? 'bg-blue-100 text-blue-800'
                                    : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $request->description }}</p>
                        <div class="flex items-center mt-4 text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <span>{{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 col-span-3">
                        <i class="fas fa-tools text-3xl mb-2"></i>
                        <p>No maintenance requests found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
