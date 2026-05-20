<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Notifications\HighUsageNotification;
use App\Notifications\UnpaidBillNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckUsageThresholds extends Command
{
    protected $signature = 'tracker:check-thresholds';
    protected $description = 'Check user utility thresholds and unpaid bills to dispatch alerts.';

    public function handle()
    {
        $properties = Property::with('user', 'bills')->get();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        foreach ($properties as $property) {
            // Check Water Threshold
            if ($property->water_threshold) {
                $waterConsumed = DB::table('water_readings')
                    ->where('property_id', $property->id)
                    ->whereBetween('reading_date', [$startOfMonth, $endOfMonth])
                    ->sum('units_consumed');

                if ($waterConsumed > $property->water_threshold) {
                    $this->triggerAlert($property, 'water', $waterConsumed, $property->water_threshold);
                }
            }

            // Check Electricity Threshold
            if ($property->electricity_threshold) {
                $elecConsumed = DB::table('electricity_readings')
                    ->where('property_id', $property->id)
                    ->whereBetween('reading_date', [$startOfMonth, $endOfMonth])
                    ->sum('units_consumed');

                if ($elecConsumed > $property->electricity_threshold) {
                    $this->triggerAlert($property, 'electricity', $elecConsumed, $property->electricity_threshold);
                }
            }

            // Check Unpaid Bills
            foreach ($property->bills->where('status', 'unpaid') as $bill) {
                // Alert if it is past due or due in less than 3 days
                if (Carbon::parse($bill->due_date)->isPast() || Carbon::parse($bill->due_date)->diffInDays(Carbon::now()) <= 3) {
                    $property->user->notify(new UnpaidBillNotification($bill));
                }
            }
        }
        
        $this->info('Thresholds checked successfully.');
    }

    private function triggerAlert($property, $type, $consumed, $threshold) {
        $msg = "High {$type} Usage Alert: You have consumed {$consumed} units, exceeding your threshold of {$threshold}.";
        
        // Save to DB
        \App\Models\Alert::firstOrCreate([
            'property_id' => $property->id,
            'message' => $msg,
            'is_read' => false
        ]);

        // Send Email using Laravel Notification Mail Channel
        $property->user->notify(new HighUsageNotification($property, $type, $msg));
    }
}
