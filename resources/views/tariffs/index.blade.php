<x-app-layout>
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-6">Manage Tariffs</h2>
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr><th class="p-4">Utility Type</th><th class="p-4">Rate Per Unit ($)</th><th class="p-4">Actions</th></tr>
                </thead>
                <tbody>
                    @foreach($tariffs as $tariff)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 uppercase font-bold">{{ $tariff->type }}</td>
                        <td class="p-4">${{ number_format($tariff->rate_per_unit, 2) }}</td>
                        <td class="p-4">
                            <a href="{{ route('tariffs.edit', $tariff) }}" class="text-indigo-600 font-medium hover:underline">Edit Tariff</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
