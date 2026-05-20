<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $properties = Auth::user()->role === 'admin' ? Property::all() : Auth::user()->properties;
        
        $propertyId = $request->input('property_id');
        $month = $request->input('month');
        $year = $request->input('year') ?? date('Y');
        
        $queryW = DB::table('water_readings')
            ->join('properties', 'water_readings.property_id', '=', 'properties.id')
            ->select('water_readings.*', 'properties.name as property_name', DB::raw("'Water' as utility_type"));
            
        $queryE = DB::table('electricity_readings')
            ->join('properties', 'electricity_readings.property_id', '=', 'properties.id')
            ->select('electricity_readings.*', 'properties.name as property_name', DB::raw("'Electricity' as utility_type"));
            
        if (Auth::user()->role !== 'admin') {
            $propIds = $properties->pluck('id');
            $queryW->whereIn('property_id', $propIds);
            $queryE->whereIn('property_id', $propIds);
        }

        if ($propertyId) {
            $queryW->where('water_readings.property_id', $propertyId);
            $queryE->where('electricity_readings.property_id', $propertyId);
        }
        
        if ($month) {
            $queryW->whereMonth('reading_date', $month);
            $queryE->whereMonth('reading_date', $month);
        }
        
        if ($year) {
            $queryW->whereYear('reading_date', $year);
            $queryE->whereYear('reading_date', $year);
        }
        
        $waterData = $queryW->get();
        $elecData = $queryE->get();
        
        $reports = $waterData->merge($elecData)->sortByDesc('reading_date');

        if ($request->has('export') && $request->input('export') == 1) {
            return Excel::download(new ReportsExport($reports), 'utility_report_' . date('Y_m_d') . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }
        
        return view('reports.index', compact('reports', 'properties', 'propertyId', 'month', 'year'));
    }
}
