<x-app-layout>
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Edit Tariff ({{ ucfirst($tariff->type) }})</h2>
        <form method="POST" action="{{ route('tariffs.update', $tariff) }}" class="bg-white p-8 shadow-xl rounded-2xl border border-gray-100">
            @csrf @method('PUT')
            <label class="block mb-6 font-medium">Rate Per Unit ($): 
                <input type="number" step="0.01" min="0" name="rate_per_unit" value="{{ $tariff->rate_per_unit }}" class="w-full border-gray-300 rounded-lg mt-1 p-3" required>
            </label>
            <button class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:opacity-90">Update Tariff</button>
        </form>
    </div>
</x-app-layout>
