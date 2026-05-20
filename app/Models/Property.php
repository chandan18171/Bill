<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'meter_number', 'water_threshold', 'electricity_threshold'];

    public function user() { return $this->belongsTo(User::class); }
    public function waterReadings() { return $this->hasMany(WaterReading::class); }
    public function electricityReadings() { return $this->hasMany(ElectricityReading::class); }
    public function bills() { return $this->hasMany(Bill::class); }
    public function alerts() { return $this->hasMany(Alert::class); }
}
