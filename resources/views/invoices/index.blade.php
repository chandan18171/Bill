<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Invoices & Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-8">
                @if($invoices->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($invoices as $invoice)
                            <div class="bg-gradient-to-b from-white to-gray-50 rounded-2xl border {{ $invoice->status == 'unpaid' ? 'border-red-200 shadow-red-50' : 'border-green-200 shadow-green-50' }} p-6 shadow-md relative overflow-hidden group">
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Invoice #INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
                                        <h3 class="text-3xl font-bold text-gray-900">${{ number_format($invoice->amount_due, 2) }}</h3>
                                    </div>
                                    <span class="px-3 py-1 shadow-sm text-xs font-bold uppercase tracking-wider rounded-xl {{ $invoice->status == 'unpaid' ? 'bg-red-100 text-red-700 border-red-200' : 'bg-green-100 text-green-700 border-green-200' }} border">
                                        {{ $invoice->status }}
                                    </span>
                                </div>
                                
                                <div class="space-y-3 pt-4 border-t border-gray-100">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Reading Date:</span>
                                        <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($invoice->reading->reading_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Meter Number:</span>
                                        <span class="font-medium text-gray-900">{{ $invoice->reading->meter->meter_number }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Consumed Units:</span>
                                        <span class="font-medium text-gray-900">{{ number_format($invoice->reading->units_consumed, 2) }}</span>
                                    </div>
                                    @if(Auth::user()->role === 'admin')
                                        <div class="flex justify-between text-sm pt-2 mt-2 border-t border-gray-50">
                                            <span class="text-gray-500">Customer:</span>
                                            <span class="font-medium text-indigo-600">{{ $invoice->user->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($invoice->status == 'unpaid')
                                    <div class="mt-6">
                                        <button class="w-full bg-gray-900 hover:bg-gray-800 text-white font-semibold py-3 px-4 rounded-xl shadow-md transition transform hover:-translate-y-0.5">Pay Now</button>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <h3 class="mt-4 text-xl font-medium text-gray-900">No invoices generated</h3>
                        <p class="mt-2 text-gray-500">You're all caught up! There are no invoices to display.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
