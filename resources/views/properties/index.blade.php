<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600">My Properties</h2>
            <a href="{{ route('properties.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition">Add Property</a>
        </div>
        <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Name</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Address</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Meter Number</th><th class="p-4 text-gray-600 font-semibold uppercase text-sm">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($properties as $prop)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-800">{{ $prop->name }}</td>
                        <td class="p-4 text-gray-600">{{ $prop->address }}</td>
                        <td class="p-4 text-indigo-600 font-mono">{{ $prop->meter_number }}</td>
                        <td class="p-4 flex gap-3">
                            <a href="{{ route('properties.edit', $prop) }}" class="text-blue-500 hover:text-blue-700 font-medium">Edit</a>
                            <form method="POST" action="{{ route('properties.destroy', $prop) }}" onsubmit="return confirm('Delete this property?');">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 font-medium">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
