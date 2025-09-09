<x-app-layout>
    <div class="p-6 space-y-8">

        <!-- Welcome -->
        <div class="bg-white shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $user->name }}</h1>
            <p class="mt-2 text-gray-600">Here’s an overview of your rental status.</p>
        </div>

        <!-- Lease Details -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Lease Details</h2>
            @if ($lease)
                <p class="mt-2"><strong>Property:</strong> {{ $lease->unit->property->name }}</p>
                <p><strong>Unit:</strong> {{ $lease->unit->unit_number }}</p>
                <p><strong>Lease Period:</strong> {{ $lease->start_date }} – {{ $lease->end_date }}</p>
                <p><strong>Status:</strong>
                    <span
                        class="px-2 py-1 text-sm rounded 
                        {{ $lease->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($lease->status) }}
                    </span>
                </p>
            @else
                <p class="mt-2 text-gray-600">No active lease found.</p>
            @endif
        </div>

        <!-- Payments -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Payment History</h2>
            @if ($payments->count())
                <table class="w-full mt-4 border border-gray-200 rounded">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="p-2">Date</th>
                            <th class="p-2">Amount</th>
                            <th class="p-2">Method</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr class="border-t">
                                <td class="p-2">{{ $payment->payment_date }}</td>
                                <td class="p-2">MWK {{ number_format($payment->amount, 2) }}</td>
                                <td class="p-2">{{ ucfirst($payment->method) }}</td>
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
            @else
                <p class="mt-2 text-gray-600">No payments recorded yet.</p>
            @endif
        </div>

        <!-- Maintenance Requests -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Recent Maintenance Requests</h2>
            @if ($maintenanceRequests->count())
                <ul class="mt-3 space-y-2">
                    @foreach ($maintenanceRequests as $request)
                        <li class="border p-3 rounded bg-gray-50 flex justify-between">
                            <span>{{ $request->description }}</span>
                            <span
                                class="text-sm 
                                {{ $request->status === 'resolved' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-2 text-gray-600">No recent maintenance requests.</p>
            @endif
        </div>

        <!-- Notifications -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Notifications</h2>
            @if ($notifications->count())
                <ul class="mt-3 space-y-2">
                    @foreach ($notifications as $note)
                        <li class="border p-3 rounded bg-gray-50">
                            {{ $note->message }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-2 text-gray-600">No new notifications.</p>
            @endif
        </div>

    </div>
</x-app-layout>
