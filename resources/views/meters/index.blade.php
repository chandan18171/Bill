<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Utility Meters') }}
            </h2>
            <a href="{{ route('meters.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                + Add New Meter
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/70 backdrop-blur-md overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                @if($meters->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($meters as $meter)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300 relative overflow-hidden group">
                                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-100 to-white rounded-bl-full -z-10 group-hover:scale-110 transition-transform"></div>
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 rounded-xl {{ $meter->type == 'water' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        @if($meter->type == 'water')
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        @endif
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $meter->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($meter->status) }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $meter->meter_number }}</h3>
                                <p class="text-gray-500 mt-1 uppercase text-sm font-semibold tracking-wider">{{ $meter->type }}</p>
                                @if(Auth::user()->role === 'admin')
                                    <p class="text-sm mt-3 pt-3 border-t text-gray-600">User: <span class="font-medium">{{ $meter->user->name }}</span></p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No meters found</h3>
                        <p class="mt-2 text-gray-500">Get started by adding your first utility meter.</p>
                        <a href="{{ route('meters.create') }}" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            Add New Meter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
