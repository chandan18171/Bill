<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['property_id', 'message', 'is_read'];
    public function property() { return $this->belongsTo(Property::class); }
}
