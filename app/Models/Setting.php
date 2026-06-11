<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'cage_id',
        'max_temperature',
        'min_humidity',
    ];

    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}
