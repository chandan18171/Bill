<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-black text-gray-800">Usage Reports</h2>
            <button type="submit" form="filterForm" name="export" value="1" class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow-md transform hover:scale-105 transition">Export to CSV</button>
        </div>
        
        <form id="filterForm" method="GET" action="{{ route('reports.index') }}" class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex gap-4 mb-8 items-end">
            <div class="w-1/3">
                <label class="block text-sm font-medium text-gray-700">Property</label>
                <select name="property_id" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Properties</option>
                    @foreach($properties as $prop)
                        <option value="{{ $prop->id }}" {{ $propertyId == $prop->id ? 'selected' : '' }}>{{ $prop->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-1/4">
                <label class="block text-sm font-medium text-gray-700">Month</label>
                <select name="month" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                    <option value="">All Year</option>
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-1/4">
                <label class="block text-sm font-medium text-gray-700">Year</label>
                <input type="number" name="year" value="{{ $year }}" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
            </div>
            <div class="w-auto">
                <button type="submit" name="export" value="0" class="bg-indigo-600 text-white font-bold px-6 py-2 rounded-lg hover:bg-indigo-700 shadow-md">Filter</button>
            </div>
        </form>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr><th class="p-4 uppercase text-sm text-gray-500">Date</th><th class="p-4 uppercase text-sm text-gray-500">Property</th><th class="p-4 uppercase text-sm text-gray-500">Utility Type</th><th class="p-4 uppercase text-sm text-gray-500">Units Consumed</th></tr>
                </thead>
                <tbody>
                    @foreach($reports as $r)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4">{{ $r->reading_date }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ $r->property_name }}</td>
                        <td class="p-4">
                            @if($r->utility_type == 'Water') <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-bold uppercase tracking-wider">Water</span>
                            @else <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-xs font-bold uppercase tracking-wider">Electricity</span> @endif
                        </td>
                        <td class="p-4 font-bold text-indigo-600 font-mono">{{ $r->units_consumed }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
