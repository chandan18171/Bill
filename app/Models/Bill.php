<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['property_id', 'type', 'amount', 'billing_date', 'due_date', 'status'];
    public function property() { return $this->belongsTo(Property::class); }
}
