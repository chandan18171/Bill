<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-gray-800">Alerts & Notifications</h2>
            <form method="POST" action="{{ route('alerts.check') }}">
                @csrf
                <button type="submit" class="px-6 py-2 bg-rose-600 text-white font-bold rounded-xl shadow-lg hover:bg-rose-700 transform hover:scale-105 transition">
                    🔔 Check Thresholds Now
                </button>
            </form>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Alerts List -->
            <div class="lg:col-span-2">
                <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100">
                    <h3 class="font-bold text-xl mb-4 border-b pb-2">Recent Alerts</h3>
                    @forelse($alerts as $alert)
                    <div class="p-4 mb-4 rounded-xl flex justify-between items-center {{ $alert->is_read ? 'bg-gray-50' : 'bg-rose-50 border border-rose-100' }}">
                        <div>
                            <p class="font-medium text-gray-800">{{ $alert->message }}</p>
                            <p class="text-xs text-gray-500 mt-1 font-mono">{{ $alert->created_at->diffForHumans() }} — {{ $alert->property->name }}</p>
                        </div>
                        @if(!$alert->is_read)
                        <form method="POST" action="{{ route('alerts.read', $alert) }}" class="ml-4 shrink-0">
                            @csrf @method('PATCH')
                            <button class="text-xs bg-rose-600 text-white px-3 py-1 rounded font-bold shadow hover:bg-rose-700">Mark Read</button>
                        </form>
                        @else
                        <span class="ml-4 text-xs text-green-600 font-bold bg-green-50 px-3 py-1 rounded border border-green-200 shrink-0">✓ Read</span>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-400 font-medium">No alerts yet. Click <strong>Check Thresholds Now</strong> after setting limits.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Configure Thresholds -->
            <div>
                <div class="bg-white p-6 shadow-xl rounded-2xl border border-gray-100 sticky top-6">
                    <h3 class="font-bold text-xl mb-4 border-b pb-2 text-indigo-900">Configure Thresholds</h3>
                    @forelse($properties as $prop)
                    <form method="POST" action="{{ route('alerts.thresholds', $prop) }}" class="mb-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                        @csrf @method('PUT')
                        <h4 class="font-bold text-indigo-700 mb-3">{{ $prop->name }}</h4>

                        <label class="block text-xs font-bold uppercase tracking-wider mb-1 text-gray-500">Water Threshold (Liters)</label>
                        <input type="number" step="0.1" min="0" name="water_threshold"
                            value="{{ old('water_threshold', $prop->water_threshold) }}"
                            placeholder="e.g. 40"
                            class="w-full rounded-lg border-gray-300 mb-4 p-2 text-sm focus:ring-indigo-500 font-mono text-indigo-700 shadow-sm">

                        <label class="block text-xs font-bold uppercase tracking-wider mb-1 text-gray-500">Electricity Threshold (kWh)</label>
                        <input type="number" step="0.1" min="0" name="electricity_threshold"
                            value="{{ old('electricity_threshold', $prop->electricity_threshold) }}"
                            placeholder="e.g. 100"
                            class="w-full rounded-lg border-gray-300 mb-4 p-2 text-sm focus:ring-indigo-500 font-mono text-indigo-700 shadow-sm">

                        <button class="w-full bg-indigo-600 text-white text-sm font-bold py-3 rounded-lg shadow-md hover:bg-indigo-700 transform hover:scale-[1.02] transition">
                            Save Thresholds
                        </button>
                    </form>
                    @empty
                    <p class="text-gray-500 text-sm">No properties found. <a href="{{ route('properties.create') }}" class="text-indigo-600 underline">Add one first.</a></p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
