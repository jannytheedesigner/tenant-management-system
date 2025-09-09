<x-app-layout>
    <div class="p-6 space-y-8">

        <!-- Welcome -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg p-6 shadow">
            <h1 class="text-3xl font-bold">Welcome, {{ $user->name }}</h1>
            <p class="mt-2 text-indigo-100">Here’s an overview of your rental properties.</p>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Properties</h2>
                <p class="mt-2 text-2xl font-bold text-indigo-600">{{ $totalProperties }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Units</h2>
                <p class="mt-2 text-2xl font-bold text-indigo-600">{{ $totalUnits }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Occupied</h2>
                <p class="mt-2 text-2xl font-bold text-green-600">{{ $occupiedUnits }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Vacant</h2>
                <p class="mt-2 text-2xl font-bold text-red-600">{{ $vacantUnits }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <h2 class="text-lg font-semibold text-gray-700">Active Leases</h2>
                <p class="mt-2 text-2xl font-bold text-purple-600">{{ $leases->count() }}</p>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Recent Payments</h2>
            <table class="w-full mt-4 border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Tenant</th>
                        <th class="p-2">Amount</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="border-t">
                            <td class="p-2">{{ $payment->lease->tenant->name }}</td>
                            <td class="p-2">MWK {{ number_format($payment->amount, 2) }}</td>
                            <td class="p-2">{{ $payment->payment_date }}</td>
                            <td class="p-2">
                                <span
                                    class="px-2 py-1 text-sm rounded
                                    {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Active Leases -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Active Leases</h2>
            <ul class="mt-3 space-y-2">
                @foreach ($leases as $lease)
                    <li class="p-3 border rounded flex justify-between bg-gray-50">
                        <span>
                            {{ $lease->tenant->name }} — Unit {{ $lease->unit->unit_number }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $lease->end_date }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Maintenance Requests -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Maintenance Requests</h2>
            <ul class="mt-3 space-y-2">
                @foreach ($maintenanceRequests as $request)
                    <li class="p-3 border rounded flex justify-between bg-gray-50">
                        <span>{{ $request->description }}</span>
                        <span class="text-sm text-red-600">{{ ucfirst($request->status) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</x-app-layout>
