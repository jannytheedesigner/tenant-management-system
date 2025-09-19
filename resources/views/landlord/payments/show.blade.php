<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Payment Details
            </h1>
            <a href="{{ route('payments.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Back to Payments
            </a>
        </div>
        <div class="bg-white p-6 rounded-xl shadow space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Property</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $payment->lease->unit->property->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Unit</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $payment->lease->unit->unit_number }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Tenant</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $payment->lease->tenant->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Amount</h2>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($payment->amount, 2) }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Payment Date</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ $payment->payment_date }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Payment Method</h2>
                    <p class="text-lg font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-medium text-gray-500">Status</h2>
                    <span class="px-3 py-1 inline-block text-sm font-semibold rounded-lg
                        @if($payment->status == 'completed') bg-green-100 text-green-700
                        @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>
            @if($payment->notes)
                <div class="mt-6">
                    <h2 class="text-sm font-medium text-gray-500">Notes</h2>
                    <p class="mt-1 text-gray-600">{{ $payment->notes }}</p>
                </div>
            @endif
            <div>
                <h2 class="text-sm font-medium text-gray-500">Created At</h2>
                <p class="text-gray-600 text-sm">{{ $payment->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                <h2 class="text-sm font-medium text-gray-500">Last Updated</h2>
                <p class="text-gray-600 text-sm">{{ $payment->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('payments.edit', $payment->id) }}"
               class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">Edit</a>
            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                        onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
            </form>
        </div>
    </div>
</x-app-layout>