<x-app-layout>
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Property</h2>
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-600 p-4 rounded-lg">
                <ul>@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('properties.update', $property) }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100">
            @csrf @method('PUT')
            <label class="block mb-4 font-medium text-gray-700">Property Name: <input type="text" name="name" value="{{ $property->name }}" class="w-full border-gray-300 rounded-lg mt-1 p-3 focus:ring-indigo-500 focus:border-indigo-500" required></label>
            <label class="block mb-4 font-medium text-gray-700">Address: <input type="text" name="address" value="{{ $property->address }}" class="w-full border-gray-300 rounded-lg mt-1 p-3 focus:ring-indigo-500 focus:border-indigo-500" required></label>
            <label class="block mb-6 font-medium text-gray-700">Unique Meter Number: <input type="text" name="meter_number" value="{{ $property->meter_number }}" class="w-full border-gray-300 rounded-lg mt-1 p-3 focus:ring-indigo-500 focus:border-indigo-500" required></label>
            <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold px-4 py-3 rounded-lg shadow hover:opacity-90 transition">Update Property</button>
        </form>
    </div>
</x-app-layout>
