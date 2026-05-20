<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3 text-gray-800">
            <a href="{{ route('meters.index') }}" class="text-indigo-600 hover:text-indigo-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-2xl leading-tight">
                {{ __('Add New Meter') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8 relative">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-50 to-white rounded-bl-full -z-10"></div>
                <form action="{{ route('meters.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <x-input-label for="type" value="{{ __('Meter Type') }}" />
                            <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-gray-700 py-3" required autofocus>
                                <option value="electricity">Electricity</option>
                                <option value="water">Water</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>
                        
                        <div>
                            <x-input-label for="meter_number" value="{{ __('Meter Number') }}" />
                            <x-text-input id="meter_number" name="meter_number" type="text" class="mt-1 block w-full rounded-xl py-3 border-gray-300" required placeholder="e.g. ELEC-987654321" />
                            <x-input-error class="mt-2" :messages="$errors->get('meter_number')" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-3 px-8 text-lg font-semibold shadow-md transition transform hover:-translate-y-1">
                                {{ __('Register Meter') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
