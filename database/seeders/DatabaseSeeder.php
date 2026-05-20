<?php

namespace Database\Seeders;

use App\Models\Alert;
use App\Models\Bill;
use App\Models\ElectricityReading;
use App\Models\Property;
use App\Models\Tariff;
use App\Models\User;
use App\Models\WaterReading;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Tariff Rates
        Tariff::create(['type' => 'water', 'rate_per_unit' => 0.15]);
        Tariff::create(['type' => 'electricity', 'rate_per_unit' => 0.25]);

        // Demo User
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Demo Property
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Main Residence',
            'meter_number' => 'MTR-12345',
            'address' => '123 Utility Ave, Smart City'
        ]);

        // Sample Water Readings (3 months)
        for ($i = 3; $i >= 1; $i--) {
            WaterReading::create([
                'property_id' => $property->id,
                'reading_date' => Carbon::now()->subMonths($i)->format('Y-m-d'),
                'previous_value' => 100 * (4 - $i),
                'current_value' => 100 * (5 - $i),
                'units_consumed' => 100,
            ]);
        }

        // Sample Electricity Readings (3 months)
        for ($i = 3; $i >= 1; $i--) {
            ElectricityReading::create([
                'property_id' => $property->id,
                'reading_date' => Carbon::now()->subMonths($i)->format('Y-m-d'),
                'previous_value' => 500 * (4 - $i),
                'current_value' => 500 * (5 - $i),
                'units_consumed' => 500,
            ]);
        }

        // Sample Bill
        Bill::create([
            'property_id' => $property->id,
            'type' => 'electricity',
            'amount' => 500 * 0.25,
            'billing_date' => Carbon::now()->subMonth()->format('Y-m-d'),
            'due_date' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'status' => 'unpaid'
        ]);

        // Sample Alert
        Alert::create([
            'property_id' => $property->id,
            'message' => 'Your electricity bill is due soon!',
            'is_read' => false
        ]);
    }
}
