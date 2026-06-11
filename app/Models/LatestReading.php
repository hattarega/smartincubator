<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LatestReading extends Model
{
    protected $fillable = [
        'cage_id',
        'temperature_dht11',
        'humidity_dht11',
        'temperature_dht22',
        'humidity_dht22',
        'recorded_at',
    ];

    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}
