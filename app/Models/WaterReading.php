<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterReading extends Model
{
    protected $fillable = ['property_id', 'reading_date', 'previous_value', 'current_value', 'units_consumed'];
    public function property() { return $this->belongsTo(Property::class); }
}
