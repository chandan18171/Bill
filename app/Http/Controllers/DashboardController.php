<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Bill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $properties = $user->role === 'admin' 
            ? Property::pluck('id') 
            : $user->properties()->pluck('id');

        $now = Carbon::now();
        
        // This Month vs Last Month Stats (Bills / Amount)
        $thisMonthStart = $now->copy()->startOfMonth();
        $thisMonthEnd = $now->copy()->endOfMonth();
        $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        $thisMonthBills = Bill::whereIn('property_id', $properties)
            ->whereBetween('billing_date', [$thisMonthStart, $thisMonthEnd])
            ->sum('amount');
            
        $lastMonthBills = Bill::whereIn('property_id', $properties)
            ->whereBetween('billing_date', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');

        $unpaidTotal = Bill::whereIn('property_id', $properties)->where('status', 'unpaid')->sum('amount');
        $propertiesCount = $properties->count();

        $monthExpr = DB::getDriverName() === 'sqlite' 
            ? "CAST(strftime('%m', reading_date) AS INTEGER)" 
            : "MONTH(reading_date)";

        // Monthly bar chart: Water vs Electricity usage for the current year
        $waterUsage = DB::table('water_readings')
            ->whereIn('property_id', $properties)
            ->whereYear('reading_date', $now->year)
            ->selectRaw("$monthExpr as month, SUM(units_consumed) as total")
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        $elecUsage = DB::table('electricity_readings')
            ->whereIn('property_id', $properties)
            ->whereYear('reading_date', $now->year)
            ->selectRaw("$monthExpr as month, SUM(units_consumed) as total")
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        $twelveMonthsLabels = [];
        $waterLineData = [];
        $elecLineData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $monthDate = $now->copy()->subMonths($i);
            $twelveMonthsLabels[] = $monthDate->format('M Y');
            
            $start = $monthDate->copy()->startOfMonth();
            $end = $monthDate->copy()->endOfMonth();
            
            $w = DB::table('water_readings')->whereIn('property_id', $properties)->whereBetween('reading_date', [$start, $end])->sum('units_consumed');
            $e = DB::table('electricity_readings')->whereIn('property_id', $properties)->whereBetween('reading_date', [$start, $end])->sum('units_consumed');
            
            $waterLineData[] = $w;
            $elecLineData[] = $e;
        }

        // For the bar chart (current year months)
        $barLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $barWater = [];
        $barElec = [];
        for($m=1; $m<=12; $m++) {
            $barWater[] = $waterUsage[$m] ?? 0;
            $barElec[] = $elecUsage[$m] ?? 0;
        }

        return view('dashboard', compact(
            'propertiesCount', 'unpaidTotal', 
            'thisMonthBills', 'lastMonthBills',
            'barLabels', 'barWater', 'barElec',
            'twelveMonthsLabels', 'waterLineData', 'elecLineData'
        ));
    }
}
