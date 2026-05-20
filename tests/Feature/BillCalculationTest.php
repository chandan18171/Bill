<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use App\Models\Tariff;
use App\Services\BillCalculator;

class BillCalculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_bill_calculation_applies_correct_tax_and_slab()
    {
        Tariff::create(['type' => 'water', 'rate_per_unit' => 2.0]);
        
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Bill House',
            'address' => '456 Test Ave',
            'meter_number' => 'WM-9999'
        ]);

        $calculator = new BillCalculator();
        // 50 units * 2.0 (rate) = 100.
        // Tax 5% = 5.
        // Total = 105.
        $bill = $calculator->generateBill($property, 'water', 50);

        $this->assertEquals(105.00, $bill->amount);
        $this->assertEquals('water', $bill->type);
        $this->assertEquals('unpaid', $bill->status);
    }
    
    public function test_bill_calculation_applies_second_slab_multiplier()
    {
        Tariff::create(['type' => 'water', 'rate_per_unit' => 2.0]);
        
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Bill House 2',
            'address' => '789 Test Ave',
            'meter_number' => 'WM-8888'
        ]);

        $calculator = new BillCalculator();
        // Requesting 150 units.
        // Slab 1: 100 units * 2.0 = 200.
        // Slab 2: 50 units * (2.0 * 1.5 = 3.0) = 150.
        // Subtotal = 350.
        // Tax 5% = 17.5.
        // Total = 367.5.
        $bill = $calculator->generateBill($property, 'water', 150);

        $this->assertEquals(367.50, $bill->amount);
    }
}
