<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Water Readings</h2>
            <a href="{{ route('water-readings.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow transition">Add Reading</a>
        </div>
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-blue-50 border-b border-blue-100 text-blue-800">
                    <tr><th class="p-4">Date</th><th class="p-4">Property</th><th class="p-4">Previous</th><th class="p-4">Current</th><th class="p-4">Consumed</th><th class="p-4">Unit Type</th></tr>
                </thead>
                <tbody>
                    @foreach($readings as $r)
                    <tr class="border-b hover:bg-gray-50 uppercase text-sm font-medium">
                        <td class="p-4">{{ $r->reading_date }}</td>
                        <td class="p-4">{{ $r->property->name }}</td>
                        <td class="p-4">{{ $r->previous_value }}</td>
                        <td class="p-4 font-bold text-gray-900">{{ $r->current_value }}</td>
                        <td class="p-4 text-blue-600">{{ $r->units_consumed }}</td>
                        <td class="p-4 text-gray-500">{{ $r->unit_type }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
