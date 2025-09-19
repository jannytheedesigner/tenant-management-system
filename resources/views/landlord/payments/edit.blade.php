<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Edit Payment
        </h1>
        <form action="{{ route('payments.update', $payment->id) }}" method="POST"
              class="space-y-6 bg-white p-6 rounded-xl shadow">
            @csrf
            @method('PUT')
            
            <div>
                <label for="lease_id" class="block text-sm font-medium text-gray-700">Property & Unit</label>
                <select id="lease_id" name="lease_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}" {{ $payment->lease_id == $lease->id ? 'selected' : '' }}>
                            {{ $lease->unit->property->name }} - Unit {{ $lease->unit->unit_number }}
                            (Tenant: {{ $lease->tenant->name }})
                        </option>
                    @endforeach
                </select>
                @error('lease_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" step="0.01" min="0" id="amount" name="amount" 
                           class="pl-7 mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                           value="{{ old('amount', $payment->amount) }}" required>
                </div>
                @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date" 
                       class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm"
                       value="{{ old('payment_date', $payment->payment_date) }}" required>
                @error('payment_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select id="payment_method" name="payment_method" 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="check" {{ old('payment_method', $payment->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                    <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                </select>
                @error('payment_method')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" 
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                    <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea id="notes" name="notes" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('payments.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</a>
                <button type="submit" 
                        class="px-4 py-2 bg-[#12C6B0] text-white rounded-lg shadow hover:bg-primary-700">
                    Update Payment
                </button>
            </div>
        </form>
    </div>
</x-app-layout>