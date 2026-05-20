<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-800">Bills & Invoices</h2>
            <!-- Generate Bill Modal Trigger -->
            <button onclick="document.getElementById('generateModal').classList.remove('hidden')"
                class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:bg-indigo-700 transform hover:scale-105 transition">
                + Generate Bill
            </button>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0z"></path></svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
        @endif

        @if($bills->isEmpty())
        <div class="text-center py-24">
            <p class="text-gray-400 font-medium text-lg">No bills yet. Click <strong>+ Generate Bill</strong> after logging readings.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bills as $bill)
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-6 border-l-4 {{ $bill->status == 'paid' ? 'border-green-500' : 'border-rose-500' }}">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">{{ $bill->type }} Bill</span>
                    @if($bill->status == 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">PAID</span>
                    @else
                        <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-full text-sm font-bold">UNPAID</span>
                    @endif
                </div>
                <h3 class="text-4xl font-black text-gray-900">${{ number_format($bill->amount, 2) }}</h3>
                <p class="text-gray-500 mt-2 text-sm">{{ $bill->property->name }}</p>
                <div class="mt-6 pt-4 border-t flex justify-between items-center">
                    <p class="text-xs text-gray-500">Due: <span class="{{ $bill->status == 'unpaid' ? 'text-rose-600 font-bold' : '' }}">{{ $bill->due_date }}</span></p>
                    <a href="{{ route('bills.show', $bill) }}" class="text-indigo-600 font-bold hover:underline">Details &rarr;</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Generate Bill Modal -->
    <div id="generateModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
            <h3 class="text-xl font-black mb-6 text-gray-800">Generate Bill for This Month</h3>
            <form method="POST" action="{{ route('bills.generate') }}">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Property</label>
                <select name="property_id" class="w-full border-gray-300 rounded-lg shadow-sm mb-6 p-3 focus:ring-indigo-500" required>
                    <option value="">-- Choose a property --</option>
                    @foreach(Auth::user()->properties as $prop)
                        <option value="{{ $prop->id }}">{{ $prop->name }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mb-6 bg-gray-50 p-3 rounded-lg">This will total all water &amp; electricity readings logged <strong>this month</strong> and apply slab tariffs to generate invoices.</p>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white font-bold py-3 rounded-xl shadow hover:bg-indigo-700 transition">Generate Now</button>
                    <button type="button" onclick="document.getElementById('generateModal').classList.add('hidden')" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
