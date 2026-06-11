<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actuator extends Model
{
    protected $fillable = [
        'name',
        'mode',
        'state'
    ];

    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
}
