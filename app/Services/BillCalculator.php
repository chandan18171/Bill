<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Tariff;
use App\Models\Property;
use Carbon\Carbon;

class BillCalculator
{
    /**
     * Generate a bill dynamically based on a given number of units and tariff
     */
    public function generateBill(Property $property, string $type, float $totalUnits)
    {
        $tariff = Tariff::where('type', $type)->first();
        if (!$tariff) {
            throw new \Exception("No tariff configured for {$type}");
        }

        $rate = $tariff->rate_per_unit;
        $subtotal = 0;
        
        // Slab-based tariff simulation based on base rate
        // Slab 1: 0 - 100 units = base rate
        // Slab 2: 101 - 300 units = base rate * 1.5
        // Slab 3: > 300 units = base rate * 2.0
        
        if ($totalUnits <= 100) {
            $subtotal += $totalUnits * $rate;
        } elseif ($totalUnits <= 300) {
            $subtotal += (100 * $rate); // Slab 1
            $subtotal += (($totalUnits - 100) * ($rate * 1.5)); // Slab 2
        } else {
            $subtotal += (100 * $rate); // Slab 1
            $subtotal += (200 * ($rate * 1.5)); // Slab 2
            $subtotal += (($totalUnits - 300) * ($rate * 2.0)); // Slab 3
        }

        // Add 5% tax
        $tax = $subtotal * 0.05;
        $totalAmount = $subtotal + $tax;

        $bill = Bill::create([
            'property_id' => $property->id,
            'type' => $type,
            'amount' => $totalAmount,
            'billing_date' => Carbon::now()->format('Y-m-d'),
            'due_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'status' => 'unpaid'
        ]);

        return $bill;
    }
}
