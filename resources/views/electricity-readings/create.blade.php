<x-app-layout>
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-yellow-600">Log Electricity Reading</h2>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 p-4 rounded-lg">
                <ul>@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('electricity-readings.store') }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100">
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
            <label class="flex items-center mb-6 font-medium text-gray-700 bg-gray-50 p-4 rounded-lg">
                <input type="checkbox" name="is_peak" value="1" class="mr-3 w-5 h-5 text-indigo-600 rounded"> Is this peak hours usage?
            </label>
            <button class="w-full bg-yellow-500 text-white font-bold px-4 py-3 rounded-lg shadow hover:opacity-90 transition">Submit Reading</button>
        </form>
    </div>
</x-app-layout>
