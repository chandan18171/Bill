<x-app-layout>
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-blue-600">Log Water Reading</h2>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 p-4 rounded-lg">
                <ul>@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('water-readings.store') }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100">
            @csrf
            <label class="block mb-4 font-medium text-gray-700">Property: 
                <select name="property_id" class="w-full border-gray-300 rounded-lg mt-1 p-3" required>
                    @foreach($properties as $prop)
                        <option value="{{ $prop->id }}">{{ $prop->name }} (Meter: {{ $prop->meter_number }})</option>
                    @endforeach
                </select>
            </label>
            <label class="block mb-4 font-medium text-gray-700">Reading Date: <input type="date" max="{{ date('Y-m-d') }}" name="reading_date" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
            <div class="flex gap-4 mb-4">
                <label class="block w-1/2 font-medium text-gray-700">Previous Value: <input type="number" step="0.01" min="0" name="previous_value" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
                <label class="block w-1/2 font-medium text-gray-700">Current Value: <input type="number" step="0.01" min="0" name="current_value" class="w-full border-gray-300 rounded-lg mt-1 p-3" required></label>
            </div>
            <label class="block mb-6 font-medium text-gray-700">Unit Type:
                <select name="unit_type" class="w-full border-gray-300 rounded-lg mt-1 p-3" required>
                    <option value="litres">Litres</option>
                    <option value="cubic m">Cubic Meters</option>
                </select>
            </label>
            <button class="w-full bg-blue-600 text-white font-bold px-4 py-3 rounded-lg shadow hover:opacity-90 transition">Submit Reading</button>
        </form>
    </div>
</x-app-layout>
