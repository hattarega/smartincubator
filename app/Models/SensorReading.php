<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
        'cage_id',
        'type',
        'temperature',
        'humidity',
    ];

    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}
