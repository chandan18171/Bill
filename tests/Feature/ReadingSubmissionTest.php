<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;

class ReadingSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_water_reading()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id' => $user->id,
            'name' => 'Test House',
            'address' => '123 Test St',
            'meter_number' => 'WM-1001'
        ]);

        $response = $this->actingAs($user)->post("/water-readings", [
            'property_id' => $property->id,
            'reading_date' => now()->format('Y-m-d'),
            'previous_value' => 0,
            'current_value' => 1500,
            'unit_type' => 'litres'
        ]);

        $response->assertRedirect('/water-readings');
        $this->assertDatabaseHas('water_readings', [
            'property_id' => $property->id,
            'current_value' => 1500,
            'units_consumed' => 1500
        ]);
    }
}
