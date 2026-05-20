<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3 text-gray-800">
            <a href="{{ route('readings.index') }}" class="text-indigo-600 hover:text-indigo-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl leading-tight">
                {{ __('Submit Meter Reading') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-white rounded-bl-full -z-10"></div>
                <form action="{{ route('readings.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="meter_id" value="{{ __('Select Meter') }}" />
                            <select id="meter_id" name="meter_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-gray-700 py-3" required autofocus>
                                @foreach($meters as $meter)
                                    <option value="{{ $meter->id }}">{{ $meter->meter_number }} ({{ ucfirst($meter->type) }})</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('meter_id')" />
                        </div>
                        
                        <div>
                            <x-input-label for="reading_date" value="{{ __('Reading Date') }}" />
                            <x-text-input id="reading_date" name="reading_date" type="date" class="mt-1 block w-full rounded-xl py-3 border-gray-300" required value="{{ date('Y-m-d') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('reading_date')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="previous_value" value="{{ __('Previous Value') }}" />
                                <x-text-input id="previous_value" name="previous_value" type="number" step="0.01" class="mt-1 block w-full rounded-xl py-3 border-gray-300" required placeholder="0.00" />
                                <x-input-error class="mt-2" :messages="$errors->get('previous_value')" />
                            </div>
                            <div>
                                <x-input-label for="current_value" value="{{ __('Current Value') }}" />
                                <x-text-input id="current_value" name="current_value" type="number" step="0.01" class="mt-1 block w-full rounded-xl py-3 border-gray-300" required placeholder="0.00" />
                                <x-input-error class="mt-2" :messages="$errors->get('current_value')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-3 px-8 text-lg font-semibold shadow-md transition transform hover:-translate-y-1">
                                {{ __('Submit Reading') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
