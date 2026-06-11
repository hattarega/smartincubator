<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cage extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'egg_count'
    ];

    public function users()
    {
        return $this->hasOne(User::class, 'cage_id');
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function latestReading()
    {
        return $this->hasOne(LatestReading::class);
    }

    public function sensorReadings()
    {
        return $this->hasMany(SensorReading::class);
    }

    public function actuators()
    {
        return $this->hasMany(Actuator::class);
    }
}
